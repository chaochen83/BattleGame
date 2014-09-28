<?php
/**
 * Attack Strategy, for calculating attack damages
 */
abstract class AttackStrategy
{
	abstract function attack(Candidate $candidate);
}

/**
 * Critical Attack Strategy: based on candidate's critical points, chance to deal double damages
 * @return attacker's damage in a fight
 */
class CriticalAttackStrategy extends AttackStrategy
{
	function attack(Candidate $candidate)
	{
		$dice = rand(0, 100);

		if($dice < $candidate->getCritical())
		{
			return $candidate->getDamage() * 2;
		}
		else
		{
			return $candidate->getDamage();
		}
	}
}