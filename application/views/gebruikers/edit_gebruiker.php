<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
echo validation_errors(); ?>
<form ng-controller="EditGebruikerController" role="form" method="post" action='<?php echo base_url();?>gebruikers/update/<?php echo $id ?>'>
    <input class="form-control input-sm" id="var_rol_id"  name="var_rol_id" value="<?php echo $rol_id ?>" style="display: none;">
    <div class="col-sm-11" style="position: absolute;left: 5%;">
        <div class="well bs-component">
            <a href="<?php echo base_url(); ?>gebruikers" class="btn-sm btn-default btn-xs" >Terug</a>
            <div class="container">
                <table class="col-sm-10">
                    <tr>
                        <td class="col-sm-6">
                            <div class="form-group">
                                <label for="voornaam" class="col-sm-6 control-label">Voornaam</label>
                                <div class="col-sm-6">
                                    <input class="form-control input-sm" id="voornaam" name="voornaam"
                                           value="<?php echo $voornaam ?>" required>
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-6">
                            <div class="form-group">
                                <label for="naam" class="col-sm-6 control-label">Naam</label>

                                <div class="col-sm-6">
                                    <input class="form-control input-sm" id="naam" name="naam"
                                           value="<?php echo $naam ?>" required>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-sm-6">
                            <div class="form-group">
                                <label for="email" class="col-sm-6 control-label">E-mail</label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control input-sm" id="email" name="email"
                                           value="<?php echo $email ?>" required>
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-6">
                            <div class="form-group">
                                <label for="type" class="col-sm-6 control-label">Gebruikerstype</label>

                                <div class="col-sm-6">
                                    <select name="type" id="type" ng-model="type" ng-options="r.id as r.rol for r in rollen" class="form-control input-sm" required></select>
                                    <input class="form-control input-sm" id="var_rol_id2"  name="var_rol_id2" value={{type}} style="display: none;">

                                    <!--<select name="type" id="type" ng-model="type" class="form-control input-sm" required>
                                        <option ng-repeat="rol in rollen" value="{{rol.id}}">{{rol.rol}}</option>
                                    </select>-->
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr><td></td><td><button type="submit" class="btn btn-default btn-xs" style="float: right;" >Opslaan</button></td> </tr>
                </table>
            </div>
        </div>
    </div>
</form>


