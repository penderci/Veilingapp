<?php echo validation_errors();?>
<style>
    * {
        margin:0;
        padding:0;
    }
    body {
        padding:10px;
    }
    label {
        display:block;
        font-size:14px;
        margin:10px 0 2px;
    }
    input {
        padding:1px 3px;
    }
    .msg-block {
        margin-top:45px;
    }
    .msg-error {
        color:#F00;
        font-size:14px;
    }
</style>
<form ng-controller="ResetPwdController" ng-submit="submitForm()" name="myForm">
    <div class="col-sm-11" style="position: absolute;left: 5%;top: 10%">
        <div class="well bs-component">
            <div class="container">
                <div class="form-group-sm row">
                    <label for="oudpwd" class="col-sm-4 control-label">Oud paswoord</label>
<!--type="password" -->
                    <div class="col-sm-3">
                        <input class="form-control input-sm" id="oudpwd"
                               ng-model="oudpwd" required>
                    </div>
                </div>
                <br>
                <div class="form-group-sm row">
                    <label for="pw1" class="col-sm-4 control-label">Nieuw paswoord</label>

                    <div class="col-sm-3">
                        <input type="password" class="form-control input-sm" id="pw1" name="pw1"
                               ng-model="pw1" required>
                    </div>
                </div>
                <div class="form-group-sm row">
                    <label for="pw2" class="col-sm-4 control-label">Herhaal nieuw paswoord</label>

                    <div class="col-sm-3">
                        <input type="password" class="form-control input-sm" id="pw2" name="pw2"
                               ng-model="pw2" pw-check="pw1" required>
                    </div>
                </div>
                <div class="msg-block" ng-show="myForm.$error">
                    <span class="msg-error" ng-show="myForm.pw2.$error.pwmatch">
                        De paswoorden zijn niet gelijk!
                    </span>
                </div>
                <br>
                <div class="form-group-sm row">
                    <label class="col-sm-4 control-label"></label>
                    <div class="col-sm-3">
                        <button ng-disabled="myForm.$invalid || pw1 != pw2"  type="submit" class="btn btn-default btn-xs" style="float: right;">Opslaan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
