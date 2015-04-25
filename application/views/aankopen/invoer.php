<!--Dit scherm zal dienen voor offline invoer van de aankopen, op te slaan in de local storage, en met een knop te syncen met de database (temp tabel?)-->
<?php echo validation_errors(); ?>
<form ng-controller="AankoopController" role="form" ng-submit="submitForm()">
    <div class="col-sm-10" style="position: absolute;left: 10%;">
        <div class="well bs-component">
            <div class="container">
                <table>
                    <tr>
                        <td class="col-sm-6">
                            <div class="form-group">
                                <label for="aankoopdatum" class="col-sm-6 control-label">Aankoopdatum</label>

                                <div class="col-sm-6">
                                    <input type="date" class="form-control input-sm" id="aankoopdatum"
                                           ng-model="aankoopdatum" required>
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-6">
                            <div class="form-group">
                                <label for="bestemmeling" class="col-sm-6 control-label">Gekocht voor</label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control input-sm" id="bestemmeling"
                                           ng-model="gekochtvoor" required>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div></div>
    <div class="col-sm-10" style="position: absolute;left: 10%;top: 25%">
        <div class="well bs-component">
            <div class="container">

                <table>
                    <tr>
                        <td class="col-sm-4">

                            <div class="form-group">
                                <label for="artikel" class="col-sm-4 control-label">Naam</label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control input-sm" id="artikel"
                                           ng-model="artikel" required>
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label for="aantal" class="col-sm-4 control-label">Aantal</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="aantal" ng-model="aantal">
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label for="ehprijs" class="col-sm-4 control-label">Eenheidsprijs</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="ehprijs" min="0" step="0.001"
                                           ng-model="ehprijs">
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label for="bedag" class="col-sm-4 control-label">Totale prijs</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="bedrag" readonly
                                           tabindex="-1" value="{{aantal * ehprijs}}">
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-4">
                            <div class="form-group">
                                <label for="container" class="col-sm-4 control-label">Container</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="container"
                                           ng-model="container">
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label for="opzet" class="col-sm-4 control-label">Opzet</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="opzet"
                                           ng-model="opzet">
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label for="tray" class="col-sm-4 control-label">Bruine tray</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="tray"
                                           ng-model="tray">
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label for="doos" class="col-sm-4 control-label">Chrysdoos</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="doos"
                                           ng-model="doos">
                                </div>
                            </div>
                        </td>
                    </tr>


                </table>
                <button type="submit" class="btn btn-default btn-xs">Opslaan</button>
            </div>
        </div>
    </div>
    <div class="col-sm-10" style="position: absolute;left: 10%;top: 55%" bgcolor="red">
<!--        <div class="well bs-component">-->
<!--            <div class="container">-->
                <table class="table table-striped table-hover ">  <!--style="display: block;
  height: 200px;
  overflow-y: scroll;"-->
                    <tr>
                        <th>Artikel</th>
                        <th>Aantal</th>
                        <th>Eh prijs</th>
                        <th>Totaal</th>
                        <th>Container</th>
                        <th>Opzet</th>
                        <th>Bruine Tray</th>
                        <th>Chrysdoos</th>
                    </tr>
                    <tr ng-repeat="aankoop in aankopen">
                        <td>{{aankoop.artikel}}</td>
                        <td>{{aankoop.aantal}}</td>
                        <td>{{aankoop.eenheidsprijs}}</td>
                        <td>{{aankoop.totale_prijs}}</td>
                        <td>{{aankoop.aantal_container}}</td>
                        <td>{{aankoop.aantal_opzet}}</td>
                        <td>{{aankoop.aantal_tray}}</td>
                        <td>{{aankoop.aantal_doos}}</td>
                    </tr>
                </table>
<!--            </div>-->
<!--        </div>-->
    </div>
</form>
<script>
    $(function () {
        $("#bestemmeling").autocomplete({
            source: "gebruikers/get_gebruikers_list"
        });

        $("#artikel").autocomplete({
            source: "artikels/get_list_autofill"
        });
    });
</script>





