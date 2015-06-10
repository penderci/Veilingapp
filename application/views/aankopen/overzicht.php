<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
echo validation_errors(); ?>
<style type="text/css">
    .red {
        color: red;
    }

    .green {
        color: green;
    }
</style>
<form ng-controller="OverzichtController" role="form">
<div ng-show="!showme">
<div class="col-sm-11" style="position: absolute;left: 5%;">
    <div class="well bs-component">
        <div class="container">
            <table>
                <tr>
                    <td class="col-sm-3">
                        <div class="form-group">
                            <label for="vandatum" class="col-sm-3 control-label">Van</label>

                            <div class="col-sm-6">
                                <input ui-date="dateOptions" class="form-control input-sm" id="vandatum"
                                       ng-model="vandatum" required>
                            </div>
                        </div>
                    </td>
                    <td class="col-sm-3">
                        <div class="form-group">
                            <label for="totdatum" class="col-sm-3 control-label">Tot</label>

                            <div class="col-sm-6">
                                <input ui-date="dateOptions" class="form-control input-sm" id="totdatum"
                                       ng-model="totdatum" required>
                            </div>
                        </div>
                    </td>
<!--                    <td class="col-sm-6">
                        <div class="form-group">
                            <label for="partner" class="col-sm-3 control-label">Partner</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control input-sm" id="partner"
                                       ng-model="partner" required>
                            </div>
                        </div>
                    </td>-->
                    <td class="col-sm-6">
                        <div class="form-group">
                            <label for="partner" class="col-sm-3 control-label">Partner</label>
                            <div class="col-sm-6">
                                <select name="partner" ng-model="partner" class="form-control input-sm">
                                    <option ng-repeat="partner in partners" value="{{partner.naam}}">{{partner.naam}}</option>
                                </select>

                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>


<div class="col-sm-11" style="position: absolute;left: 5%;top: 25%">
    <div style="height: 500px; overflow: auto;">
        <table>
            <tr>
                <td VALIGN="top">
                    <table class="table table-striped table-hover" style="font-size: 12px;"> <!--style="height: 50px; overflow: scroll">  <!--style="display: block;
  height: 200px;
  overflow-y: scroll;"-->
                        <caption>Mijn aankopen</caption>
                        <tr>
                            <th>Datum</th>
                            <th>Artikel</th>
                            <th style="text-align:right">Aantal</th>
                            <th style="text-align:right">Eh prijs</th>
                            <th style="text-align:right">Totaal</th>
                            <th style="text-align:right">Container</th>
                            <th style="text-align:right">Opzet</th>
                            <th style="text-align:right">Bruine Tray</th>
                            <th style="text-align:right">Chrysdoos</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="4" tooltip="Jouw totaal - totaal partner" tooltip-trigger tooltip-placement="top">Eindbalans</th>
                            <!--<th></th>
                            <th></th>
                            <th></th>-->
                            <th style="text-align:right" ng-class="{ green: diff_totaal_delta >= 0, red: diff_totaal_delta < 0}">{{diff_totaal_delta | number:2}}</th>
                            <th style="text-align:right" ng-class="{ green: diff_container_delta >= 0, red: diff_container_delta < 0}">{{diff_container_delta}}</th>
                            <th style="text-align:right" ng-class="{ green: diff_opzet_delta >= 0, red: diff_opzet_delta < 0}">{{diff_opzet_delta}}</th>
                            <th style="text-align:right" ng-class="{ green: diff_tray_delta >= 0, red: diff_tray_delta < 0}">{{diff_tray_delta}}</th>
                            <th style="text-align:right" ng-class="{ green: diff_doos_delta >= 0, red: diff_doos_delta < 0}">{{diff_doos_delta}}</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr ng-repeat="da in delta_aankopen">
                            <th colspan="4">Balans na aftrek overdrachten</th>
                            <!--<th></th>
                            <th></th>
                            <th></th>-->
                            <th style="text-align:right">{{da.totaal_delta | number:2}}</th>
                            <th style="text-align:right">{{da.container_delta}}</th>
                            <th style="text-align:right">{{da.opzet_delta}}</th>
                            <th style="text-align:right">{{da.tray_delta}}</th>
                            <th style="text-align:right">{{da.doos_delta}}</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="4">Totalen voor geselecteerde periode</th>
                            <!--<th></th>
                            <th></th>
                            <th></th>-->
                            <th style="text-align:right">{{getTotalPriceAk() | number:2}}</th>
                            <th style="text-align:right">{{getTotalContainerAk()}}</th>
                            <th style="text-align:right">{{getTotalOpzetAk()}}</th>
                            <th style="text-align:right">{{getTotalTrayAk()}}</th>
                            <th style="text-align:right">{{getTotalDoosAk()}}</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr ng-repeat="aankoop in ak_gedaan">
                            <td><b>{{aankoop.datum | date:"dd/MM/yyyy"}}<br>&nbsp</b></td>
                            <td><b>{{aankoop.naam}}</b></td>
                            <td align="right">{{aankoop.aantal}}</td>
                            <td align="right">{{aankoop.eenheidsprijs | number:3}}</td>
                            <td align="right">{{aankoop.aantal * aankoop.eenheidsprijs| number:2}}</td>
                            <td align="right">{{aankoop.aantal_container}}</td>
                            <td align="right">{{aankoop.aantal_opzet}}</td>
                            <td align="right">{{aankoop.aantal_tray}}</td>
                            <td align="right">{{aankoop.aantal_doos}}</td>
                            <td>
<!--                                <a href="aankopen/edit_aankoop/{{aankoop.id}}" ng-click="load_edit(aankoop.id)" target="_blank" class="btn-sm glyphicon glyphicon-pencil" tooltip="Wijzig aankoop" tooltip-trigger tooltip-placement="top"></a>-->
                                <a href="#" ng-click="showmefn(true)" class="btn-sm glyphicon glyphicon-pencil" tooltip="Wijzig aankoop" tooltip-trigger tooltip-placement="top"></a>
                            </td>
                            <td>
                                <a href="#" ng-click="delete_aankoop(aankoop.id)" class="btn-sm glyphicon glyphicon-trash" tooltip="Verwijder aankoop" tooltip-trigger tooltip-placement="top"></a>
<!--                                <a href="aankopen/delete/{{aankoop.id}}" class="btn-sm glyphicon glyphicon-trash"></a>-->
                            </td>
                        </tr>
                    </table>
                </td>
                <td VALIGN="top">
                    <table class="table table-striped table-hover" style="font-size: 12px;">
                        <caption>Aankopen van partner</caption>
                        <tr>
                            <th>Datum</th>
                            <th>Artikel</th>
                            <th style="text-align:right">Aantal</th>
                            <th style="text-align:right">Eh prijs</th>
                            <th style="text-align:right">Totaal</th>
                            <th style="text-align:right">Container</th>
                            <th style="text-align:right">Opzet</th>
                            <th style="text-align:right">Bruine Tray</th>
                            <th style="text-align:right">Chrysdoos</th>
                        </tr>

                        <tr>
                            <th colspan="9">&nbsp;</th>
                        </tr>

                        <tr ng-repeat="do in delta_ontvangen">
                            <th colspan="4"></th>
                            <!--<th></th>
                            <th></th>
                            <th></th>-->
                            <th style="text-align:right">{{do.totaal_delta | number:2}}</th>
                            <th style="text-align:right">{{do.container_delta}}</th>
                            <th style="text-align:right">{{do.opzet_delta}}</th>
                            <th style="text-align:right">{{do.tray_delta}}</th>
                            <th style="text-align:right">{{do.doos_delta}}</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align:right">{{getTotalPriceOntv() | number:2}}</th>
                            <th style="text-align:right">{{getTotalContainerOntv()}}</th>
                            <th style="text-align:right">{{getTotalOpzetOntv()}}</th>
                            <th style="text-align:right">{{getTotalTrayOntv()}}</th>
                            <th style="text-align:right">{{getTotalDoosOntv()}}</th>
                        </tr>
                        <tr ng-repeat="aankoop in ak_ontvangen">
                            <td><b>{{aankoop.datum | date:"dd/MM/yyyy"}}<br>&nbsp</b></td>
                            <td><b>{{aankoop.naam}}</b></td>
                            <td align="right">{{aankoop.aantal}}</td>
                            <td align="right">{{aankoop.eenheidsprijs | number:3}}</td>
                            <td align="right">{{aankoop.aantal * aankoop.eenheidsprijs| number:2}}</td>
                            <td align="right">{{aankoop.aantal_container}}</td>
                            <td align="right">{{aankoop.aantal_opzet}}</td>
                            <td align="right">{{aankoop.aantal_tray}}</td>
                            <td align="right">{{aankoop.aantal_doos}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </div>
</div>

</div>
<div ng-show="showme">
    <a href="#" ng-click="showme=false">Terug</a>
    <div class="col-sm-11" style="position: absolute;left: 5%;">
        <div class="well bs-component">
            <div class="container">
                <table class="col-sm-11">
                    <tr>
                        <td class="col-sm-6">
                            <div class="form-group">
                                <label for="aankoopdatum" class="col-sm-6 control-label">Aankoopdatum</label>

                                <div class="col-sm-6">
                                    <input ui-date="dateOptions" class="form-control input-sm" id="aankoopdatum"
                                           ng-model="aankoopdatum" required>
                                </div>
                            </div>
                        </td>
                        <!-- <td class="col-sm-6">
                             <div class="form-group">
                                 <label for="bestemmeling" class="col-sm-6 control-label">Gekocht voor</label>

                                 <div class="col-sm-6">
                                     <input type="text" class="form-control input-sm" id="bestemmeling"
                                            ng-model="gekochtvoor" required>
                                 </div>
                             </div>
                         </td>-->
                        <td class="col-sm-6">
                            <div class="form-group">
                                <label for="bestemmeling" class="col-sm-6 control-label">Gekocht voor</label>
                                <div class="col-sm-6">
                                    <select name="bestemmeling" ng-model="gekochtvoor" class="form-control input-sm" required>
                                        <option ng-repeat="partner in partners" value="{{partner.naam}}">{{partner.naam}}</option>
                                    </select>

                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!--</div>
        <div></div>
        <div class="col-sm-11" style="position: absolute;left: 5%;top: 25%">-->
        <div class="well bs-component">
            <div class="container">

                <table class="table">
                    <tr>
                        <td class="col-sm-3">

                            <div class="form-group-sm"> <!--ui-widget-->
                                <label for="artikel" class="col-sm-4 control-label">Artikel</label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control input-sm" id="artikel"
                                           ng-model="artikel" required>
                                </div>
                            </div>
                            <br>

                            <div class="form-group-sm">
                                <label for="aantal" class="col-sm-4 control-label">Aantal</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="aantal" ng-model="aantal">
                                </div>
                            </div>
                            <br>

                            <div class="form-group-sm">
                                <label for="ehprijs" class="col-sm-4 control-label">Eenheidsprijs</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="ehprijs" min="0" step="0.001"
                                           ng-model="ehprijs">
                                </div>
                            </div>
                            <br>

                            <div class="form-group-sm">
                                <label for="bedag" class="col-sm-4 control-label">Totale prijs</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="bedrag" readonly min="0" step="0.01"
                                           tabindex="-1" value="{{aantal * ehprijs}}">
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-3">
                            <div class="form-group-sm">
                                <label for="container" class="col-sm-4 control-label">Container</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="container"
                                           ng-model="container" min="0" step="1">
                                </div>
                            </div>
                            <br>

                            <div class="form-group-sm">
                                <label for="opzet" class="col-sm-4 control-label">Opzet</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="opzet"
                                           ng-model="opzet" min="0" step="1">
                                </div>
                            </div>
                            <br>

                            <div class="form-group-sm">
                                <label for="tray" class="col-sm-4 control-label">Bruine tray</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="tray"
                                           ng-model="tray" min="0" step="1">
                                </div>
                            </div>
                            <br>

                            <div class="form-group-sm">
                                <label for="doos" class="col-sm-4 control-label">Chrysdoos</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="doos"
                                           ng-model="doos" min="0" step="1">
                                </div>
                            </div>
                        </td>
                    </tr>


                </table>
                <button type="submit" class="btn btn-default btn-xs" style="float: right;">Opslaan</button>
            </div>
        </div>
    </div>
</div>

</form>
<script>
    $(document).ready(function () {
        $("#partner").autocomplete({
            source: "gebruikers/get_gebruikers_list_autofill"
        });

        $('#vandatum').keydown(function(e) {
            e.preventDefault();
            return false;
        });

        $('#totdatum').keydown(function(e) {
            e.preventDefault();
            return false;
        });


        /*var datum = new Date();
         var jaar = datum.getFullYear();
         $( "#vandatum" ).datepicker('setDate', new Date('01/01/' + jaar));
         $( "#totdatum" ).datepicker('setDate', new Date());*/


    });
</script>