<?php
use Aroha\SudokuSolver\Loader\SudokuLoaderCsv;
require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/html_before.html';

$sudokuLoader = new SudokuLoaderCsv();

echo '<h1>example</h1>';
$sudoku = $sudokuLoader->createSudokuFromCsv(__DIR__.'/examples/example3.csv');
$sudoku->printTable(true);
$sudoku->solver();
$sudoku->printTable();

require __DIR__ . '/html_after.html';
