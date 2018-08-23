<style>
    table td {
        border-style: solid;
        width: 35px;
        height: 35px;
        text-align: center;
        vertical-align: middle;
    }
    .block_1, .block_3, .block_5, .block_7, .block_9 {
        background-color: antiquewhite;
    }
    .block_2, .block_4, .block_6, .block_8 {
        background-color: lightgray;
    }
    .block_new {
        color: crimson;
        font-weight: bold;
    }
    .block_original {
    }
</style>
<?php
define('APP_DIR', dirname(__DIR__));
ini_set('max_execution_time', 600);

$autoloadFile = APP_DIR . '/vendor/autoload.php';
$loader = require_once $autoloadFile;
$loader->addPsr4('Aroha\\SudokuSolver\\', APP_DIR.'/src/Aroha/SudokuSolver');

$sudokuLoader = new \Aroha\SudokuSolver\Lib\Loader\SudokuLoaderCsv();
$sudoku = $sudokuLoader->createSudokuFromCsv(__DIR__.'/example3.csv');

$sudoku->printTable(true);
$sudoku->solver();
$sudoku->printTable();