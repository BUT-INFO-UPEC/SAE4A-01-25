<?php

namespace Src\Model\DataObject;

use DateTime;
use Exception;
use OutOfBoundsException;
use Src\Config\LogInstance;
use Src\Config\SessionManagement;

/** Classe comportant les informations d'analyse des données météorologiques
 */
class Dashboard extends AbstractDataObject
{
	const PRIVATISATION = [0 => "publique", 1 => "privé"];

	#region attributs
	// =======================
	//        ATTRIBUTES
	// =======================
	private ?int $dashboardId;
	private int $privatisation;
	private array $composants = [];
	private int $createurId;
	private string $dateDebut;
	private string $dateFin;
	public bool $dateDebutRelatif;
	public bool $dateFinRelatif;
	private array $selectionGeo;
	private array $params;
	#endregion attributs

	// =======================
	//      CONSTRUCTOR
	// =======================

	public function __construct(int $dashboard_id, int $privatisation, int $createurId, string $date_debut, string $date_fin, string $date_debut_relatif, string $date_fin_relatif, array $composants, array $critere_geo, array $param)
	{
		$this->dashboardId = $dashboard_id;
		$this->privatisation = $privatisation;
		$this->createurId = $createurId;
		$this->dateDebut = $date_debut;
		$this->dateFin = $date_fin;
		$this->dateDebutRelatif = $date_debut_relatif == '1';
		$this->dateFinRelatif = $date_fin_relatif == '1';
		$this->params = $param;
		$this->selectionGeo = $critere_geo;
		$this->composants = $composants;
		SessionManagement::get_curent_log_instance()->new_log("Dashboard instancié.");
	}

	#region getters
	// =======================
	//    PUBLIC GETTERS
	// =======================

	/** Retourne l'id du dashboard pour association dans la BDD
	 * @return int
	 */
	public function get_id(): int
	{
		return $this->dashboardId;
	}

	/** Retourne l'identifiant de l'utilisateur du dashboard
	 * 
	 * @return int
	 */
	public function get_createur(): int
	{
		return $this->createurId;
	}

	/** récupère les paramètres de privatisation du dashboard, privé ou publique
	 * 
	 * @return string
	 */
	public function get_privatisation(): string
	{
		return Dashboard::PRIVATISATION[$this->privatisation];
	}

	/** Retourne le nom/titre du dashboard
	 * 
	 * @return string
	 */
	public function get_name(): string 
	{
		return $this->params[0];
	}

	public function get_comment(): ?string
	{
		if (isset($this->params[1])) return $this->params[1];
		else return null;
	}

	/** Récupère les critères géographiques de la séléction des données analysées
	 * 
	 * @return array
	 */
	public function get_region(): array
	{
		return $this->selectionGeo;
	}

	/** Retourne la date de début ou de fin tel qu'enregistré dans la BDD
	 * 
	 * @param string $type 'debut' pour la date de début, 'fin' pour la date de fin
	 * 
	 * @return string La date correspondante
	 * 
	 * @throws Exception Si le type est invalide
	 */
	public function get_date($type = 'debut'): string
	{
		if ($type === 'debut') {
			return $this->dateDebut;
		} elseif ($type === 'fin') {
			return $this->dateFin;
		}
		throw new OutOfBoundsException("Type de date invalide : utilisez 'debut' ou 'fin'.");
	}

	/** Retourne la date de début et de fin finale, a utiliser lors de la requette a l'API
	 * 
	 * @param string $type 'debut' pour la date de début, 'fin' pour la date de fin
	 * 
	 * @return string La date correspondante
	 * 
	 * @throws Exception Si le type est invalide
	 */
	public function get_date_relative($type = 'debut'): string
	{
		if ($type === 'debut') {
			return $this->dateDebutRelatif ? $this->calculate_relative_date($this->dateDebut) : $this->dateDebut;
		} elseif ($type === 'fin') {
			return $this->dateFinRelatif ? $this->calculate_relative_date($this->dateFin) : $this->dateFin;
		}
		throw new OutOfBoundsException("Type de date invalide : utilisez 'debut' ou 'fin'.");
	}

	/** Récupère la liste des composants de la représentation graphique de l'analise des données
	 * 
	 * @return array
	 */
	public function get_composants(): array
	{
		return $this->composants;
	}

	/** Construit les critères géographiques dans une chaine de caractère a mettre dans la requette a l'API (formatage)
	 * 
	 * @return string|null
	 */
	public function get_params_API_geo(): ?string
	{
		$returnValue = [];

		foreach ($this->selectionGeo as $key => $value) {
			// Application de la transformation sur chaque élément de $value
			$formattedValues = array_map(function ($valueInValue) use ($key) {
				if (in_array($key, ["numer_sta", "codegeo"])) {
					$valueInValue = str_pad($valueInValue, 5, "0", STR_PAD_LEFT);
					$valueInValue = "'" . $valueInValue . "'";
				}
				if (in_array($key, ["code_reg", "code_dep"])) {
					$valueInValue = str_pad($valueInValue, 2, "0", STR_PAD_LEFT);
					$valueInValue = "'" . $valueInValue . "'";
				}
				return $valueInValue;
			}, $value);

			// Construction de la chaîne avec implode
			$returnValue[] = "$key=" . implode(" or $key=", $formattedValues);
		}

		return sizeof($returnValue) == 0 ? null : "(" . implode(" or ", $returnValue) . ")";
	}

	/** Construit les critères temporelles dans une chaine de caractère a mettre dans la requette a l'API (formatage)
	 * 
	 * @return string|null
	 */
	public function get_params_API_temporel(): string
	{
		$dateDebut = $this->get_date_relative();
		$dateFin = $this->get_date_relative("fin");

		return "(date >= '$dateDebut" . "' and date <= '" . $dateFin . "')";
	}
	#endregion getters

	#region setters
	// =======================
	//      SETTERS
	// =======================

	/** Change l'identifiant du dashboard pour la BDD
	 * 
	 * @param int|null $id
	 * 
	 * @return void
	 */
	public function setId(?int $id): void
	{
		$this->dashboardId = $id;
	}

	/** Change le nmo de la lmétéothèque
	 * 
	 * @param string $title
	 * 
	 * @return void
	 */
	public function setTitle(string $title): void {
		$this->params[0] = $title;
	}

	public function setComments(string $comments): void {
		$this->params[1] = $comments;
	}

	/** Change la publicité du dashboard
	 * 
	 * @param int $visibility
	 * 
	 * @return void
	 */
	public function setVisibility(int $visibility): void {
		$this->privatisation = $visibility;
	}

	/** Change la valeur de la date de début
	 * 
	 * @param string $startDate
	 * 
	 * @return void
	 */
	public function setStartDate(string $startDate): void
	{
		$this->dateDebut = $startDate;
	}

	/** Change la date de début de statique a relative
	 * 
	 * @param bool $startDate
	 * 
	 * @return void
	 */
	public function setStartDateRelative(bool $startDate): void
	{
		$this->dateDebutRelatif = $startDate;
	}

	/** Change la valeur de la date de fin
	 * 
	 * @param string $endDate
	 * 
	 * @return void
	 */
	public function setEndDate(string $endDate): void
	{
		$this->dateFin = $endDate;
	}

	/** Change la date de fin de statique a relative
	 * 
	 * @param bool $endDate
	 * 
	 * @return void
	 */
	public function setEndDateRelative(bool $endDate): void
	{
		$this->dateFinRelatif = $endDate;
	}

	/** Actualise les paramètres géographiques de la séléction de données
	 * 
	 * @param mixed $CryteresGeo Array?
	 * 
	 * @return void
	 */
	public function setCriteresGeo($CryteresGeo): void
	{
		$this->selectionGeo = $CryteresGeo;
	}
	#endregion setters

	#region public
	// =======================
	//    PUBLIC METHODS
	// =======================

	/** Génère les données du dashboard en réalisant les requettes a l'API pour tout ses composants
	 * 
	 * @return void
	 */
	public function buildData(): void
	{
		foreach ($this->get_composants() as $comp) {
			$comp->prepare_data($this);
		}
	}

	/** Ajoute un composant a la liste des analyses du dashboard
	 * 
	 * @param Composant $composant
	 * 
	 * @return void
	 */
	public function addComposant(Composant $composant): void
	{
		$this->composants[] = $composant;
	}

	/** Supprime des composants de la liste du dashboard et retourne une liste des composants supprimés dans la session
	 * 
	 * @param int $nbComps
	 * 
	 * @return void
	 */
	public function delComposants(int $nbComps): void
	{
		while (count($this->composants) > $nbComps) {
			$del_comp = array_pop($this->composants);
			// si le composant est initialisé dans la BDD (il a un id), il faudra potentiellement le supprimer, il faut donc conserver son identifiant
			if ($del_comp->get_id() != null) $_SESSION["componants_to_delete"][] = $del_comp->get_id();
		}
	}
	#endregion public

	#region private
	// =======================
	//    PRIVATE METHODS
	// =======================

	private function calculate_relative_date($relativeDate)
	{
		$annee = (int)substr($relativeDate, 0, 4);
		$mois = (int)substr($relativeDate, 5, 2);
		$jours = (int)substr($relativeDate, 8, 2);

		$date = new DateTime();
		if ($annee > 0) $date->modify("-$annee year");
		if ($mois > 0) $date->modify("-$mois month");
		if ($jours > 0) $date->modify("-$jours day");

		return $date->format("Y-m-d") . "T00:00:00";
	}
	#endregion private

	#region Overides
	// =======================
	//    OVERIDES
	// =======================

	public function formatTableau(): array
	{
		return [
			":id" => $this->dashboardId,
			":privatisation" => $this->privatisation,
			':createur_id' => SessionManagement::getUser()->getId(),
			":date_debut" => $this->get_date('debut'),
			":date_fin" => $this->get_date('fin'),
			":date_debut_relatif" => $this->dateDebutRelatif ? "True" :"False",
			":date_fin_relatif" => $this->dateFinRelatif? "True" : "False",
			":params" => $this->get_name()
		];
	}
	#endregion Overides
}
