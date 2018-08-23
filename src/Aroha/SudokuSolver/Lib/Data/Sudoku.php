<?php
/**
 * Created by PhpStorm.
 * User: hrnci
 * Date: 21. 7. 2018
 * Time: 13:51
 */

namespace Aroha\SudokuSolver\Lib\Data;


class Sudoku {

    private $ceils, $rows = [], $blocks = [], $columns = [];
    private $countToFind = 0;
    private $startMicrotime = false;

    public function __construct($ceils)
    {
        $this->startMicrotime = microtime(true);
        $this->ceils = $ceils;
        foreach($ceils as $ceil) {
            if (!$ceil->value()) {
                $this->countToFind++;
            }
            $this->rows[$ceil->row()->index()][] = $ceil;
            $this->columns[$ceil->column()->index()][] = $ceil;
            $this->blocks[$ceil->block()->index()][] = $ceil;
        }
    }

    /**
     * @return SudokuCeil
     */
    public function ceils() {
        return $this->ceils;
    }

    /**
     * @param integer $index
     *
     * @return SudokuCeil|array
     */
    public function ceil($index) {
        return $this->ceils[$index];
    }

    public function getTable() {
        $ceils = $this->ceils();
        $table = [];
        foreach($ceils as $ceil) {
            if (!isset($table[$ceil->row()->index()])) {
                $table[$ceil->row()->index()] = [];
            }
            $table[$ceil->row()->index()][] = $ceil;
        }
        return $table;
    }

    public function toArray() {
        $table = $this->getTable();
        $rows = [];
        foreach($table as $objRow) {
            $row = [];
            foreach($objRow as $ceil) {
                $row[] = $ceil->value();
            }
            $rows[] = $row;
        }
        return $rows;
    }

    public function createClone() {
        $sudokuLoader = new \Aroha\SudokuSolver\Lib\Loader\SudokuLoader();
        return $sudokuLoader->createSudokuFromArray($this->toArray());
    }

    public function calcCeil(SudokuCeil $ceil) {
        if ($ceil->value()) {
            if ($ceil->possibles()->count() > 1) {
                $this->countToFind--;
                $ceil->possibles()->set([$ceil->value() => $ceil->value()]);
            }
            return;
        }
        foreach($this->rows[$ceil->row()->index()] as $fCeil) {
            if ($fCeil->value()) {
                $ceil->possibles()->remove($fCeil->value());
            }
        }
        foreach($this->blocks[$ceil->block()->index()] as $fCeil) {
            if ($fCeil->value()) {
                $ceil->possibles()->remove($fCeil->value());
            }
        }
        foreach($this->columns[$ceil->column()->index()] as $fCeil) {
            if ($fCeil->value()) {
                $ceil->possibles()->remove($fCeil->value());
            }
        }
        if ($ceil->possibles()->count() == 1) {
            $this->countToFind--;
            $ceil->value($ceil->possibles()->get());
        }
    }

    public function sortByPossibles($ceils) {
        $sorted = [];
        $sortedKeys = [];
        foreach($ceils as $ceil) {
            if ($ceil->value()) {
                continue;
            }
            if ($ceil->possibles()->count() == 1) {
                continue;
            }
            if ($ceil->possibles()->count() > 3) {
                continue;
            }
            if (!isset($sortedKeys[$ceil->possibles()->count()])) {
                $sortedKeys[$ceil->possibles()->count()] = [];
            }
            $sortedKeys[$ceil->possibles()->count()][] = $ceil;
        }
        ksort($sortedKeys);

        foreach($sortedKeys as $sortedCeils) {
            foreach($sortedCeils as $ceil) {
                $sorted[] = $ceil;
            }
        }
        return $sorted;
    }

    public function solveWithAlternatives($sortedByPossibles, $alternativesLevel) {
        foreach($sortedByPossibles as $sortedByPossible) {
            foreach($sortedByPossible->possibles()->get() as $value) {
                $sudoku = $this->createClone();
                $ceil = $sudoku->ceil($sortedByPossible->index());
                if ($ceil->possibles()->count() > 1) {
                    $sudoku->countToFind--;
                }
                $ceil->value($value);
                $sudoku->solver($alternativesLevel+1);
                if ($sudoku->countToFind == 0) {
                    foreach($sudoku->ceils() as $ceil) {
                        $this->ceil($ceil->index())->value($ceil->value());
                    }
                    return true;
                }

            }
        }
    }

    public function solver($alternativesLevel = 1) {

        while ($this->countToFind > 0 && $this->getSeconds() < 10) {

            $countToFindBefore = $this->countToFind;
            foreach($this->ceils() as $ceil) {
                $this->calcCeil($ceil);
            }

            if($countToFindBefore == $this->countToFind) {
                if ($alternativesLevel <= 2) {
                    $sortedByPossibles = $this->sortByPossibles($this->ceils());
                    $solved = $this->solveWithAlternatives($sortedByPossibles, $alternativesLevel);
                    if ($solved) {
                        $this->countToFind = 0;
                    }
                }
                return;
            }

        }

    }

    public function getSeconds() {
        return microtime(true) - $this->startMicrotime;
    }

    public function printTable($setAllValuesAsOriginal = false) {
        $table = $this->getTable();
        $html = [];
        $html[] = 'time: '.round($this->getSeconds(), 2).' sec';
        $html[] = '<table>';
        foreach($table as $row) {
            $html[] = '<tr>';
            foreach($row as $ceil) {
                if ($setAllValuesAsOriginal && $ceil->value()) {
                    $ceil->original(true);
                }
                $html[] = '<td class="'.($ceil->original() ? 'block_original ' : 'block_new ').'block_'.$ceil->block()->index().' row_'.$ceil->row()->index().' column_'.$ceil->column()->index().'">'
                    .$ceil->value()
                    .'</td>';
            }
            $html[] = '</tr>';
        }
        $html[] = '</table>';
        $html[] = '<hr />';
        echo implode("\n", $html);
    }

}