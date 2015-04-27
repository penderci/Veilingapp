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

                <table class="table">
                    <tr>
                        <td class="col-sm-3">

                            <div class="form-group-sm ui-widget">
                                <label for="artikel" class="col-sm-4 control-label">Naam</label>

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
                                           ng-model="container">
                                </div>
                            </div>
                            <br>

                            <div class="form-group-sm">
                                <label for="opzet" class="col-sm-4 control-label">Opzet</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="opzet"
                                           ng-model="opzet">
                                </div>
                            </div>
                            <br>

                            <div class="form-group-sm">
                                <label for="tray" class="col-sm-4 control-label">Bruine tray</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="tray"
                                           ng-model="tray">
                                </div>
                            </div>
                            <br>

                            <div class="form-group-sm">
                                <label for="doos" class="col-sm-4 control-label">Chrysdoos</label>

                                <div class="col-sm-6">
                                    <input type="number" class="form-control input-sm" id="doos"
                                           ng-model="doos">
                                </div>
                            </div>
                        </td>
                    </tr>


                </table>
                <button type="submit" class="btn btn-default btn-xs" style="float: right;">Opslaan</button>
            </div>
        </div>
    </div>
    <div class="col-sm-10" style="position: absolute;left: 10%;top: 60%" >
<!--        <div class="well bs-component">-->
<!--            <div class="container">-->
        <div style="height: 215px; overflow: auto;">
                <table class="table table-striped table-hover" style="height: 50px; overflow: scroll">  <!--style="display: block;
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
                        <th></th>
                    </tr>
                    <tr>
                        <th>Totalen</th>
                        <th></th>
                        <th></th>
                        <th>{{getTotalPrice()}}</th>
                        <th>{{getTotalContainer()}}</th>
                        <th>{{getTotalOpzet()}}</th>
                        <th>{{getTotalTray()}}</th>
                        <th>{{getTotalDoos()}}</th>
                        <th></th>
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
                        <td>
                            <a href="#" class="btn-sm glyphicon glyphicon-pencil"></a>
                            <a href="#" class="btn-sm glyphicon glyphicon-trash"></a>
                        </td>
                    </tr>
                </table>

        </div>
        <!--Knop disablen als er geen internetconnectie is -->
        <button type="submit" id="sync" class="btn btn-default btn-xs" style="float: right;">Sychroniseer</button>

<!--            </div>-->
<!--        </div>-->
    </div>
</form>
<script>
    $( document ).ready(function(){
    //$(function () {
        $.fn.checknet(); /*standard check interval is 5 sec, to set it to 10 : checknet.config.checkInterval = 1000;*/
        checknet.config.warnMsg = "";

        /*test of bij het laden van het scherm de internetconnectie actief is, zo ja, vul local storage items op met database gegevens*/
        if(window.checknet.conIsActive){
            console.log('actief');

            /*laad de artikellijst in de localstorage*/
            $.ajax({
                url: "artikels/get_list",
                type: "GET",
                async: false,
                success: function (data) {
                    console.log('succes');
                    //  console.log(data);
                    localStorage.setItem('artikellijst',JSON.stringify(data));
                }});

            /*laad de gebruikers in die gekoppeld zijn aan de ingelogde gebruiker*/
            $.ajax({
                url: "gebruikers/get_gebruikers_list",
                type: "GET",
                async: false,
                success: function (data) {
                    console.log('succes');
                    //  console.log(data);
                    localStorage.setItem('gebruikerslijst',JSON.stringify(data));
                }});


        } else {
            console.log('niet actief');
        }

        var artikelsJson = JSON.parse(localStorage.getItem('artikellijst'));
        var artikellijst = [];

        for(var i = 0; i < artikelsJson.length; i++) {
            var obj = artikelsJson[i];
            artikellijst.push(obj.naam);
        }

        var gebruikersJson = JSON.parse(localStorage.getItem('gebruikerslijst'));
        var gebruikerslijst = [];

        for(var i = 0; i < gebruikersJson.length; i++) {
            var obj = gebruikersJson[i];
            gebruikerslijst.push(obj.naam);
        }


        $("#bestemmeling").autocomplete({
            source: gebruikerslijst //"gebruikers/get_gebruikers_list"
        });

        $("#artikel").autocomplete({
            source: artikellijst /*"artikels/get_list_autofill"*/
        });


        //********** Onderstaaande code werkt****************************/
        /*$.ajax({
            url: "artikels/get_list",
            type: "GET",
            async: false,
            success: function (data) {
                console.log('succes');
                console.log(data);
                localStorage.setItem('artikellijst',JSON.stringify(data));
            }});

            $arts = JSON.parse(localStorage.getItem('artikellijst'));
            console.log($arts);*/
        //**************************************************************/
    });
</script>





