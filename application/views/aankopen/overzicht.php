<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
echo validation_errors(); ?>
<form ng-controller="OverzichtController" role="form"">
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
    <div style="height: 550px; overflow: auto;">
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
                            <th colspan="4">Totalen voor geselcteerde periode</th>
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
                                <a href="#" class="btn-sm glyphicon glyphicon-pencil"></a>
                            </td>
                            <td>
                                <a href="aankopen/delete/{{aankoop.id}}" class="btn-sm glyphicon glyphicon-trash"></a>
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
                            <th></th>
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
                            <th></th>
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