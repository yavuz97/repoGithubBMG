<?php
/**
 *
 * BMG
 * © GroSoft
 *
 * References
 * Classes métier
 *
 *
 * @package 	default
 * @author 	dk
 * @version    	1.0
 */

/*
 *  ====================================================================
 *  Classe Genre : représente un genre d'ouvrage
 *  ====================================================================
*/

class Genre {
    private $_code;
    private $_libelle;

    /**
     * Constructeur
    */
    public function __construct(
            $p_code,
            $p_libelle
    ) {
        $this->setCode($p_code);
        $this->setLibelle($p_libelle);
    }

    /**
     * Accesseurs
    */
    public function getCode() {
        return $this->_code;
    }

    public function getLibelle() {
        return $this->_libelle;
    }

    /**
     * Mutateurs
    */
    public function setCode($p_code) {
        $this->_code = $p_code;
    }

    public function setLibelle($p_libelle) {
        $this->_libelle = $p_libelle;
    }

}
/*
 *  ====================================================================
 *  Classe Auteur : représente un auteur
 *  ====================================================================
*/

class Auteur {
    private $_id;
    private $_nom;
    private $_prenom;
    private $_alias;
    private $_notes;
    private $_dateNaiss;
    private $_dateDeces;
    private $_acedemicien;
    private $_Nationalite;




    /**
     * Constructeur
    */
    public function __construct(
            $a_id = null,
            $a_nom = null,
            $a_dateNaiss = null,
            $a_dateDeces= null,
            $a_acedemicien= null,
            $a_Nationalite= null,
            $a_prenom = "",
            $a_alias = "",
            $a_notes = ""
    ) {
       $this->setId($a_id);
        $this->setNom($a_nom);
        $this->setPrenom($a_prenom);
        $this->setAlias($a_alias);
        $this->setNotes($a_notes);
        $this->setDateNaiss($a_dateNaiss);
        $this->setDateDeces($a_dateDeces);
        $this->setAcedemicien($a_acedemicien);
        $this->setNationalite($a_Nationalite);
    }

    /**
     * Accesseurs
    */
    public function getId() {
        return $this->_id;
    }

    public function getNom() {
        return $this->_nom;
    }

     public function getPrenom() {
        return $this->_prenom;
    }

     public function getAlias() {
        return $this->_alias;
    }

     public function getNotes() {
        return $this->_notes;
    }
    public function getDateNaiss() {
       return $this->_dateNaiss;
   }
   public function getDateDeces() {
      return $this->_dateDeces;
  }
    public function getAcedemicien() {
       return $this->_acedemicien;
   }
   public function getNationalite() {
      return $this->_Nationalite;
  }

    /**
     * Mutateurs
    */
    public function setId($a_id) {
        $this->_id = $a_id;
    }

    public function setNom($a_nom) {
        $this->_nom = $a_nom;
    }

    public function setPrenom($a_prenom) {
        $this->_prenom = $a_prenom;
    }

    public function setAlias($a_alias) {
        $this->_alias = $a_alias;
    }

    public function setNotes($a_notes) {
        $this->_notes = $a_notes;
    }
    public function setDateNaiss($a_dateNaiss) {
        $this->_dateNaiss = $a_dateNaiss;
    }
    public function setDateDeces($a_dateDeces) {
        $this->_dateDeces = $a_dateDeces;
    }
    public function setAcedemicien($a_acedemicien) {
        $this->_acedemicien = $a_acedemicien;
    }
    public function setNationalite($a_Nationalite) {
        $this->_Nationalite = $a_Nationalite;
    }


}
/*
 *  ====================================================================
 *  Classe Genre : représente un genre d'ouvrage
 *  ====================================================================
*/
class Ouvrage{
private $_noOuvrage;
private $_titre;
private $_salle;
private $_rayon;
private $_leGenre;
private $_dateAcquisition;
private $_lesAuteurs;
private $_dernierPret;
private $_disponibilite;
private $_listeNomsAuteurs;
private $_image;

/**
 * COnstructeur
 */

public function __construct(
    $p_num,
    $p_titre,
    $p_salle,
    $p_rayon,
    $p_leGenre,
    $p_acquisition = null,
    $p_image
){
    $this->setNoOuvrage($p_num);
    $this->setTitre($p_titre);
    $this->setSalle($p_salle);
    $this->setRayon($p_rayon);
    $this->setLeGenre($p_leGenre);
    $this->setDateAcquisition($p_acquisition);
    $this->setImage($p_image);
    $this->_lesAuteurs = array();
}
    /**
     * Accesseurs
    */
    public function getNoOuvrage() {
        return $this->_noOuvrage;
    }

    public function getTitre() {
        return $this->_titre;
    }

     public function getSalle() {
        return $this->_salle;
    }

     public function getRayon() {
        return $this->_rayon;
    }

     public function getLeGenre() {
        return $this->_leGenre;
    }

    public function getDateAcquisition() {
        return $this->_dateAcquisition;
    }
    public function getLesAuteurs(){
        return $this->_lesAuteurs;
    }
    public function getDisponibilite(){
        return $this->_disponibilite;
    }
    public function getDernierPret(){
        return $this->_dernierPret;
    }
    public function getImage(){
        return $this->_image;
    }
    public function getListeNomsAuteurs(){
        return $this->_lesAuteurs;
    }
    /**
     * Mutateurs
    */
    public function setNoOuvrage($p_num) {
        $this->_noOuvrage = $p_num;
    }

    public function setTitre($p_titre) {
        $this->_titre = $p_titre;
    }

    public function setSalle($p_salle) {
        $this->_salle = $p_salle;
    }

    public function setRayon($p_rayon) {
        $this->_rayon = $p_rayon;
    }

    public function setLeGenre($p_leGenre) {
        $this->_leGenre = $p_leGenre;
    }

    public function setDateAcquisition($p_acquisition) {
        $this->_dateAcquisition = $p_acquisition;
    }
    public function setListeNomsAuteurs($p_nomAuteur){
        $this->_lesAuteurs = $p_nomAuteur;
    }
    public function setDisponibilite($p_disponibilite){
        $this->_disponibilite = $p_disponibilite;
    }
    public function setDernierPret($p_dernierPret){
        $this->_dernierPret = $p_dernierPret;
    }
    public function setImage($p_image){
        $this->_image = $p_image;
    }
}

class auteur_ouvrage{
private $_no_ouvrage;
private $_id_auteur;

/**
 * COnstructeur
 */

public function __construct(
    $p_no_ouvrage,
    $p_id_auteur

){
    $this->setNoOuvrageAuteur($p_no_ouvrage);
    $this->setIdAuteurOuvrage($p_id_auteur);
}
    /**
     * Accesseurs
    */
    public function getNoOuvrageAuteur() {
        return $this->_no_ouvrage;
    }

    public function getIdAuteurOuvrage() {
        return $this->_id_auteur;
    }


    /**
     * Mutateurs
    */
    public function setNoOuvrageAuteur($p_no_ouvrage) {
        $this->$p_no_ouvrage = $p_no_ouvrage;
    }

    public function setIdAuteurOuvrage($p_id_auteur) {
        $this->_id_auteur = $p_id_auteur;
    }

}
