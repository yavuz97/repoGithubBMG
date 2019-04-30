<?php

// sollicite les services de la classe PdoDao
require_once ('PdoDao.class.php');

class OuvrageDal {

    /**
     * charge un tableau d'ouvrages
     * @param  $style : 0 == tableau assoc, 1 == objet
     * @return  un objet de la classe PDOStatement
     */
    public static function loadOuvrages($style) {
       //instanciation d'un objet PdoDao
       $cnx = new PdoDao();
       $qry = "SELECT no_ouvrage as ID," //Interrogation de la vue v_ouvrages
                ."titre, "
                ."code_genre, "
                ."lib_genre, "
                ."auteur, "
                ."salle, "
                ."rayon, "
                ."dernier_pret, "
                ."disponibilite, "
                ."acquisition, "
                ."image "
                ."FROM v_ouvrages "
                ."ORDER BY titre;";
        $tab = $cnx->getRows($qry, array(), $style);
        if (is_a($tab, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        // dans le cas ou on attend un tableau d'objets
        if ($style == 1) {
            //retourner un tableau d'objets
            $res= array();
            foreach( $tab as $ligne){
                $unGenre = new Genre($ligne->code_genre, $ligne->lib_genre);
                $unOuvrage = new Ouvrage( //Instanciation d'un objet Genre avec les valeurs récupérées dans le tableau résultat
                    $ligne->ID,
                    $ligne->titre,
                    $ligne->salle,
                    $ligne->rayon,
                    $unGenre,
                    $ligne->acquisition,
                    $ligne->image
                );
                $unOuvrage->setListeNomsAuteurs($ligne->auteur);
                $unOuvrage->setDisponibilite($ligne->disponibilite);
                $unOuvrage->setDernierPret($ligne->dernier_pret);// On valorise les autres attributs de l'objet Ouvrage grâce aux modificateurs.
                array_push($res, $unOuvrage); // identique a $res[]= $unOUvrage;
            }
            return $res;
        }
        return $tab;
        }
/**
 *
 * supprime un genre
 * @param int $id : l'ID de l'auteur à supprimer
 * @return le nombre de lignes affectées
 */
public static function delOuvrage($id){
    $cnx = new PdoDao();
    $qry = 'DELETE FROM ouvrage WHERE no_ouvrage = ?';
    $res = $cnx->execSQL($qry, array($id));
    if (is_a($res,'PDOException')){
        return PDO_EXCEPTION_VALUE;
    }
    return $res;
}



/**
 * Calcule le nombre d'auteurs liés à un ouvrage
 * @param type $id : l'ID de l'ouvrage
 * @return le nombre d'auteurs pour un ouvrage
 */
public static function countAuteursOuvrage($id){
    $cnx = new PdoDao();
    $qry = "SELECT COUNT(*) FROM auteur_ouvrage WHERE no_ouvrage = ?";
    $res = $cnx->getValue($qry, array($id));
    if (is_a($res,'PDOException')){
        return PDO_EXCEPTION_VALUE;
    }
    return $res;
}

        /**
* ajout un ouvrage
*@param string $strTitre : le titre de l'ouvrage
*@param string $intSalle : le salle de l'ouvrage
*@param string $strRayon : le rayon de l'ouvrage
*@param string $strGenre : le genre de l'ouvrage
*@param string $strDate : la date
* @return le nombre de lignes affectées
*/
public static function addOuvrage($strTitre, $intSalle, $strRayon, $strGenre, $strDate, $strImage) {
    $cnx = new PdoDao();
    $qry = "INSERT INTO ouvrage (titre, salle, rayon, code_genre, date_acquisition, image)" . "VALUES (?,?,?,?,?,?)";
    $res = $cnx->execSQL($qry, array(
        $strTitre,
        $intSalle,
        $strRayon,
        $strGenre,
        $strDate,
        $strImage
        )
    );
    if (is_a($res, 'PDOException')) {
        return PDO_EXCEPTION_VALUE;
    }
    return $res;
}
/**
*Récupère l'ID du dernier ouvrage ajouté dans la base de données
*/
public static function getMaxId(){
    $cnx = new PdoDao();
    $qry = "SELECT MAX(no_ouvrage) FROM ouvrage";
    $intID = $cnx->getValue($qry, array());
    return $intID;

}


public static function addAuteurToOuvrage($intOuvrage, $intAuteur) {
    $cnx = new PdoDao();
    $qry = "INSERT INTO auteur_ouvrage (no_ouvrage, id_auteur) " . "VALUES (?,?)";
    $res = $cnx->execSQL($qry, array(
        $intOuvrage,
        $intAuteur
        )
    );
    if (is_a($res, 'PDOException')) {
        return PDO_EXCEPTION_VALUE;
    }
    return $res;
}

  /**
        * charge un obket de la classe ouvrage ) partir de son ID
        *@param string $id : l'ID de l'ouvrage
        * @return un objet de la classe Ouvrage
        */
        public static function loadOuvragesById($id){
            $cnx = new PdoDao();
            // requete
            $qry = "SELECT no_ouvrage as ID," //Interrogation de la vue v_ouvrages
                     ."titre, "
                     ."acquisition, "
                     ."code_genre, "
                     ."lib_genre, "
                     ."salle, "
                     ."rayon, "
                     ."dernier_pret, "
                     ."disponibilite, "
                     ."auteur, "
                     ."image "
                     ."FROM v_ouvrages "
                     ."WHERE no_ouvrage = ?";
             $res = $cnx->getRows($qry, array($id), 1);
             if (is_a($res, 'PDOException')) {
               return PDO_EXCEPTION_VALUE;
             }
             if (!empty($res)){
               $res = $res[0];
               $unGenre = new Genre($res->code_genre, $res->lib_genre);
               $unOuvrage = new Ouvrage(
                    $res -> ID,
                    $res -> titre,
                    $res -> salle,
                    $res -> rayon,
                    $unGenre,
                    $res -> acquisition,
                    $res -> image
               );
                 $unOuvrage ->setListeNomsAuteurs($res->auteur);
                 $unOuvrage ->setDisponibilite($res->disponibilite);
                 $unOuvrage ->setDernierPret($res->dernier_pret);
                 return $unOuvrage;
             }else {
               return NULL;
             }

          }
     /**
     * modifie un ouvrage
     * @param   Ouvrage $leOuvrage
     * @return  le nombre de lignes affectées
    */
    public static function setOuvrage($leOuvrage) {
        $cnx = new PdoDao();
        $qry = "UPDATE ouvrage SET titre = ?,"
                            ."salle = ?,"
                            ."rayon = ?,"
                            ."code_genre = ?,"
                            ."date_acquisition = ? "
                            ."WHERE no_ouvrage = ?";
        $res = $cnx->execSQL($qry,array(
                            $leOuvrage->getTitre(),
                            $leOuvrage->getSalle(),
                            $leOuvrage->getRayon(),
                            $leOuvrage->getLeGenre()->getCode(),
                            $leOuvrage->getDateAcquisition(),
                            $leOuvrage->getNoOuvrage()
                           ));
        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }




    public static function modifyAuteurOuvrage($leOuvrage, $idAuteur) {
        $cnx = new PdoDao();
        $qry = "INSERT INTO auteur_ouvrage (no_ouvrage, id_auteur) VALUES (?,?)";
        $res = $cnx->execSQL($qry,array(
          $leOuvrage, $idAuteur
        ));

        if (is_a($res,'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $res;
    }



  public static function lastIdOuvragePlusOne(){
    $cnx = new PdoDao();
    $qry = "SELECT MAX(no_ouvrage) FROM ouvrage";
    $intID = $cnx->getValue($qry, array());
    $lastIDPlusOne = $intID + 1;
    return $lastIDPlusOne;
  }

}
