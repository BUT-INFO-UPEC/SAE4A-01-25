<?php

/**
 * Description de la classe
 */
class Requette_API {
    // =======================
    //        ATTRIBUTES
    // =======================
    #region Attributs
    private $select;
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

    #endregion Stters
    

    // =======================
    //    PUBLIC METHODS
    // =======================
    #region Publiques
    /**
     * @param String $atribute
     * @param String|null $agregation=null
     * 
     * @return void
     */
    public function addSelect(String $atribute, ?String $agregation=null): void {}

    public function beginSubCondition(): void {$this->where.="(";}
    public function endSubCondition(): void {$this->where.=")";}

    /**
     * @return String l'URL (encodé) de la requette
     */
    public function buildRequest(): String {
        return "/?" . $this->select;
    }
    #endregion Publiques
    

    // =======================
    //    PRIVATE METHODS
    // =======================
    #region Privees

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
?>
