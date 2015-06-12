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
                            <td class="col-sm-6">
                                <div class="form-group">
                                    <label for="partner" class="col-sm-3 control-label">Partner</label>

                                    <div class="col-sm-6">
                                        <select name="partner" ng-model="partner" class="form-control input-sm">
                                            <option ng-repeat="partner in partners" value="{{partner.naam}}">
                                                {{partner.naam}}
                                            </option>
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
                            <table class="table table-striped table-hover" style="font-size: 12px;">
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
                                    <th colspan="4" tooltip="Jouw totaal - totaal partner" tooltip-trigger
                                        tooltip-placement="top">Eindbalans
                                    </th>
                                    <th style="text-align:right"
                                        ng-class="{ green: diff_totaal_delta >= 0, red: diff_totaal_delta < 0}">
                                        {{diff_totaal_delta | number:2}}
                                    </th>
                                    <th style="text-align:right"
                                        ng-class="{ green: diff_container_delta >= 0, red: diff_container_delta < 0}">
                                        {{diff_container_delta}}
                                    </th>
                                    <th style="text-align:right"
                                        ng-class="{ green: diff_opzet_delta >= 0, red: diff_opzet_delta < 0}">
                                        {{diff_opzet_delta}}
                                    </th>
                                    <th style="text-align:right"
                                        ng-class="{ green: diff_tray_delta >= 0, red: diff_tray_delta < 0}">
                                        {{diff_tray_delta}}
                                    </th>
                                    <th style="text-align:right"
                                        ng-class="{ green: diff_doos_delta >= 0, red: diff_doos_delta < 0}">
                                        {{diff_doos_delta}}
                                    </th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr ng-repeat="da in delta_aankopen">
                                    <th colspan="4">Balans na aftrek overdrachten</th>
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
                                        <a href="#" ng-click="showmefn(true, aankoop, null)"
                                           class="btn-sm glyphicon glyphicon-pencil" tooltip="Wijzig aankoop"
                                           tooltip-trigger tooltip-placement="top"></a>
                                    </td>
                                    <td>
                                        <a href="#" ng-click="delete_aankoop(aankoop.id)"
                                           class="btn-sm glyphicon glyphicon-trash" tooltip="Verwijder aankoop"
                                           tooltip-trigger tooltip-placement="top"></a>
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
        <div class="col-sm-11" style="position: absolute;left: 5%;">
            <div class="well bs-component">
                <a href="#" ng-click="showmefn(false,null,'terug')" class="btn-sm btn-default btn-xs">Terug</a>

                <div class="container">
                    <b>Wijzig aankoop voor {{partner}} op {{upd_datum | date:"dd/MM/yyyy"}}</b>
                    <table class="table">
                        <tr>
                            <td class="col-sm-3">

                                <div class="form-group-sm">
                                    <label for="upd_artikel" class="col-sm-4 control-label">Artikel</label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control input-sm" id="upd_artikel"
                                               ng-model="upd_artikel" value="update_ak.naam" required>
                                    </div>
                                </div>
                                <br>

                                <div class="form-group-sm">
                                    <label for="upd_aantal" class="col-sm-4 control-label">Aantal</label>

                                    <div class="col-sm-6">
                                        <input type="number" class="form-control input-sm" id="upd_aantal"
                                               ng-model="upd_aantal">
                                    </div>
                                </div>
                                <br>

                                <div class="form-group-sm">
                                    <label for="upd_ehprijs" class="col-sm-4 control-label">Eenheidsprijs</label>

                                    <div class="col-sm-6">
                                        <input type="number" class="form-control input-sm" id="upd_ehprijs" min="0"
                                               step="0.001"
                                               ng-model="upd_ehprijs">
                                    </div>
                                </div>
                                <br>

                                <div class="form-group-sm">
                                    <label for="upd_bedag" class="col-sm-4 control-label">Totale prijs</label>

                                    <div class="col-sm-6">
                                        <input type="number" class="form-control input-sm" id="upd_bedrag" readonly
                                               min="0" step="0.01"
                                               tabindex="-1" value="{{upd_aantal * upd_ehprijs}}">
                                    </div>
                                </div>
                            </td>
                            <td class="col-sm-3">
                                <div class="form-group-sm">
                                    <label for="upd_container" class="col-sm-4 control-label">Container</label>

                                    <div class="col-sm-6">
                                        <input type="number" class="form-control input-sm" id="upd_container"
                                               ng-model="upd_container" min="0" step="1">
                                    </div>
                                </div>
                                <br>

                                <div class="form-group-sm">
                                    <label for="upd_opzet" class="col-sm-4 control-label">Opzet</label>

                                    <div class="col-sm-6">
                                        <input type="number" class="form-control input-sm" id="upd_opzet"
                                               ng-model="upd_opzet" min="0" step="1">
                                    </div>
                                </div>
                                <br>

                                <div class="form-group-sm">
                                    <label for="upd_tray" class="col-sm-4 control-label">Bruine tray</label>

                                    <div class="col-sm-6">
                                        <input type="number" class="form-control input-sm" id="upd_tray"
                                               ng-model="upd_tray" min="0" step="1">
                                    </div>
                                </div>
                                <br>

                                <div class="form-group-sm">
                                    <label for="upd_doos" class="col-sm-4 control-label">Chrysdoos</label>

                                    <div class="col-sm-6">
                                        <input type="number" class="form-control input-sm" id="upd_doos"
                                               ng-model="upd_doos" min="0" step="1">
                                    </div>
                                </div>
                            </td>
                        </tr>


                    </table>
                    <button type="submit" class="btn btn-default btn-xs" style="float: right;"
                            ng-click="showmefn(false, null, 'update')">Opslaan
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>
<script>
    $(document).ready(function () {

        $("#upd_artikel").autocomplete({
            source: "artikels/get_list_autofill"
        });

        $('#vandatum').keydown(function (e) {
            e.preventDefault();
            return false;
        });

        $('#totdatum').keydown(function (e) {
            e.preventDefault();
            return false;
        });


    });
</script>