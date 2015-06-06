<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
echo validation_errors(); ?>
<form ng-controller="KoppelingController" ng-submit="submitForm()" name="myForm">
    <div class="col-sm-11" style="position: absolute;left: 5%;top: 10%">
        <div class="well bs-component">
            <a href="<?php echo base_url(); ?>gebruikers" class="btn-sm btn-default btn-xs" >Terug</a>
            <b><?php echo 'Gekoppelde gebruikers voor ' . $naam?></b>
            <!--<div class="container"><b>
                    <?php /*echo 'Wijzig het paswoord voor ' . 'nog invullen'*/?>

                </b></div>-->
            <div><br></div>
            <input class="form-control input-sm" id="id"  name="id" value="<?php echo $id ?>" style="display: none;">
            <div class="container">
                <div class="form-group-sm row">
                    <label for="gebruikers" class="col-sm-4 control-label">Beschikbare gebruikers</label>
                    <!--type="password" -->
                    <div class="col-sm-3">
                        <select name="gebruiker" id="gebruiker" ng-model="gebruiker" ng-options="g.id as g.naam for g in gebruikers" class="form-control input-sm" required>
                            <option></option>
                        </select>
                        <br>
                        <button type="submit" class="btn btn-default btn-xs" style="float: right;" >Maak koppeling</button>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="col-sm-11" style="position: absolute;left: 5%;top: 30%">
        <div style="height: 400px; overflow: auto;">
            <caption>Gekoppelde gebruikers</caption>
            <table class="table table-striped table-hover" style="font-size: 12px;">
                <tr>
                    <th>Naam</th>
                    <th>Primair</th>
                    <th></th>
                </tr>

                <!--        <table>-->
                <tr ng-repeat="koppel in gekoppelde_gebruikers"> <!-- | filter: q as results">-->
                    <td>{{koppel.naam}}</td>
                    <td><input type="checkbox"
                               ng-model="koppel.primair"
                               ng-true-value="'1'"
                               ng-false-value="'0'"
                               ng-click="updateSelection($index, gekoppelde_gebruikers, koppel.koppeling_id)"
                               ></td>


                 <!--   name="primair"
                    ng-true-value="1"
                    ng-false-value="0"
                    ng-change="string"-->

                    <td>
                        <a href="#" ng-click="launch_dialog(koppel.koppeling_id, koppel.naam)" class="btn-sm glyphicon glyphicon-trash" tooltip="Verwijder koppeling" tooltip-trigger tooltip-placement="top"></a>
                        <!--ng-click="launch_dialog()"                 artikels/delete/{{artikel.id}}-->
                    </td>

                </tr>
            </table>
        </div>
    </div>

</form>
