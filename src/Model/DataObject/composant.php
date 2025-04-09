<?php

namespace Src\Model\DataObject;

use Src\Config\ServerConf\DatabaseConnection;
use Src\Config\Utils\SessionManagement;
use Src\Config\Utils\Utils;
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
	private Analysis $analysis;
	private array $params;
	private array $data;
	private string $keyTargetValue;
	#endregion attributs

	// =======================
	//      CONSTRUCTOR
	// =======================
	public function __construct(Analysis $analysis, array $param_affich, ?int $composant_id)
	{
		$this->id = $composant_id;
		$this->analysis = $analysis;
		$this->params = $param_affich;
		SessionManagement::get_curent_log_instance()->new_log("Composant instancié.");
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

	public function get_analysis(): Analysis {
		return $this->analysis;
	}

	/** L'attribut analysé dans le composant
	 *
	 * @return Attribut
	 */
	public function get_attribut(): Attribut
	{
		return $this->analysis->getAttribut();
	}

	/** L'aggregation analytique réalisée sur les données analysées
	 *
	 * @return Aggregation
	 */
	public function get_aggregation(): Aggregation
	{
		return $this->analysis->getAggregation();
	}

	/** Le groupement des donées réalisé pour la realisation des aggregations
	 *
	 * @return Groupping
	 */
	public function get_grouping(): Groupping
	{
		return $this->analysis->getGroupping();
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
		return $this->analysis->getRepresentation()->get_visu_file();
	}

	/** Retourne l'instance de la représenation associée au composant
	 *
	 * @return Representation
	 */
	public function get_representation(): Representation
	{
		return $this->analysis->getRepresentation();
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
		$this->analysis->setAttribut((new AttributRepository())->get_attribut_by_id($attribut));
	}

	/** Change l'aggregation de l'analyse que le composant réalise
	 *
	 * @param int $aggregation
	 *
	 * @return void
	 */
	public function set_aggregation(int $aggregation): void
	{
		$this->analysis->setAggregation((new AggregationRepository())->get_aggregation_by_id($aggregation));
	}

	/** Change le grouppement des données que le composant réalise pour analyser les données
	 *
	 * @param int $grouping
	 *
	 * @return void
	 */
	public function set_grouping(int $grouping): void
	{
		$this->analysis->setGroupping((new GrouppingRepository())->get_groupping_by_id($grouping));
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
		$this->analysis->setRepresentation((new RepresentationRepository())->get_representation_by_id($value));
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
		$this->keyTargetValue = $this->nettoyer_chaine($this->get_aggregation()->get_nom() . " " . $this->get_attribut()->get_nom());
		$params['select'][] = $this->get_aggregation()->get_cle() . "(" . $this->get_attribut()->get_cle() . ") as " . $this->keyTargetValue;
		$params["group_by"][] = $this->get_grouping()->get_cle();
		$keyValueSort = !empty($params["group_by"]) ? $params["group_by"][0] : "";

		// si visu == carte : ajouter longitude et latitude
		if ($this->get_visu_file() == "generate_geo_chart.php") {
			$params['select'][] = "longitude";
			$params['select'][] = "latitude";
		}

		// Instancier le constructeur de requette avc les paramettres précédement définis
		$requette = new Constructeur_Requette_API($params['select'], $params['where'], $params['group_by']);

		// Envoyer la requette a l'API
		$data = Requetteur_API::fetchData($requette, $keyValueSort, $this->keyTargetValue, ($this->get_grouping()->get_cle() == '' ? 'total' : null));
		$geo_file = $this->get_visu_file() == "generate_geo_chart.php";
		// Formater les donénes de l'API pour utilisation simplifiée coté génération de la visualisation (structure csv)
		if ($this->get_grouping()->get_cle() != '') {
			// **Ajouter l'en-tête obligatoire pour Google Charts**
			$formattedData = [[$keyValueSort, $this->keyTargetValue]]; // En-tête
			if ($geo_file) {
				$formattedData[0][] = "name";
				$formattedData[0][] = 'lon';
				$formattedData[0][] = 'lat';
			}

			foreach ($data as $key => $value) {
				$key = (string) $key;
				$var = [$key, $value];
				if ($geo_file) {
					$station = DatabaseConnection::fetchOne("SELECT name, longitude, latitude FROM stations where id = :id", [":id" => $key]);
					$var[] = $station['name'];
					$var[] = $station['longitude'];
					$var[] = $station['latitude'];
				}
				$formattedData[] = $var;


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
			":analysis_id" => $this->analysis->getId(),
			":params_affich" => json_encode($this->params) ?? ""
		];
	}

	public function __tostring(): string {
		$p = Utils::multi_implode($this->params, ", ");

		return "new Composant(" . $this->analysis->__tostring() .", ". $p . ", " . ($this->id ?? 'null') . ")";
	}
	#endregion Overides
}
