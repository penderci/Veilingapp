<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*invoer / edit / delete / update van overdrachten */
?>
<form ng-controller="OverdrachtController" role="form" class="form-horizontal">
<div class="col-sm-11" style="position: absolute;left: 5%;top: 10%">
    <div class="well bs-component">
        <div class="container">

           <!-- <table class="table" class="col-sm-6">
                <tr>
                    <td class="col-sm-3">-->

                        <div class="form-group-sm row">
                            <label for="betaaldatum" class="col-sm-4 control-label" >Datum</label> <!--style="text-align:left;"-->

                            <div class="col-sm-3">
                                <input ui-date="dateOptions" class="form-control input-sm" id="betaaldatum"
                                       ng-model="betaaldatum" required>
                            </div>
                        </div>



                        <div class="form-group-sm row">
                            <label for="betaaldAan" class="col-sm-4 control-label">Betaald aan</label>
<!--                            <input type="hidden"  ng-model="primaryPartner">-->
                            <div class="col-sm-3">
                                <select name="betaaldAan" ng-model="betaaldAan">
                                    <option ng-repeat="partner in partners" value="{{partner.naam}}">{{partner.naam}}</option>
                                </select>
                                <!--<input type="text" class="form-control input-sm" id="betaaldAan"
                                       ng-model="betaaldAan" required>-->
                            </div>
                        </div>



                        <div class="form-group-sm row">
                            <label for="bedrag" class="col-sm-4 control-label">Bedrag</label>

                            <div class="col-sm-3">
                                <input type="number" class="form-control input-sm" id="bedrag" ng-model="bedrag">
                            </div>
                        </div>


                        <div class="form-group-sm row">
                            <label for="container" class="col-sm-4 control-label">Container</label>

                            <div class="col-sm-3">
                                <input type="number" class="form-control input-sm" id="container"
                                       ng-model="container">
                            </div>
                        </div>


                        <div class="form-group-sm row">
                            <label for="opzet" class="col-sm-4 control-label">Opzet</label>

                            <div class="col-sm-3">
                                <input type="number" class="form-control input-sm" id="opzet"
                                       ng-model="opzet">
                            </div>
                        </div>


                        <div class="form-group-sm row">
                            <label for="tray" class="col-sm-4 control-label">Bruine tray</label>

                            <div class="col-sm-3">
                                <input type="number" class="form-control input-sm" id="tray"
                                       ng-model="tray">
                            </div>
                        </div>


                        <div class="form-group-sm row">
                            <label for="doos" class="col-sm-4 control-label">Chrysdoos</label>

                            <div class="col-sm-3">
                                <input type="number" class="form-control input-sm" id="doos"
                                       ng-model="doos">
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


<!--<div class="col-sm-11" style="position: absolute;left: 5%;top: 45%">
    <div style="height: 550px; overflow: auto;">
        <table class="table table-striped table-hover" style="font-size: 12px;">
            <caption>Uitgevoerde betalingen</caption>
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
                <th>Totalen</th>
                <th></th>
                <th></th>
                <th></th>
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
                    <a href="#" class="btn-sm glyphicon glyphicon-pencil"></a>
                </td>
                <td>
                    <a href="aankopen/delete/{{aankoop.id}}" class="btn-sm glyphicon glyphicon-trash"></a>
                </td>
            </tr>
        </table>

    </div>
</div>-->


</form>