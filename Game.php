<?php
interface GameOutputJSON
{
	// Output JSON format game data:
	function outputJSON($game_num);
}

interface GameOutputReadable
{
	// Output readable format game data:
	function outputReadable($game_num);
}

interface GameWinCount
{
	function winCount();
}

/**
 * This is the Game Control
 * 
 * Game can have different output methods like JSON or Readable, using recorded game data
 */
class Game implements GameOutputJSON, GameOutputReadable
{
	private $candidates = array();
	private $record = array();

	function loadData($file)
	{
		$this->candidates = ReadCSV::read($file);
	}

	function play()
	{
		$candidates_count = count($this->candidates);

		// Each candidate should fight with every other candidates in the CSV, ignore the 1st row in the CSV:
		for($i = 1; $i < $candidates_count; $i++)
		{
			for($j = $i + 1; $j < $candidates_count; $j++)
			{
				// Creating 2 candidates for the game, using Critical Attack as the Attack Strategy:
				$c1 = new Candidate($this->candidates[$i][0], $this->candidates[$i][1], $this->candidates[$i][2], $this->candidates[$i][3], $this->candidates[$i][4], $this->candidates[$i][5], $this->candidates[$i][6], new CriticalAttackStrategy() );
				$c2 = new Candidate($this->candidates[$j][0], $this->candidates[$j][1], $this->candidates[$j][2], $this->candidates[$j][3], $this->candidates[$i][4], $this->candidates[$i][5], $this->candidates[$i][6], new CriticalAttackStrategy());	

				// Put the 2 candidates to battle:
				$battle = new Battle($c1, $c2);
				$battle->start();

				// For debug, print the battle record, can use it in other way:
				$this->record[] = $battle->getRecord();
			}
		}		
	}

	function outputJSON($game_num=false)
	{
		// Can show single game or all games: 
		if(!$game_num or !$this->record[$game_num]) $ret = $this->record;
		else $ret = $this->record[$game_num];

		echo json_encode($ret);
	}

	function outputReadable($game_num=false)
	{
		// Can only show single game:
		if(!$game_num or !$this->record[$game_num]) return;

		$game_record = $this->record[$game_num];	

		foreach ($game_record as $key => $round_record) 
		{
			echo 'Round '.$key.'</br>';

			if(is_array($round_record))
			{
				foreach ($round_record as $value) 
				{
					echo $value['AttackerName'].' hits '.$value['DefenderName'].' for '.$value['AttackerDamage'].' damage ('.$value['DefenderStartHealth'].' -> '.$value['DefenderEndHealth'].')'.'</br>';
				}				
			}
		}	

		echo $game_record['Winner'];
	}
}