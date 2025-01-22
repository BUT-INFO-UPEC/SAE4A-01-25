<?php

namespace Src\Model\DataObject;

/**
 * Description de la classe
 */
class Requette_API
{
	// =======================
	//        ATTRIBUTES
	// =======================
	#region Attributs
	private $select = [];
	private $where;
	#endregion Attributs

	// =======================
	//      CONSTRUCTOR
	// =======================


	// =======================
	//      GETTERS
	// =======================
	#region Getters

	#endregion Getters


	// =======================
	//      SETTERS
	// =======================
	#region Stters
	public function setconditions(array $tab)
	{
		$this->where = $tab;
	}
	#endregion Stters


	// =======================
	//    PUBLIC METHODS
	// =======================
	#region Publiques
	/**
	 * @param Stringable $atribute
	 * @param Stringable|null $agregation=null
	 * 
	 * @return void
	 */
	public function addSelect(String $atribute, ?String $agregation = null): void
	{
		if (isset($agregation)) {
			array_push($this->select, $agregation . "(" . $atribute . ")");
		} else {
			array_push($this->select, $atribute);
		}
	}

	/**
	 * @return Stringable l'URL (encodé) de la requette
	 */
	public function buildRequest(): String
	{
		$selectString = "";
		foreach ($this->select as $value) {
			$selectString .= $value;
		}
		return "/?select=" . $selectString . "&where=" . $this->buildConditions();
	}
	#endregion Publiques


	// =======================
	//    PRIVATE METHODS
	// =======================
	#region Privees

	/**
	 * 
	 * 
	 * Prends en entrée un tableau structuré avec un mot clé et une liste de tableau binaires ou trinaires recursifs avec la même structure. Si le mot clé est "or" ou "and", c'est un binaire, on construit la liste sous-jascente avec la porte logique correspondant, sinon, c'est une clé qui doit convenir a la ou les valeurs du troisiemme element avec la comparaison logique précisée dans le deuxiemme element:
	 * ["or", [
	 *         ["or",[
	 *                ["and",[
	 *                        ["num_sta", ">", [1, 2, 3]],
	 *                        ["date", "=", "2020-01-01"]
	 *                       ]
	 *                ],
	 *                ["num_sta", "=", 7],
	 *                ["u", ">", 9]
	 *               ]
	 *         ],
	 *         ["t", ">=", 90]
	 *        ]
	 * ]
	 * 
	 * @param ArrayAccess $conditions Tableau structuré selon les instructions de la description
	 * 
	 * @return void
	 */
	private function buildConditions(): string
	{
		$conditions = $this->where;
		// out("condition init:");
		// out(json_encode($conditions));

		// Initialisation de la pile
		$stack = [];
		$result = ''; // Résultat final

		// Si le premier élément est une porte logique, c'est un tableau complexe
		if (in_array($conditions[0], ['and', 'or'])) {
			// Empile la porte logique et la liste des sous-conditions
			array_push($stack, [$conditions[0], $conditions[1], 0]);
			$result .= '(';
		} else {
			// Sinon c'est une condition simple
			$result .= $this->buildSimpleCondition($conditions, "");
		}

		// Tant que la pile n'est pas vide
		while (!empty($stack)) {
			// out("stack:");
			// out($stack);
			// Dépile l'élément supérieur de la pile
			list($logicOperator, $subConditions, $index) = array_pop($stack);

			// Si l'index est plus petit que la taille de la liste des sous-conditions
			if ($index < count($subConditions)) {
				// out("sub, curent:");
				// out($subConditions);
				$currentCondition = $subConditions[$index];
				// out($currentCondition);

				// Rempile la stack avec l'index suivant
				array_push($stack, [$logicOperator, $subConditions, $index + 1]);

				if (isset($currentCondition[0]) && $currentCondition[0] == 'and' || $currentCondition[0] == 'or') {
					// ajouter l'encapsulation dans la porte logique
					array_push($stack, [$currentCondition[0], $currentCondition[1], 0]);
					$result .= "(";
					// out("add to stack");
				} else {
					// Ajout de la condition à la chaîne avec la porte logique
					$condition = $this->buildSimpleCondition($currentCondition, $logicOperator);
					if ($result !== '' && $result[-1] !== "(") {
						$result .= "%20{$logicOperator}%20{$condition}";
					} else {
						$result .= $condition;
					}
					// out($result);
				}
			} else {
				$result .= ")";
			}
		}
		// out($result);
		return $result;
	}

	// Méthode pour traiter une condition simple (clé, opérateur, valeur)
	private function buildSimpleCondition(array $condition, string $logicOperator): string
	{
		// out($condition);
		$key = $condition[0];
		$operator = $condition[1];
		if (is_array($condition[2])) {
			$r = "";
			// out($condition[2]);
			foreach ($condition[2] as $v) {
				if ($r !== '') {
					$r .= "%20{$logicOperator}%20{$key}%20{$operator}%20{$v}";
				} else {
					$r .= "{$key}%20{$operator}%20{$v}";
				}
			}
			return $r;
		}

		// Retourne la chaîne représentant la condition simple
		return "{$key}%20{$operator}%20{$condition[2]}";
	}

	#endregion Privees

	// =======================
	//    STATIC METHODS
	// =======================
	#region Statiques

	#endregion Statiques


	// =======================
	//    OVERIDES
	// =======================
	#region Overides

	#endregion Overides

}
