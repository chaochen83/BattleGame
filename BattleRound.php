<?php
/**
 * A round between the candidates, could have multiple Fights
 */
class BattleRound implements Record
{
	private $current_attacker;
	private $current_defender;
	private $round_result = array();

	function __construct(Candidate $can_1, Candidate $can_2)
	{
		$this->setSequence($can_1, $can_2);
	}

	/**
	 * Decide which candidate should attack first:
	 */
	function setSequence(Candidate $can_1, Candidate $can_2)
	{
		$dice = rand(1,10) % 2;  
		$this->current_attacker = ($dice == 0) ? $can_1 : $can_2;
		$this->current_defender = ($dice == 1) ? $can_1 : $can_2;
	}

	/**
	 * A fight between the candidates
	 * @param  Candidate $attacker [the candidate who is attacking]
	 * @param  Candidate $defender [the candidate who is being attacked]
	 * @return [array]             [the data of the fight, for recording]
	 */
	function fight(Candidate $attacker, Candidate $defender)
	{
		$fight_result = array();
		$fight_result['DefenderStartHealth'] = $defender->getHealth();

		$damage = $attacker->attack();

		$defender->defend($damage);

		$fight_result['AttackerName'] = $attacker->getName();
		$fight_result['DefenderName'] = $defender->getName();
		$fight_result['AttackerDamage'] = $damage;
		$fight_result['DefenderEndHealth'] = $defender->getHealth();

		return $fight_result;
	}

	/**
	 * The logic of a Round
	 */
	function play()
	{
		$fight_num = 1;

		while (1) 
		{
			// The attacker used all his attacks in this round:
			if($this->current_attacker->getAttacks() <= 0 and $this->current_defender->getAttacks() <= 0) break;

			// Someone is dead:
			if($this->current_attacker->getHealth() <= 0 or $this->current_defender->getHealth() <=0) break;

			// Attack!
			if($this->current_attacker->getAttacks() > 0) 
			{
				$fight_result = $this->fight($this->current_attacker, $this->current_defender);

				$this->record($fight_num, $fight_result);
			}
			
			// Switch attacker and defender:
			$temp = $this->current_defender;
			$this->current_defender = $this->current_attacker;
			$this->current_attacker = $temp;

			$fight_num++;
		}
	}

	function record($fight_num, $fight_result)
	{
		$this->round_result[$fight_num] = $fight_result;
	}

	function getRecord()
	{
		return $this->round_result;
	}
}



