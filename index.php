<?php
/**
 * Autoload the required classes
 * @param  string $classname [Required Class]
 */
function __autoload($classname)
{
	$classpath="./".$classname.'.php';

	if(file_exists($classpath)){
		require_once($classpath);
	}
	else{
		echo 'class file'.$classpath.'not found!';
	}
}


// Client Side of Code:
$game = new Game;
$game->loadData('applicants.csv.csv');
$game->play();

// Output as JSON:
// $game->outputJSON(2);

// Output as readable:
$game->outputReadable(1);

