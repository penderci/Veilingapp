<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
echo validation_errors(); ?>
<form ng-controller="GebruikersController" role="form" ng-submit="submitForm()">
    <div class="col-sm-11" style="position: absolute;left: 5%;">
        <div class="well bs-component">
            <div class="container">
                <table class="col-sm-10">
                    <tr>
                        <td class="col-sm-6">
                            <div class="form-group">
                                <label for="voornaam" class="col-sm-6 control-label">Voornaam</label>
                                <div class="col-sm-6">
                                    <input class="form-control input-sm" id="voornaam"
                                           ng-model="voornaam" required>
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-6">
                            <div class="form-group">
                                <label for="naam" class="col-sm-6 control-label">Naam</label>

                                <div class="col-sm-6">
                                    <input class="form-control input-sm" id="naam"
                                           ng-model="naam" required>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-sm-6">
                            <div class="form-group">
                                <label for="email" class="col-sm-6 control-label">E-mail</label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control input-sm" id="email"
                                           ng-model="email" required>
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-6">
                            <div class="form-group">
                                <label for="email" class="col-sm-6 control-label">Paswoord</label>
                                <div class="col-sm-6">
                                    <input class="form-control input-sm" id="paswoord"
                                           ng-model="paswoord" required>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-sm-6">
                            <div class="form-group">
                                <label for="type" class="col-sm-6 control-label">Gebruikerstype</label>

                                <div class="col-sm-6">
                                    <select name="type" id="type" ng-model="type" ng-options="r.id as r.rol for r in rollen" class="form-control input-sm" required></select>
                                    <!--<select name="type" ng-model="type" class="form-control input-sm" required>
                                        <option ng-repeat="rol in rollen" value="{{rol.id}}">{{rol.rol}}</option>
                                    </select>-->
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-6">
                            <div class="form-group">

                            </div>
                        </td>
                    </tr>
                    <tr><td></td><td><button type="submit" class="btn btn-default btn-xs" style="float: right;" >Opslaan</button></td> </tr>
                </table>
            </div>
        </div>
    </div>

<div class="col-sm-11" style="position: absolute;left: 5%;top: 35%">
    <div style="height: 400px; overflow: auto;">
        <table class="table table-striped table-hover" style="font-size: 12px;">
            <tr>
                <th>Voornaam</th>
                <th>Naam</th>
                <th>Email</th>
                <th>Type</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>

            <!--        <table>-->
            <tr ng-repeat="gebruiker in gebruikers"> <!-- | filter: q as results">-->
                <td>{{gebruiker.voornaam}}</td>
                <td>{{gebruiker.naam}}</td>
                <td>{{gebruiker.email}}</td>
                <td>{{gebruiker.rol}}</td>
                <td>
                    <a href="gebruikers/edit/{{gebruiker.id}}" class="btn-sm glyphicon glyphicon-pencil" tooltip="Wijzig gebruiker" tooltip-trigger tooltip-placement="top"></a>
                </td>
                <td>
                    <a href="#" ng-click="launch_dialog(gebruiker.id, gebruiker.voornaam, gebruiker.naam)" class="btn-sm glyphicon glyphicon-trash" tooltip="Verwijder gebruiker" tooltip-trigger tooltip-placement="top"></a>
                    <!--ng-click="launch_dialog()"                 artikels/delete/{{artikel.id}}-->
                </td>
                <td>
                    <a href="#" class="btn-sm glyphicon glyphicon-link" tooltip="Koppelingen" tooltip-trigger tooltip-placement="top"></a>
                    <!--ng-click="launch_dialog()"                 artikels/delete/{{artikel.id}}-->
                </td>
                <td>
                    <a href="gebruikers/admin_reset_paswoord/{{gebruiker.id}}/{{gebruiker.voornaam}}/{{gebruiker.naam}}" class="btn-sm glyphicon glyphicon-user" tooltip="Paswoord wijzigen" tooltip-trigger tooltip-placement="top"></a>
                    <!--ng-click="launch_dialog()"                 artikels/delete/{{artikel.id}}-->
                </td>

            </tr>
        </table>
    </div>
</div>
</form>