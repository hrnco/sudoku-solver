<?php
/**
 * Created by PhpStorm.
 * User: hrnci
 * Date: 19. 8. 2018
 * Time: 21:45
 */

namespace Aroha\SudokuSolver\Lib\Data;


abstract class AbstractSudokuBlock
{
    private $index;

    public function __construct($index)
    {
        $this->index($index);
    }

    /**
     * @param integer|null $index
     *
     * @return SudokuRow|integer
     */
    public function index($index = NULL) {
        if ($index) {
            $this->index = $index;
        }
        return $this->index;
    }
}