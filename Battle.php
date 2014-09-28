<?php
/**
 * The battle between the candidates, could have multiple Rounds
 */
class Battle implements Record
{
	private $player1;
	private $player2;
	private $battle_result = array();

	function __construct(Candidate $c1, Candidate $c2)
	{
		$this->player1 = $c1;
		$this->player2 = $c2;
	}

	function start()
	{
		$round_num = 1;

		while(1)
		{
			// Reset the player's attack counts for the new round:
			$this->player1->resetAttacks();
			$this->player2->resetAttacks();

			// Battle ends:
			if($this->player1->getHealth() <= 0)
			{
				$this->record('Winner', $this->player2->getName());
				break;
			} 

			if($this->player2->getHealth() <=0)
			{
				$this->record('Winner', $this->player1->getName());
				break;
			} 

			// Start a new round:
			$round = new BattleRound($this->player1, $this->player2);
			$round->play();

			$round_result = $round->getRecord();

			$this->record($round_num, $round_result);
			$round_num++;
		}
	}

	function record($round_num, $round_result)
	{
		$this->battle_result[$round_num] = $round_result;
	}

	function getRecord()
	{
		return $this->battle_result;
	}
}

