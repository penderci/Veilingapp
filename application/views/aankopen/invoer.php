<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
echo validation_errors(); ?>
<form ng-controller="AankoopController" role="form" ng-submit="submitForm()">
    <div ng-show="!showme">
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
                            <td class="col-sm-6">
                                <div class="form-group">
                                    <label for="bestemmeling" class="col-sm-6 control-label">Gekocht voor</label>

                                    <div class="col-sm-6">
                                        <select name="bestemmeling" ng-model="gekochtvoor" class="form-control input-sm"
                                                required>
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
        <div></div>
        <div class="col-sm-11" style="position: absolute;left: 5%;top: 25%">
            <div class="well bs-component">
                <div class="container">

                    <table class="table">
                        <tr>
                            <td class="col-sm-3">

                                <div class="form-group-sm">
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
                                        <input type="number" class="form-control input-sm" id="aantal"
                                               ng-model="aantal">
                                    </div>
                                </div>
                                <br>

                                <div class="form-group-sm">
                                    <label for="ehprijs" class="col-sm-4 control-label">Eenheidsprijs</label>

                                    <div class="col-sm-6">
                                        <input type="number" class="form-control input-sm" id="ehprijs" min="0"
                                               step="0.001"
                                               ng-model="ehprijs">
                                    </div>
                                </div>
                                <br>

                                <div class="form-group-sm">
                                    <label for="bedag" class="col-sm-4 control-label">Totale prijs</label>

                                    <div class="col-sm-6">
                                        <input type="number" class="form-control input-sm" id="bedrag" readonly min="0"
                                               step="0.01"
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
        <div class="col-sm-11" style="position: absolute;left: 5%;top: 60%">
            <div style="height: 215px; overflow: auto;">
                <table class="table table-striped table-hover" style="height: 50px; overflow: scroll">
                    <tr>
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
                        <th>Totalen</th>
                        <th></th>
                        <th></th>
                        <th style="text-align:right">{{getTotalPrice() | number:2}}</th>
                        <th style="text-align:right">{{getTotalContainer()}}</th>
                        <th style="text-align:right">{{getTotalOpzet()}}</th>
                        <th style="text-align:right">{{getTotalTray()}}</th>
                        <th style="text-align:right">{{getTotalDoos()}}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr ng-repeat="aankoop in aankopen">
                        <td><b>{{aankoop.artikel}}</b></td>
                        <td align="right">{{aankoop.aantal}}</td>
                        <td align="right">{{aankoop.eenheidsprijs | number:3}}</td>
                        <td align="right">{{aankoop.totale_prijs | number:2}}</td>
                        <td align="right">{{aankoop.aantal_container}}</td>
                        <td align="right">{{aankoop.aantal_opzet}}</td>
                        <td align="right">{{aankoop.aantal_tray}}</td>
                        <td align="right">{{aankoop.aantal_doos}}</td>
                        <td>
                            <a href="#" ng-click="showmefn(true, aankoop, null, $index)"
                               class="btn-sm glyphicon glyphicon-pencil"></a>
                        </td>
                        <td>
                            <a href="#" ng-click="delete($index)" class="btn-sm glyphicon glyphicon-trash"></a>
                        </td>
                    </tr>
                </table>

            </div>
            <!--Knop disablen als er geen internetconnectie is -->
            <button type="submit" id="sync" class="btn btn-default btn-xs" style="float: right;"
                    ng-click="synchronize($event)" tooltip="Stuur naar databank" tooltip-trigger
                    tooltip-placement="top">Sychroniseer
            </button>
        </div>
    </div>
    <div ng-show="showme">

        <div class="col-sm-11" style="position: absolute;left: 5%;top: 25%">
            <div class="well bs-component">
                <a href="#" ng-click="showmefn(false,null,'terug',null)" class="btn-sm btn-default btn-xs">Terug</a>

                <div class="container">

                    <table class="table">
                        <tr>
                            <td class="col-sm-3">

                                <div class="form-group-sm">
                                    <label for="upd_artikel" class="col-sm-4 control-label">Artikel</label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control input-sm" id="upd_artikel"
                                               ng-model="upd_artikel">
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
                    <button type="submit" id="update" name="update" ng-click="showmefn(false, null, 'update', null)"
                            class="btn btn-default btn-xs" style="float: right;">Opslaan
                    </button>
                </div>
            </div>
        </div>

    </div>
</form>
<script>
    $(document).ready(function () {

        $.fn.checknet();
        /*standard check interval is 5 sec, to set it to 10 : checknet.config.checkInterval = 1000;*/
        checknet.config.warnMsg = "";

        /*test of bij het laden van het scherm de internetconnectie actief is, zo ja, vul local storage items op met database gegevens*/
        if (window.checknet.conIsActive) {
            console.log('actief');

            /*laad de artikellijst in de localstorage*/
            $.ajax({
                url: "artikels/get_list",
                type: "GET",
                async: false,
                success: function (data) {
                    localStorage.setItem('artikellijst', JSON.stringify(data));
                }
            });
        } else {
            console.log('niet actief');
        }

        $('#aankoopdatum').keydown(function (e) {
            e.preventDefault();
            return false;
        });

        var artikelsJson = JSON.parse(localStorage.getItem('artikellijst'));
        var artikellijst = [];

        for (var i = 0; i < artikelsJson.length; i++) {
            var obj = artikelsJson[i];
            artikellijst.push(obj.naam);
        }

        $("#artikel").autocomplete({
            source: artikellijst
        });

        $("#upd_artikel").autocomplete({
            source: artikellijst
        });

        $('#update').click(function (e) {
            e.preventDefault();
            return false;
        });


    });
</script>





