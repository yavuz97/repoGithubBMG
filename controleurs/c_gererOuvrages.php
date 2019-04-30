<?php

require_once 'modele/OuvrageDal.class.php';
require_once 'modele/GenreDal.class.php';
require_once 'modele/AuteurDal.class.php';
require_once 'include/_reference.lib.php';

// variables pour la gestion des messages
$titrePage = 'Gestion des ouvrages';

// variables pour la gestion des erreurs
$tabErreurs = array();
$hasErrors = false;

if (!isset($_REQUEST['action'])) {
    $action = 'listerOuvrages';
} else {
    $action = $_REQUEST['action'];
}
// variables pour la gestion des messages
$msg = '';    // message passé à la vue v_afficherMessage
$lien = '';   // message passé à la vue v_afficherErreurs

switch ($action) {
    case 'listerOuvrages' : {
            // récupérer les ouvrages
            $lesOuvrages = OuvrageDal::loadOuvrages(1);
            // afficher le nombre de ouvrages
            $nbOuvrages = count($lesOuvrages);
            include 'vues/v_listeOuvrages.php';
    }
    break;




    case 'consulterOuvrage' : {
         // récupération du code passé dans l'URL
        if (isset($_GET["id"])) {
            $strCode = strtoupper(htmlentities($_GET["id"]));
            // appel de la méthode du modèle
            $leOuvrage = OuvrageDal::loadOuvragesById($strCode);
            if ($leOuvrage == NULL) {
                $tabErreurs[] = 'Ce Ouvrage n\'existe pas !';
                $hasErrors = true;
            }
        }
        else {
            // pas d'id dans l'url : c'est anormal
            $tabErreurs[] = "Aucun Ouvrage n'a été transmis pour consultation !";
            $hasErrors = true;
        }

        if ($hasErrors) {
            include 'vues/_v_afficherErreurs.php';
        }
        else {
           include 'vues/v_consulterOuvrage.php';
        }
    }
    break;






    case 'ajouterOuvrage' : {
            // initialisation des variables
            $strTitre = '';
            $intSalle = 1;
            $strRayon = '';
            $strGenre = '';
            $strDate = '';
            $strAuteur = '';
            $strImage = '';
            // traitement de l'option : saisie ou validation ?
            if (isset($_GET["option"])) {
                $option = htmlentities($_GET["option"]);
            } else {
                $option = 'saisirOuvrage';
            }
            switch ($option) {
                case 'saisirOuvrage' : {
                    $lesGenres = GenreDal::loadGenres(0);
                    $lesAuteurs = AuteurDal::loadAuteurs(0);
                        include 'vues/v_ajouterOuvrages.php';
                    } break;
                case 'validerOuvrage' : {

                        if (isset($_POST["cmdValider"])) {
                            // récupération du libellé
                            if (!empty($_POST["txtTitre"])) {
                                $strTitre = ucfirst($_POST["txtTitre"]);
                            }
                            $intSalle = $_POST["rbnSalle"];
                            if (!empty($_POST["txtRayon"])) {
                                $strRayon = ucfirst($_POST["txtRayon"]);
                            }
                            $strGenre = $_POST["cbxGenres"];
                            if(!empty ($_POST["txtRayon"])){
                                $strDate = $_POST["txtDate"];
                            }
                            if (!empty($_POST["monImage"])) {
                                $strImage = ucfirst($_POST["monImage"]);
                            }

                                $intAuteur = ucfirst($_POST["id_auteur"]);


                            $intOuvrage = OuvrageDal::lastIdOuvragePlusOne();
                            // test zones obligatoires
                            if (!empty($strTitre) and !empty($strRayon) and !empty($strDate)) {
                                // test de la date d'acquisition
                                $dateAcquisition = new DateTime($strDate);
                                $curDate= new DateTime(date('Y-m-d'));
                                if($dateAcquisition > $curDate)  {
                                    $tabErreurs[] = "La date d'acquisition doit être antérieure ou égale à la date du jour";
                                    $hasErrors = true;
                                }
                                if(!rayonValide($strRayon)){
                                    $tabErreurs[]="Le rayon n'est pas valide, il doit comporter une lettre et un chiffes !";
                                    $hasErrors = true;
                                }
                            } else{
                                if (empty($strTitre)){
                                    $tabErreurs[] = "Le titre doit être renseigné ! ";
                                }
                                if (empty($strRayon)){
                                    $tabErreurs[] = "Le rayon doit être renseigné !";
                                }
                                if (empty($strDate)){
                                    $tabErreurs[] = "La date d'acquisition doit être renseignée !";
                                }
                                $hasErrors = true;
                            }
                            if (!$hasErrors){
                                try{

                                    $res = OuvrageDal::addOuvrage( $strTitre, $intSalle, $strRayon, $strGenre, $strDate, $strImage);
                                    $res1 = OuvrageDal::addAuteurToOuvrage( $intOuvrage, $intAuteur);
                                    if($res > 0 and $res1>0){

                                        // ajout de photo
                                        $target_dir = "img/couvertures/";
                                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                        $uploadOk = 1;
                                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                                        // Check if image file is a actual image or fake image
                                        if(isset($_POST["cmdValider"])) {
                                            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                                            if($check !== false) {
                                                echo "File is an image - " . $check["mime"] . ".";
                                                $uploadOk = 1;
                                            } else {
                                                echo "File is not an image.";
                                                $uploadOk = 0;
                                            }
                                        }
                                        // Check if file already exists
                                        if (file_exists($target_file)) {
                                            echo "Sorry, file already exists.";
                                            $uploadOk = 0;
                                        }
                                        // Check file size
                                        if ($_FILES["fileToUpload"]["size"] > 500000) {
                                            echo "Sorry, your file is too large.";
                                            $uploadOk = 0;
                                        }
                                        // Allow certain file formats
                                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                                            && $imageFileType != "gif" ) {
                                            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                            $uploadOk = 0;
                                        }
                                        // Check if $uploadOk is set to 0 by an error
                                        if ($uploadOk == 0) {
                                            echo "Sorry, your file was not uploaded.";
                                            // if everything is ok, try to upload file
                                        } else {
                                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                                            } else {
                                                echo "Sorry, there was an error uploading your file.";
                                            }
                                        }
                                        //fin photo




                                         $msg = '<span class="info">L\'ouvrage '.$strTitre.' a été ajouté</span>';
                                        $msg= 'Le genre '
                                            . $strTitre . '-'
                                            . $strTitre . ' a été ajouté';
                                        $intID = OuvrageDal::getMaxId();
                                        $leOuvrage = OuvrageDal::loadOuvragesById($intID);
                                        if ($leOuvrage){

                                            include 'vues/_v_afficherMessage.php';
                                            include 'vues/v_consulterOuvrage.php';
                                        }
                                        else {
                                            $tabErreurs[] = "Cet ouvrage n'existe pas !";
                                            $hasErrors = true;
                                        }
                                    }
                                    else {
                                        $tabErreurs[] = "Une erreur s'est produite dans l'opération d'ajout !";
                                        $hasErrors = true;
                                    }
                                }
                                catch (PDOException $e){
                                    $tabErreurs[]= "Une exception PDO a été levée !";
                                    $hasErrors = true;
                                }
                            }
                            else {
                                $msg = "L'opération d'ajout n'a pas pu être menée à terme en raison des eurreurs suivantes :";
                                $lien ='<a href="index.php?uc=gererOuvrages&action=ajouterOuvrage">Retour à la saisie</a>';
                                include 'vues/_v_afficherErreurs.php';
                            }

                        }
                    } break;
            }
        }
        break;






    case 'modifierOuvrage' : {
           // initialisation des variables
            $strTitre = '';
            $intSalle = 1;
            $strRayon = '';
            $strGenre = '';
            $strDate = '';
            $intAuteur = '';

            if(isset($_GET["option"])){
                $option = (htmlentities($_GET["option"]));
            }
            else {
                $option = "saisirOuvrage" ;
            }

            // Dans les deux cas, on crée l'objet Ouvrage correspondant à l'ID
            // pour afficher le formulaire de modification --> l'objet sera affiché dans le formulaire
            // et au retour de ce formulaire --> l'objet sera alors modifié

            if (isset($_GET["id"])) {
                $intID = intval(htmlentities($_GET["id"]));


                $leOuvrage = OuvrageDal::loadOuvragesById($intID);
                if ($leOuvrage == NULL) {
                    $tabErreurs[] = 'Le Ouvrage est inconnu !';
                    $hasErrors = true;
                }
            } else {
                // pas d'id dans l'url : c'est anormal
                $tabErreurs[] = "Aucun Ouvrage n'a été transmis pour modification !";
                $hasErrors = true;
            }
            if (!$hasErrors) {
                switch ($option) {
                    case 'saisirOuvrage' : {
                            $lesGenres = GenreDal::loadGenres(0);
                            // Affichage de la vue de modification - l'objet Ouvrage $leOuvrage est connu
                            include("vues/v_modifierOuvrage.php");
                        } break;
                    case 'validerOuvrage' : {
                            // si on a cliqué sur Valider
                            if (isset($_POST["cmdValider"])) {
                                // mémoriser les valeurs pour les réafficher
                                $intID = intval($_POST["txtID"]);
                                // test zones obligatoires
                                if (!empty($_POST["txtTitre"])) {
                                    // les zones obligatoires sont présentes
                                    $strTitre = ucfirst($_POST["txtTitre"]);
                                }
                                $intSalle = $_POST["rbnSalle"];
                                if (!empty($_POST["txtRayon"])) {
                                    $strRayon = ucfirst($_POST["txtRayon"]);
                                }
                                $strGenre = $_POST["cbxGenres"];
                                $leGenre = GenreDal::loadGenreByID($strGenre);
                                if(!empty($_POST["txtRayon"])){
                                    $strDate = $_POST["txtDateA"];
                                }
                                if (!empty($strTitre) and !empty($strRayon) and !empty($strDate)){
                                    $dateAcquisition = new DateTime($strDate);
                                    $curDate = new DateTime(date('Y-m-d'));
                                    if($dateAcquisition > $curDate){
                                        $tabErreurs[] = 'La date d\'acquisitioon doit être antérieure ou égale à la date du jour';
                                        $hasErrors = true;
                                    }

                                    $intAuteur = $_POST["nomAuteurOuvrage"];


                                    if(!rayonValide($strRayon)){
                                        $tabErreurs[] = 'Le rayon pas valide, comporter lettre et un chiffre';
                                        $hasErrors = true;
                                    }
                                }


                                else {

                                    $tabErreurs[] = "Le libellé est obligatoire !";
                                    $hasErrors = true;
                                }
                                if (!$hasErrors) {
                                    // mise à jour dans la base de données
                                    $leOuvrage->setTitre($strTitre);
                                    $res = OuvrageDal::setOuvrage($leOuvrage);
                                    $res2 = OuvrageDal::modifyAuteurOuvrage($intID, $intAuteur);
                                    if ($res > 0) {
                                        $msg = 'Le Ouvrage '
                                                . $leOuvrage->getNoOuvrage() . '-'
                                                . $leOuvrage->getTitre() . ' a été modifié';
                                        include 'vues/_v_afficherMessage.php';
                                        include 'vues/v_consulterOuvrage.php';
                                    } else {
                                        $tabErreurs[] = 'Une erreur s\'est produite lors de l\'opération de mise à jour !';
                                        $hasErrors = true;
                                    }
                                }
                            }
                        } break;
                }
            }
            if ($hasErrors) {
                $msg = "L'opération de modification n'a pas pu être menée à terme en raison des erreurs suivantes :";
                include 'vues/_v_afficherErreurs.php';
            }
        } break;





    case 'supprimerOuvrage' : {
         // récupération du code passé dans l'URL
        if (isset($_GET["id"])) {
            $intID = intval(htmlentities($_GET["id"]));
            // récupération des données dans la base
            $leOuvrage = OuvrageDal::loadOuvragesById($intID);
            if($leOuvrage == NULL){

                $tabErreurs[] ="Cet ouvrage n'existe pas !";
                $hasErrors = true;
            }
        } else {

            // pas d'id dans l'url : c'est anormal
            $tabErreurs[]="Aucun identifiant d'ouvrage n'a été transmis pour suppression !";
            $hasErrors = true;
        }
        if (!$hasErrors) {
            // rechercher  des ouvrages lié à des auteurs
            try {
                $nbAuteursOuvrage = OuvrageDal::countAuteursOuvrage($intID);
                var_dump($nbAuteursOuvrage);
                if ($nbAuteursOuvrage == 0) {
                    try {
                        $res = OuvrageDal::delOuvrage($intID);
                        if ($res > 0) {
                            var_dump('i"m in it');
                            $msg = 'L\'ouvrage ' . $leOuvrage->getTitre() . ' a été supprimé ';
                            include 'vues/_v_afficherMessage.php';
                            //Affichage de la liste des ouvrages
                            $lesOuvrages = OuvrageDal::loadOuvrages(1);
                            //Afficher le nombre d'ouvrages
                            $nbOuvrages = count($lesOuvrages);
                            include 'vues/v_listeOuvrages.php';
                        }

                    } catch (PDOException $e) {
                        $tabErreurs[] = "Une exception PDO a été levée !";
                        $hasErrors = true;
                    }
                } else {
                    $tabErreurs[] = "Cet ouvrage est lié à des auteurs, suppression impossible !";
                    $hasErrors = true;
                }
            } catch (PDOException $e) {
                $tabErreurs[] = $e->getMessage();
                $hasErrors = true;
            }
        }
    if ($hasErrors){
        $msg = "Une erreur s'est produite :";
        include 'vues/_v_afficherErreurs.php';
    }
break;
}

    default : include 'vues/_v_home.php';
}
