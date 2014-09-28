<?php

abstract class AttackStrategy
{
	abstract function attack(Candidate $candidate);
}

// abstract class DefendStrategy
// {
// 	abstract function defend(Canditate $canditate);
// }

/**
 * Implement Critical Attack Strategy:
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