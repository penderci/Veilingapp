<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
echo validation_errors(); ?>
<form ng-controller="OverzichtController" role="form"">
<div class="col-sm-10" style="position: absolute;left: 10%;">
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
                                <input type="text" class="form-control input-sm" id="partner"
                                       ng-model="partner" required>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</form>
<script>
    $(document).ready(function () {
        $("#partner").autocomplete({
            source: "gebruikers/get_gebruikers_list_autofill"
        });
    });
</script>