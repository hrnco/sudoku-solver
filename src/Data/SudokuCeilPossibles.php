<?php
/**
 * Created by PhpStorm.
 * User: hrnci
 * Date: 19. 8. 2018
 * Time: 22:11
 */

namespace Aroha\SudokuSolver\Data;


class SudokuCeilPossibles
{
    private $possibles = [ 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9 ];

    public function set($set) {
        $this->possibles = $set;
    }

    public function remove($value) {
        if (!isset($this->possibles[$value])) {
            return;
        }
        unset($this->possibles[$value]);
    }

    public function count() {
        return count($this->possibles);
    }

    public function get() {
        if ($this->count() == 1) {
            return end($this->possibles);
        }
        return $this->possibles;
    }

}