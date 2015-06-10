<form ng-controller="AankoopController" role="form" ng-submit="submitForm()">
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
</form>