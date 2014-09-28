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

	function __construct($name, $health, $damage, $attacks, $dodge=0, $critical=0, $initiative=0)
	{
		$this->name = $name;
		$this->health = $health;
		$this->damage = $damage;
		$this->attacks = $this->fixed_attacks = $attacks;
		$this->dodge = $dodge;
		$this->critical = $critical;
		$this->initiative = $initiative;
	}

	function attack()
	{
		$this->attacks--;

		$dice = rand(0, 100);

		return $dice < $this->critical ? $this->damage * 2 : $this->damage;	// Implement Critical
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
}

