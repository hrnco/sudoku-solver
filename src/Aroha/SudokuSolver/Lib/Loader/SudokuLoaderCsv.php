<?php
/**
 * Created by PhpStorm.
 * User: hrnci
 * Date: 21. 7. 2018
 * Time: 14:39
 */

namespace Aroha\SudokuSolver\Lib\Loader;

use Aroha\SudokuSolver\Lib\Data\Sudoku;

class SudokuLoaderCsv {

    /**
     * @param $csv_file
     * @param string $delimiter
     * @return Sudoku
     */
	public function createSudokuFromCsv($csv_file, $delimiter = ';') {
		$loader = new SudokuLoader();
		$rows = [];
		foreach(explode("\n", file_get_contents($csv_file)) as $row) {
			$rows[] = str_getcsv($row, $delimiter);
		}
		$data = [];
		foreach($rows as $index => $row) {
			if (count($row) == 9) {
				$data_row = [];
				foreach($row as $ceil) {
					$data_row[] = (int)$ceil;
				}
				$data[] = $data_row;
			}
		}
		return $loader->createSudokuFromArray($data);
	}

}