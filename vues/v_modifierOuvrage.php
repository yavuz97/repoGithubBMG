<?php
/**
 * Page de gestion des auteurs

  * @author
  * @package default
 */
?>
<div id="content">
    <h2>Gestion des ouvrages</h2>
    <div id="object-list">
        <form action="index.php?uc=gererOuvrages&action=modifierOuvrage&option=validerOuvrage&id=<?php echo $leOuvrage->getNoOuvrage() ?>" method="post">
            <div class="corps-form">
                <fieldset>
                    <legend>Modifier un ouvrage</legend>
                    <table>
                        <tr>
                            <td>
                                <label for="txtID">
                                    ID :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtID"
                                    name="txtID"
                                    size="5"
                                    readonly="readonly"
                                    value="<?php echo $leOuvrage->getNoOuvrage() ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtTitre">
                                    Titre :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtTitre"
                                    name="txtTitre"
                                    size="5"
                                    value="<?php echo $leOuvrage->getTitre() ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtAuteur">
                                    Auteur(s) :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtAuteur"
                                    name="txtAuteur"
                                    size="50" maxlength="128"
                                  
                                    value="<?php echo $leOuvrage->getLesAuteurs() ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtDateA">
                                    Date d'acquisition :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtDateA"
                                    name="txtDateA"
                                    size="50" maxlength="128"
                                    value="<?php echo $leOuvrage->getDateAcquisition() ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="cbxGenres">
                                 Genre :
                                </label>
                            </td>
                            <td>
                            <?php
                                 afficherListe($lesGenres,"cbxGenres",$strGenre,"");
                            ?>
                            </td>
                        </tr>
                        <tr>
                                            <td>
                                                <label for="rbnSalle">Salle :</label>
                                            </td>
                                            <td>
                                                <input type="radio" id="rbnSalle" name="rbnSalle" value="1"
                                                    <?php
                                                        if ($intSalle == 1) {
                                                            echo 'checked="checked"';
                                                        }
                                                    ?>
                                                />
                                                <label>1</label>
                                                <input type="radio" id="rbnSalle" name="rbnSalle" value="2"
                                                    <?php
                                                        if ($intSalle == 2) {
                                                            echo 'checked="checked"';
                                                        }
                                                    ?>
                                                />
                                                <label>2</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="txtRayon">
                                                    Rayon :
                                                </label>
                                            </td>
                                            <td>
                                                <input
                                                    type="text" id="txtRayon"
                                                    name="txtRayon"
                                                    size="2" maxlength="2"
                                                    <?php
                                                        if (!empty($strRayon)) {
                                                            echo ' value="'.$strRayon.'"';
                                                        }
                                                    ?>
                                                />
                                            </td>
                                        </tr>
                        <tr>
                            <td>
                                <label for="txtDernierPret">
                                    Dernier prêt :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtDernierPret"
                                    name="txtDernierPret"
                                    size="5"
                                    readonly="readonly"
                                    value="<?php echo $leOuvrage->getDernierPret() ?>"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtDispo">
                                    Disponibilité :
                                </label>
                            </td>
                            <td>
                                <input
                                    type="text" id="txtDispo"
                                    name="txtDispo"
                                    size="5"
                                    readonly="readonly"
                                    value="<?php echo $leOuvrage->getDisponibilite() ?>"
                                />
                            </td>
                        </tr>

                        <tr>
                          <td><label for="file">photo de couverture :</label> </td>
                          <td> <input type="file" name="file" id="file">
                        </tr>
                    </table>
                </fieldset>
            </div>
            <div class="pied-form">
                <p>
                    <input id="cmdValider" name="cmdValider"
                           type="submit"
                           value="Modifier"
                    />
                </p>
            </div>
        </form>
    </div>
</div>
