<?php
/**
 * Created by PhpStorm.
 * User: hrnci
 * Date: 21. 7. 2018
 * Time: 14:39
 */

namespace Aroha\SudokuSolver\Data;


class SudokuCeil {

    private $value, $row, $block, $column, $index, $possibles, $original = false;

	public function __construct($value, $index)
    {
        $this->value($value);
        $this->index($index);
    }

    /**
     * @return SudokuCeilPossibles
     */
    public function possibles() {
        if (!$this->possibles) {
            $this->possibles = new SudokuCeilPossibles();
        }
        return $this->possibles;
    }

    /**
	 * @param SudokuRow|null $row
	 *
	 * @return SudokuRow
	 */
	public function row(SudokuRow $row = NULL) {
		if ($row) {
			$this->row = $row;
		}
		return $this->row;
	}

	/**
	 * @param SudokuBlock|null $block
	 *
	 * @return SudokuBlock
	 */
	public function block(SudokuBlock $block = NULL) {
		if ($block) {
			$this->block = $block;
            return $this;
		}
		return $this->block;
	}

	/**
	 * @param SudokuColumn|null $column
	 *
	 * @return SudokuColumn
	 */
	public function column(SudokuColumn $column = NULL) {
		if ($column) {
			$this->column = $column;
			return $this;
		}
		return $this->column;
	}

    /**
     * @param integer|null $index
     *
     * @return SudokuCeil|integer
     */
    public function index($index = NULL) {
        if ($index) {
            $this->index = $index;
        }
        return $this->index;
    }


    /**
     * @param boolean|null $original
     *
     * @return SudokuCeil|integer
     */
    public function original($original = NULL) {
        if ($original) {
            $this->original = $original;
        }
        return $this->original;
    }

    /**
     * @param integer|null $value
     *
     * @return SudokuCeil|integer
     */
    public function value($value = NULL) {
        if ($value) {
            $this->value = $value;
            $this->possibles()->set([$value => $value]);
        }
        return $this->value;
    }

}