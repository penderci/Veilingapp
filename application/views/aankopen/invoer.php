<!--Dit scherm zal dienen voor offline invoer van de aankopen, op te slaan in de local storage, en met een knop te syncen met de database (temp tabel?)-->

<form class="form-horizontal" role="form" ng-controller="AankoopController" ng-submit=""> <!--form-inline-->
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
                                           ng-model="aankoopdatum">
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-6">
                            <div class="form-group">
                                <label for="bestemmeling" class="col-sm-6 control-label">Gekocht voor</label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control input-sm" id="bestemmeling"
                                           ng-model="gekochtvoor">
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

                                <div class="col-sm-6" >
                                    <input type="text" class="form-control input-sm" id="artikel"
                                           ng-model="artikel">

                                    <!--                        <select name="artikel" id="artikel" ng-model="artikel">-->
                                    <!--ng-options="orderBy:naam"    onchange = "calljavascriptfunction();">-->
                                    <!--                            --><?php //foreach ($artikels as $row) { ?>
                                    <!--                                <option value="-->
                                    <?php //echo $row->id ?><!--">-->
                                    <?php //echo $row->naam ?><!--</option>-->
                                    <!--                            --><?php //} ?>
                                    <!--                        </select>-->
                                    <!--<input type="text" class="form-control input-sm" id="naam">-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="aantal" class="col-sm-4 control-label">Aantal</label>

                                <div class="col-sm-4" >
                                    <input type="number" class="form-control input-sm" id="aantal" ng-model="aantal">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ehprijs" class="col-sm-4 control-label">Eenheidsprijs</label>

                                <div class="col-sm-4" >
                                    <input type="number" class="form-control input-sm" id="ehprijs" min="0" step="0.01"
                                           ng-model="ehprijs">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bedag" class="col-sm-4 control-label">Totale prijs</label>

                                <div class="col-sm-4" >
                                    <input type="number" class="form-control input-sm" id="bedrag" readonly tabindex="-1" value="{{aantal * ehprijs}}">
                                </div>

<!--                                <div class="col-sm-4">
                                    <select name="leeggoed" id="leeggoed" ng-model="leeggoed">
                                        <!-- onchange = "calljavascriptfunction();">-->
                                        <?php /*foreach ($leeggoed as $row) { */?>
<!--                                            <option value="--><?php ///*echo $row->id */?><!--">--><?php ///*echo $row->naam */?><!--</option>-->
                                        <?php /*} */?>
<!--                                    </select>-->
<!--                                    <button type="submit" class="btn btn-default btn-xs" name="addleeggoed">+</button>-->
                                <!--  </div>-->

                            </div>


                        </td>
                        <td class="col-sm-4">
                            <div class="form-group">
                                <label for="container" class="col-sm-4 control-label">Container</label>
                                <div class="col-sm-6" >
                                    <input type="number" class="form-control input-sm" id="container"
                                           ng-model="container">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="opzet" class="col-sm-4 control-label">Opzet</label>
                                <div class="col-sm-6" >
                                    <input type="number" class="form-control input-sm" id="opzet"
                                           ng-model="opzet">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tray" class="col-sm-4 control-label">Bruine tray</label>
                                <div class="col-sm-6" >
                                    <input type="number" class="form-control input-sm" id="tray"
                                           ng-model="tray">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="doos" class="col-sm-4 control-label">Chrysdoos</label>
                                <div class="col-sm-6" >
                                    <input type="number" class="form-control input-sm" id="doos"
                                           ng-model="doos">
                                </div>
                            </div>
                        </td>
                    </tr>


                </table>
                <button type="submit" class="btn btn-default btn-xs" name="opslaan">Opslaan</button>
            </div>
        </div>
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




