<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



////////////////////////////////////// Variable defination & initialization ////////////////////////////////
define('DIMENSION', 5); // 5X5 board

$player_one_marker = 'X';
$player_two_marker = 'Y';


$board = array(); // array of columns
for ($col = 0; $col < DIMENSION; $col++) {
	$board[$col] = array();
	for ($row = 0; $row < DIMENSION; $row++) {
		$board[$col][$row] = 0;
	}
}

////////////////////////////////////// Main function call ////////////////////////////////
begin_game($board,$player_one_marker,$player_two_marker);
print_board($board);

function begin_game(&$board,$player_one_marker,$player_two_marker) {
	$turn = false;
	for ($i = 0; $i < (DIMENSION * DIMENSION); $i++) {

		if ($turn) {
			do_move($board, $player_one_marker);
			if (player_won($board) == true) {
				echo "Player $player_one_marker wins" . "\n";
				return;
			}
		} else {
			do_move($board, $player_two_marker);
			if (player_won($board) == true) {
				echo "Player $player_two_marker wins" . "\n";
				return;
			}
		}
		$turn = !$turn;
	}
	
	echo "DRAW" . "\n";
}

/**
 * Print the board
 * @param array $board
 */
function print_board($board) {
	for ($row = 0; $row < DIMENSION; $row++) {
		$row_val = '';
		for ($col = 0; $col < DIMENSION; $col++) {
			$row_val .= $board[$row][$col] . ", ";
		}
		echo $row_val . "\n";
	}
}

//do_move($board, $player1_mark);
//do_move($board, $player2_mark);
//print_board($board);

/**
 * insert player move on the board
 * @param array(array) $board
 * @param string $player_mark
 */
function do_move(&$board, $player_mark) {

	// TODO is full
	$value_placed = false;
	while ($value_placed == false) {
		$temp_row = rand(0, DIMENSION - 1);
		$temp_col = rand(0, DIMENSION - 1);

		if (empty($board[$temp_row][$temp_col])) {
			$value_placed = true;
			$board[$temp_row][$temp_col] = $player_mark;
		}
	}
}


/**
 * check to see if a there is a winning case
 * @param array(array) $board
 * @return boolean
 */
function player_won($board) {

	// check all rows
	for ($row = 0; $row < DIMENSION; $row++) {
		$row_val = '';
		for ($col = 0; $col < DIMENSION; $col++) {
			$row_val .= $board[$row][$col];
		}
		if (connect_4($row_val) == true) {
			return true;
		}
	}
	// check all columns
	for ($col = 0; $col < DIMENSION; $col++) {
		$col_val = array_column_str($board, $col);
		if (connect_4($col_val) == true) {
			return true;
		}
	}
	
	// check diagonals (check increment of index 1 for row and col)
	// this will be something like check [0,0],[1,1],[2,2],[3,3];
	// this will be something like check [0,1],[1,2],[2,3],[3,4];
	
	// $dia_str = extract diagonal str and 
//	if (connect_4($dia_str) == true) {
//		return true;
//	} 
	return false;
}

//var_dump(connect_4('YYXYY'));
//var_dump(connect_4('YYXYY'));
//var_dump(connect_4('YYYYY'));
//var_dump(connect_4('YYYYX'));
//var_dump(connect_4('XYYYY'));
//var_dump(connect_4('XYXYYXYXYYXYYYY'));
//var_dump(connect_4('YYXYY'));

/**
 * given a string check to see if there is a set of four same consecutive string
 * @param string $str
 * @return boolean
 */
function connect_4($str) {

	if (preg_match("/0/", $str)) {
		return false;
	}
	if (strlen($str) < 4) {
		return false;
	}

	$str_array = str_split($str);
	$consecutive_length = 1;
	for ($i = 0; $i < count($str_array) - 1; $i++) {
		if ($str_array[$i] == $str_array[$i + 1]) {
			$consecutive_length++;
			if ($consecutive_length == 4) {
				return true;
			}
		} else {
			$consecutive_length = 1;
		}
	}

	return false;
}



/**
 * 
 * given column index return the column str
 * @param array $array
 * @param index $column
 * @return str
 */
function array_column_str($array, $column)
{
    $ret = array();
    foreach ($array as $row) {
		$ret[] = $row[$column];
	}
	return implode('',$ret);
}