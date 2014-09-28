<?php
/**
 * Candidate class
 */
class Candidate
{
	private $name;
	private $health;
	private $damage;
	private $attacks;
	private $dodge;
	private $critical;
	private $initiative;

	private $fixed_attacks;

	private $attack_strategy;

	function __construct($name, $health, $damage, $attacks, $dodge=0, $critical=0, $initiative=0, AttackStrategy $attack_strategy)
	{
		$this->name = $name;
		$this->health = $health;
		$this->damage = $damage;
		$this->attacks = $this->fixed_attacks = $attacks;
		$this->dodge = $dodge;
		$this->critical = $critical;
		$this->initiative = $initiative;

		$this->attack_strategy = $attack_strategy;
	}

	function attack()
	{
		$this->attacks--;

		return $this->attack_strategy->attack($this);	// Implement Attack Strategy
	}

	function defend($damage)
	{
		$dice = rand(0, 100);

		if($dice >= $this->dodge) $this->health -= $damage;	// Implement Dodge
	}

	function getName()
	{
		return $this->name;
	}

	function getHealth()
	{
		return $this->health;
	}

	function getAttacks()
	{
		return $this->attacks;
	}

	/**
	 * Reset the candidate's attack count for the new round
	 * @return [int] [the candidate's default attacks count]
	 */
	function resetAttacks()
	{
		$this->attacks = $this->fixed_attacks;
	}

	/**
	 * For attack / defend strategies:
	 */
	function getCritical()
	{
		return $this->critical;
	}

	function getDamage()
	{
		return $this->damage;
	}

	function getDodge()
	{
		return $this->dodge;
	}

	function setHealth($health)
	{
		$this->health = $health;
	}
}

