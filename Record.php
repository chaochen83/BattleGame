<?php
/**
 * For recording the battle result
 */
interface Record
{
	/**
	 * Do record
	 * @param  string/int $index  [key for the record array]
	 * @param  array/string $result [value of the record array]
	 */
	function record($index, $result);

	/**
	 * Get record
	 * @return [array] 
	 */
	function getRecord();
}

