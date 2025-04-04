<?php

namespace Src\Config\Utils;

/** Create different kind of messages, instanciate them in a list and redirect
 */
class Utils
{
	// fonciton pournrécupérer la classe ayant initialisé le message
	public static function get_calling_class()
	{
		//get the trace
		$trace = debug_backtrace();

		// Get the class that is asking for who awoke it
		$class = (isset($trace[1]['class']) ? $trace[1]['class'] : NULL);

		// +1 to i cos we have to account for calling this function
		for ($i = 1; $i < count($trace); $i++) {
			if (isset($trace[$i]) && isset($trace[$i]['class'])) // is it set?
				if ($class != $trace[$i]['class']) // is it a different class
					return $trace[$i]['class'];
		}
	}

	/**
	 * Compare deux tableaux et renvoie les différences (ajouts et suppressions).
	 *
	 * @param array $ancienTab L'ancien tableau de référence.
	 * @param array $nouveauTab Le nouveau tableau à comparer.
	 * @return array Tableau contenant les ajouts et suppressions.
	 */
	public static function comparer_tableaux(array $ancienTab, array $nouveauTab): array
	{
		$ajouts = [];
		$suppressions = [];

		foreach ($ancienTab as $cle => $valeur) {
			if (!isset($nouveauTab[$cle])) $suppressions[$cle] = $valeur;
			else {
				foreach ($valeur as $subval) {
					if (!in_array($subval, $nouveauTab[$cle])) $suppressions[$cle][] = $subval;
				}
			}
		}
		foreach ($nouveauTab as $cle => $valeur) {
			if (!isset($ancienTab[$cle])) $ajouts[$cle] = $valeur;
			else {
				foreach ($valeur as $subval) {
					if (!in_array($subval, $ancienTab[$cle])) $ajouts[$cle][] = $subval;
				}
			}
		}

		return [
			'ajouts' => $ajouts,
			'suppressions' => $suppressions
		];
	}
	static function multi_implode($array, $glue)
	{
		$ret = '[';
		$is_associative = array_keys($array) !== range(0, count($array) - 1);

		foreach ($array as $key => $item) {
			if ($is_associative) $ret .= "'" .$key . "'=>";
			if (is_array($item)) {
				$ret .= Utils::multi_implode($item, $glue) . $glue;
			} else {
				$processed_item = $item;
				if (is_string($item)) $processed_item = "'" . $item . "'";
				$ret .= $processed_item . $glue;
			}
		}

		$ret = substr($ret, 0, 0 - strlen($glue));

		return $ret . "]";
	}
}
