<?php

namespace Src\Model\DataObject;

use Src\Model\Repository\RepresentationRepository;
use Src\Model\API\Constructeur_Requette_API;
use Src\Model\API\Requetteur_API;
use Src\Model\Repository\AggregationRepository;
use Src\Model\Repository\AttributRepository;
use Src\Model\Repository\GrouppingRepository;

/** Un composant du dashboard analytique
 * 
 * Le composant comporte une analyse spécifique des données données étudiées
 */
class Composant extends AbstractDataObject
{
	#region Tttributs
	// =======================
	//        ATTRIBUTES
	// =======================

	private ?int $id;
	private Attribut $attribut;
	private Aggregation $aggregation;
	private Groupping $grouping;
	private Representation $repr;
	private array $params;
	private array $data;
	private string $keyTargetValue;
	#endregion attributs

	// =======================
	//      CONSTRUCTOR
	// =======================
	public function __construct(Attribut $attribut, Aggregation $aggregation, Groupping $grouping, Representation $repr_type, string $param_affich, ?int $composant_id)
	{
		$this->id = $composant_id;
		$this->attribut = $attribut;
		$this->aggregation = $aggregation;
		$this->grouping = $grouping;
		$this->repr = $repr_type;
		$this->params = json_decode($param_affich, true);
	}

	#region Getters
	// =======================
	//      GETTERS
	// =======================

	/** L'id du composant dans la BDD
	 * 
	 * @return int|null
	 */
	public function get_id(): ?int
	{
		return $this->id;
	}
	/** L'attribut analysé dans le composant
	 * 
	 * @return Attribut
	 */
	public function get_attribut(): Attribut
	{
		return $this->attribut;
	}

	/** L'aggregation analytique réalisée sur les données analysées
	 * 
	 * @return Aggregation
	 */
	public function get_aggregation(): Aggregation
	{
		return $this->aggregation;
	}

	/** Le groupement des donées réalisé pour la realisation des aggregations
	 * 
	 * @return Groupping
	 */
	public function get_grouping(): Groupping
	{
		return $this->grouping;
	}

	/** Les paramètres complémentaires du composant pour la construction de sa représentaiton graphique
	 * 
	 * Paramètres: 
	 * - Titre ("titre")
	 * - Numéro du composant dans le dashboard ("chartId")
	 * 
	 * @return array
	 */
	public function get_params(): array
	{
		return $this->params;
	}

	/** Le nom du fichier contenant le programe de représentation graphique du composant approprié
	 * 
	 * @return string
	 */
	public function get_visu_file(): string
	{
		return $this->repr->get_visu_file();
	}

	/** Retourne l'instance de la représenation associée au composant
	 * 
	 * @return Representation
	 */
	public function get_representation(): Representation
	{
		return $this->repr;
	}
	#endregion Getters

	#region Setters
	// =======================
	//      SETTERS
	// =======================

	/** Change l'id de l'instance du composant pour utilisation lors des échanges avec la BDD
	 * 
	 * @param int $id
	 * 
	 * @return void
	 */
	public function set_id(int $id): void
	{
		$this->id = $id;
	}

	/** Change l'attribut que le composant analyse
	 * 
	 * @param int $attribut
	 * 
	 * @return void
	 */
	public function set_attribut(int $attribut): void
	{
		$this->attribut = (new AttributRepository())->get_attribut_by_id($attribut);
	}

	/** Change l'aggregation de l'analyse que le composant réalise
	 * 
	 * @param int $aggregation
	 * 
	 * @return void
	 */
	public function set_aggregation(int $aggregation): void
	{
		$this->aggregation = (new AggregationRepository())->get_aggregation_by_id($aggregation);
	}

	/** Change le grouppement des données que le composant réalise pour analyser les données
	 * 
	 * @param int $grouping
	 * 
	 * @return void
	 */
	public function set_grouping(int $grouping): void
	{
		$this->grouping = (new GrouppingRepository())->get_groupping_by_id($grouping);
	}

	/** Change les paramètres complémentaires de la représentation graphique du composant
	 * 
	 * @param array $params
	 * 
	 * @return void
	 */
	public function set_params(array $params): void
	{
		$this->params = $params;
	}

	/** Change La représentation graphique du composant
	 * 
	 * @param int $value
	 * 
	 * @return void
	 */
	public function set_visu(int $value): void
	{
		$this->repr = (new RepresentationRepository())->get_representation_by_id($value);
	}
	#endregion Setters

	#region public
	// =======================
	//    PUBLIC METHODS
	// =======================

	/** Prépare les données analytique selon les paramètres du composant en construisant et réalisant la requette a l'API
	 * 
	 * @param Dashboard $dash
	 * 
	 * @return void
	 */
	public function prepare_data(Dashboard $dash): void
	{
		$params = [];

		// construire les paramètres de la requette avec les différentes composantes du comopsant
		$geo = $dash->get_params_API_geo();
		if ($geo) $params["where"][] = $geo;
		$params['where'][] = $dash->get_params_API_temporel();
		$this->keyTargetValue = $this->nettoyer_chaine($this->aggregation->get_nom() . " " . $this->attribut->get_nom());
		$params['select'][] = $this->aggregation->get_cle() . "(" . $this->attribut->get_cle() . ") as " . $this->keyTargetValue;
		$params["group_by"][] = $this->grouping->get_cle();
		$keyValueSort = !empty($params["group_by"]) ? $params["group_by"][0] : "";

		// Instancier le constructeur de requette avc les paramettres précédement définis
		$requette = new Constructeur_Requette_API($params['select'], $params['where'], $params['group_by']);

		// Envoyer la requette a l'API
		$data = Requetteur_API::fetchData($requette, $keyValueSort, $this->keyTargetValue, ($this->grouping->get_cle() == '' ? 'total' : null));

		// Formater les donénes de l'API pour utilisation simplifiée coté génération de la visualisation (structure csv)
		if ($this->grouping->get_cle() != '') {
			// **Ajouter l'en-tête obligatoire pour Google Charts**
			$formattedData = [[$keyValueSort, $this->keyTargetValue]]; // En-tête
			foreach ($data as $key => $value) {
				$key = (string) $key;
				$formattedData[] = [$key, $value];
			}
			$data = $formattedData;
		}

		$this->data = $data;
	}

	/** Retourne les données correspondant a l'analyse paramétrée par le composant
	 * 
	 * @param Dashboard $dash
	 * 
	 * @return array
	 */
	public function get_data(Dashboard $dash): array
	{
		// Si les données sont déja définies, les retourner directement
		if (isset($this->data)) return $this->data;
		
		// Si les données ne sont pas encore téléchargées, les télécharger avant de les retournées
		$this->prepare_data($dash);
		return $this->data;
	}

	/** Récupère un alias pour le nom du type de données (je crois)
	 * 
	 * @return string
	 */
	public function get_keyTargetValue(): string
	{
		return $this->keyTargetValue;
	}
	#endregion public

	
	#region Privees
	// =======================
	//    PRIVATE METHODS
	// =======================

	/** Formate l'alias pour le rendre accéptable par l'API
	 * 
	 * @param mixed $chaine
	 * 
	 * @return string
	 */
	private function nettoyer_chaine($chaine): string
	{
		// Remplacement des caractères accentués
		$chaine = iconv('UTF-8', 'ASCII//TRANSLIT', $chaine);

		// Remplacement des espaces par des underscores
		$chaine = str_replace(' ', '_', $chaine);

		// Suppression des caractères non alphanumériques (hors "_")
		$chaine = preg_replace('/[^a-zA-Z0-9_]/', '', $chaine);

		return $chaine;
	}
	#endregion private

	#region Overides
	// =======================
	//    OVERIDES
	// =======================
	
	public function formatTableau(): array
	{
		return [
			":id" => $this->get_id(),
			":repr_type" => $this->repr->get_id(),
			":attribut" => $this->get_attribut()->get_id(),
			":aggregation" => $this->get_aggregation()->get_id(),
			":groupping" => $this->get_grouping()->get_id(),
			":params_affich" => json_encode($this->params) ?? ""
		];
	}
	#endregion Overides
}
