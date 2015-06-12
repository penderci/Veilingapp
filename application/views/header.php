<!DOCTYPE html>
<html ng-app="veilingapp">
<head lang="en">
    <meta charset="UTF-8">
    <title>Veilingadministratie</title>
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/checknet/css/checknet.css" media="all">

    <!--Credits for the checknet plugin : http://tomriley.net/blog/archives/tomriley.net-->

</head>
<body>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery/dist/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>angular/angular.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>angular/angular-local-storage.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/checknet/js/jquery.checknet-1.6.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/angular-ui-date/src/date.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>angular/angular-sanitize.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>angular/angular-bootstrap/ui-bootstrap-tpls.js"></script>
<script type="text/javascript"
        src="<?php echo base_url(); ?>angular/angular-dialog-service/dist/dialogs.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>app.js"></script>

<div class="navbar navbar-default navbar-fixed-top" style="text-align:center">
    <h1 class="navbar-header" style="color:white">Veilingadministratie</h1>
    <?php if (!isset($active)) {
        $active = 'Menu';
    } ?>


    <?php if ($this->session->userdata('is_logged_in')) { ?>


        <ul class="nav navbar-nav navbar-right">
            <?php if ($active == 'Registratie'){ ?>
        <li class="active">
        <?php } else { ?>
            <li>
                <?php } ?>
                <a href="<?php echo base_url(); ?>aankopen">Registratie</a>
            </li>
            <?php if ($active == 'Overzicht'){ ?>
        <li class="active">
        <?php } else { ?>
            <li>
                <?php } ?>
                <a href="<?php echo base_url(); ?>overzicht">Overzicht</a>
            </li>
            <?php if ($active == 'Overdracht'){ ?>
        <li class="active">
        <?php } else { ?>
            <li>
                <?php } ?>
                <a href="<?php echo base_url(); ?>overdrachten">Overdracht</a>
            </li>
            <?php if ($active == 'Menu'){ ?>
            <li class="dropdown active">
                <?php } else { ?>
            <li class="dropdown">
                <?php } ?>

                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Admin
                    <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="<?php echo base_url(); ?>artikels">Artikels</a></li>
                    <li><a href="<?php echo base_url(); ?>gebruikers/reset_paswoord">Reset Paswoord</a></li>

                    <?php if ($this->session->userdata('rol') && $this->session->userdata('rol') == '2') { ?>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>gebruikers">Gebruikers</a></li>
                    <?php } ?>
                </ul>
            </li>
            <li>&nbsp; &nbsp; &nbsp; &nbsp;</li>
        </ul>
    <?php } ?>
</div>
<h1>Veilingadministratie</h1>
<?php if ($this->session->userdata('is_logged_in')) { ?>
<a href="<?php echo base_url(); ?>login/logout">Log Uit</a>
<?php } ?>