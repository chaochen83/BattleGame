<?php
/**
 * Return the CSV content as array
 */
class ReadCSV
{
	static function read($file)
	{
		$result = array();

		$file = fopen($file,"r");

		while(! feof($file))
		{
			$row = fgetcsv($file);
			if($row) $result[] = $row;
		}
		fclose($file);

		return $result;
	}

}