<?php echo validation_errors();
echo $this->input->post('inputEmail');
echo '<br>';
echo $this->input->post('inputPassword');
?>
<div class="row">
    <div class="col-sm-6" style="position: absolute;left: 25%;">
        <div class="well bs-component">
            <form class="form-horizontal" action="<?php echo base_url(). 'login/login_validation' ?>" method="post">
                <fieldset>
                    <legend>Log in</legend>
                    <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                        <div class="col-sm-6">
                            <input class="form-control" id="inputEmail" name="inputEmail" placeholder="Email" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-2 control-label">Password</label>

                        <div class="col-sm-6">
                            <input class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
