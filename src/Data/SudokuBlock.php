<?php
/**
 * Created by PhpStorm.
 * User: hrnci
 * Date: 21. 7. 2018
 * Time: 14:38
 */

namespace Aroha\SudokuSolver\Data;


class SudokuBlock extends AbstractSudokuBlock {

	private static $indexes = [

        [  1,  2,  3, 10, 11, 12, 19, 20, 21],
        [  4,  5,  6, 13, 14, 15, 22, 23, 24],
        [  7,  8,  9, 16, 17, 18, 25, 26, 27],
        [ 28, 29, 30, 37, 38, 39, 46, 47, 48],
        [ 31, 32, 33, 40, 41, 42, 49, 50, 51],
        [ 34, 35, 36, 43, 44, 45, 52, 53, 54],
        [ 55, 56, 57, 64, 65, 66, 73, 74, 75],
        [ 58, 59, 60, 67, 68, 69, 76, 77, 78],
        [ 61, 62, 63, 70, 71, 72, 79, 80, 81],

	];

	public static function getBlockIndex($ceil_index) {
	    foreach(self::$indexes as $block_index => $ceil_indexes) {
            if (array_search($ceil_index, $ceil_indexes) !== false) {
                return $block_index+1;
            }
        }
    }

}