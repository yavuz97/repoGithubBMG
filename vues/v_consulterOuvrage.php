
        <div id="content">
            <h2>Gestion des ouvrages</h2>
            <div id="object-list">
                    <div class="corps-form">
                        <fieldset>
                            <legend>Consulter un ouvrage</legend>
                            <div id="breadcrumb">
                                <a href="index.php?uc=gererOuvrages&action=ajouterOuvrage">Ajouter</a>&nbsp;
                                <a href="index.php?uc=gererOuvrages&action=modifierOuvrage&id=<?php echo $leOuvrage->getNoOuvrage() ?>">Modifier</a>&nbsp;
                                <a href="index.php?uc=gererOuvrages&action=supprimerOuvrage&id=<?php echo $leOuvrage->getNoOuvrage() ?>">Supprimer</a>
                            </div>
                            <table>
                                <tr>
                                    <td class="h-entete">
                                        ID :
                                    </td>
                                    <td class="h-valeur">
                                        <?php echo $leOuvrage->getNoOuvrage() ?>
                                    </td>
                                    <td class="right h-valeur" rowspan="8">

                                  <img src="<?php echo "img/couvertures/".$leOuvrage->getImage() ?>"/>



                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-entete">
                                        Titre :
                                    </td>
                                    <td class="h-valeur">
                                        <?php echo $leOuvrage->getTitre(); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-entete">
                                        Auteur(s) :
                                    </td>
                                    <td class="h-valeur">
                                        <?php echo $leOuvrage->getListeNomsAuteurs() ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-entete">
                                        Date d'acquisition :
                                    </td>
                                    <td class="h-valeur">
                                        <?php echo $leOuvrage->getDateAcquisition() ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-entete">
                                        Genre :
                                    </td>
                                    <td class="h-valeur">
                                        <?php echo $leOuvrage->getLeGenre()->getLibelle() ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-entete">
                                        Salle et rayon :
                                    </td>
                                    <td class="h-valeur">
                                        <?php echo $leOuvrage->getSalle()." ".$leOuvrage->getRayon() ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-entete">
                                        Dernier prêt :
                                    </td>
                                    <td class="h-valeur">
                                        <?php
                                        if ($leOuvrage->getDernierPret() == null ){
                                            ?>
                                            <p style="color:red;"> non communiqué </p>
                                            <?php
                                        }
                                        else {
                                         echo $leOuvrage->getDernierPret();
                                        }
                                         ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-entete">
                                        Disponibilité :
                                    </td>
                                    <td class="h-valeur">
                                        <?php
                                        if ( $leOuvrage->getDisponibilite() == "D"){
                                            echo '<img src="img/dispo.png" alt="yes" />';
                                        }
                                        else {
                                            echo '<img src="img/emprunte.png" alt="yes" />';
                                        }

                                        ?>
                                    </td>
                                </tr>
                            </table>


                        </fieldset>
                    </div>
            </div>
        </div>
