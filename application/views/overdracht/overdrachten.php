<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

echo validation_errors();
/*invoer / edit / delete / update van overdrachten */
?>
<style type="text/css">
    .red {
        color: red;
    }

    .green {
        color: green;
    }
</style>
<form ng-controller="OverdrachtController" role="form" class="form-horizontal" ng-submit="submitForm()">
    <div class="col-sm-11" style="position: absolute;left: 5%;top: 10%">
        <div class="well bs-component">
            <div class="container">

                <!-- <table class="table" class="col-sm-6">
                     <tr>
                         <td class="col-sm-3">-->

                <div class="form-group-sm row">
                    <label for="betaaldatum" class="col-sm-4 control-label">Datum</label>
                    <!--style="text-align:left;"-->

                    <div class="col-sm-3">
                        <input ui-date="dateOptions" class="form-control input-sm" id="betaaldatum"
                               ng-model="betaaldatum" required>
                    </div>
                </div>


<!--                <div class="form-group-sm row">
                    <label for="betaaldAan" class="col-sm-4 control-label">Betaald aan</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm" id="betaaldAan"
                               ng-model="betaaldAan" required>
                    </div>
                </div>-->

                <div class="form-group-sm row">
                    <label for="betaaldAan" class="col-sm-4 control-label">Betaald aan</label>
                    <div class="col-sm-3">
                        <select name="betaaldAan" ng-model="betaaldAan" class="form-control">
                            <option ng-repeat="partner in partners" value="{{partner.naam}}">{{partner.naam}}</option>
                        </select>

                    </div>
                </div>


                <div class="form-group-sm row">
                    <label for="bedrag" class="col-sm-4 control-label">Bedrag</label>

                    <div class="col-sm-3">
                        <input type="number" class="form-control input-sm" id="bedrag" ng-model="bedrag" min="0"
                               step="1">
                    </div>
                </div>


                <div class="form-group-sm row">
                    <label for="container" class="col-sm-4 control-label">Container</label>

                    <div class="col-sm-3">
                        <input type="number" class="form-control input-sm" id="container"
                               ng-model="container" min="0" step="1">
                    </div>
                </div>


                <div class="form-group-sm row">
                    <label for="opzet" class="col-sm-4 control-label">Opzet</label>

                    <div class="col-sm-3">
                        <input type="number" class="form-control input-sm" id="opzet"
                               ng-model="opzet" min="0" step="1">
                    </div>
                </div>


                <div class="form-group-sm row">
                    <label for="tray" class="col-sm-4 control-label">Bruine tray</label>

                    <div class="col-sm-3">
                        <input type="number" class="form-control input-sm" id="tray"
                               ng-model="tray" min="0" step="1">
                    </div>
                </div>


                <div class="form-group-sm row">
                    <label for="doos" class="col-sm-4 control-label">Chrysdoos</label>

                    <div class="col-sm-3">
                        <input type="number" class="form-control input-sm" id="doos"
                               ng-model="doos" min="0" step="1">
                    </div>
                </div>


                <div class="form-group-sm row">
                    <label class="col-sm-4 control-label"></label>

                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-default btn-xs">Opslaan
                        </button>
                    </div>
                </div>

                <!--                    </td>
                                </tr>
                            </table>-->
            </div>
        </div>
    </div>


    <div class="col-sm-11" style="position: absolute;left: 5%;top: 45%">
        <div style="height: 350px; overflow: auto;">
            <table class="table table-striped table-hover" style="font-size: 12px;">
                <caption>Uitgevoerde betalingen aan geselecteerde partner</caption>
                <tr>
                    <th>Datum</th>
<!--                    <th>Aan</th>-->
                    <th style="text-align:right">Bedrag</th>
                    <th style="text-align:right">Container</th>
                    <th style="text-align:right">Opzet</th>
                    <th style="text-align:right">Bruine Tray</th>
                    <th style="text-align:right">Chrysdoos</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th>Openstaand</th>
                    <!--                    <th></th>-->
                    <th style="text-align:right" ng-class="{ green: diff_totaal_delta >= 0, red: diff_totaal_delta < 0}">{{diff_totaal_delta | number:2}}</th>
                    <th style="text-align:right" ng-class="{ green: diff_container_delta >= 0, red: diff_container_delta < 0}">{{diff_container_delta}}</th>
                    <th style="text-align:right" ng-class="{ green: diff_opzet_delta >= 0, red: diff_opzet_delta < 0}">{{diff_opzet_delta}}</th>
                    <th style="text-align:right" ng-class="{ green: diff_tray_delta >= 0, red: diff_tray_delta < 0}">{{diff_tray_delta}}</th>
                    <th style="text-align:right" ng-class="{ green: diff_doos_delta >= 0, red: diff_doos_delta < 0}">{{diff_doos_delta}}</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th>Totalen</th>
<!--                    <th></th>-->
                    <th style="text-align:right">{{getTotalBetaald()}}</th>
                    <th style="text-align:right">{{getTotalContainer()}}</th>
                    <th style="text-align:right">{{getTotalOpzet()}}</th>
                    <th style="text-align:right">{{getTotalTray()}}</th>
                    <th style="text-align:right">{{getTotalDoos()}}</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr ng-repeat="betaling in betalingen">
                    <td><b>{{betaling.datum | date:"dd/MM/yyyy"}}<br>&nbsp</b></td>
<!--                    <td align="right">{{betaling.koppeling_id}}</td>-->
                    <td align="right">{{betaling.bedrag}}</td>
                    <td align="right">{{betaling.aantal_container}}</td>
                    <td align="right">{{betaling.aantal_opzet}}</td>
                    <td align="right">{{betaling.aantal_tray}}</td>
                    <td align="right">{{betaling.aantal_doos}}</td>
                    <td>
                        <a href="#" class="btn-sm glyphicon glyphicon-pencil" tooltip="Wijzig overdracht" tooltip-trigger tooltip-placement="top"></a>
                    </td>
                    <td>
                        <a href="#" ng-click="delete_overdracht(betaling.id)" class="btn-sm glyphicon glyphicon-trash" tooltip="Verwijder overdracht" tooltip-trigger tooltip-placement="top"></a>
<!--                        <a href="overdrachten/delete/{{betaling.id}}" class="btn-sm glyphicon glyphicon-trash"></a>-->
                    </td>
                </tr>
            </table>

        </div>
    </div>


</form>
<script>
    $(document).ready(function () {
        $("#betaaldAan").autocomplete({
            source: "gebruikers/get_gebruikers_list_autofill"
        });

        $('#betaaldatum').keydown(function (e) {
            e.preventDefault();
            return false;
        });

        /*$('#vandatum').keydown(function(e) {
         e.preventDefault();
         return false;
         });

         $('#totdatum').keydown(function(e) {
         e.preventDefault();
         return false;
         });*/


        /*var datum = new Date();
         var jaar = datum.getFullYear();
         $( "#vandatum" ).datepicker('setDate', new Date('01/01/' + jaar));
         $( "#totdatum" ).datepicker('setDate', new Date());*/


    });
</script>
