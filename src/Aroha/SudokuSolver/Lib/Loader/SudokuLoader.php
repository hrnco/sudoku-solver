<?php
/**
 * Created by PhpStorm.
 * User: hrnci
 * Date: 21. 7. 2018
 * Time: 14:39
 */

namespace Aroha\SudokuSolver\Lib\Loader;

use Aroha\SudokuSolver\Lib\Data\Sudoku;
use Aroha\SudokuSolver\Lib\Data\SudokuBlock;
use Aroha\SudokuSolver\Lib\Data\SudokuCeil;
use Aroha\SudokuSolver\Lib\Data\SudokuColumn;
use Aroha\SudokuSolver\Lib\Data\SudokuRow;

class SudokuLoader {

    /**
     * @param array $data
     * @return Sudoku
     */
    public function createSudokuFromArray($data) {
        $ceils = [];
        $ceil_index = 0;
        $columns = [];
		foreach($data as $row_index => $data_row) {
			$row = new SudokuRow($row_index+1);
			foreach($data_row as $column_index => $ceil) {
                $ceil_index++;
                $ceil = new SudokuCeil($ceil, $ceil_index);
                $block_index = SudokuBlock::getBlockIndex($ceil_index);
                if (!isset($columns[$column_index+1])) {
                    $columns[$column_index+1] = new SudokuColumn($column_index+1);
                }
                if (!isset($blocks[$block_index])) {
                    $blocks[$block_index] = new SudokuBlock($block_index);
                }
				$ceil->row($row);
                $ceil->column($columns[$column_index+1]);
                $ceil->block($blocks[$block_index]);
                $ceils[$ceil_index] = $ceil;
			}
		}
        return new Sudoku($ceils);
	}

}