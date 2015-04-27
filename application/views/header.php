<!DOCTYPE html>
<html ng-app="veilingapp">
<head lang="en">
    <meta charset="UTF-8">
    <title>Veilingadministratie</title>
    <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>assets/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>assets/checknet/css/checknet.css" media="all">

    <!--Credits for the checknet plugin : http://tomriley.net/blog/archives/tomriley.net-->


</head>
<body>
<script type="text/javascript" src="<?php echo base_url();?>assets/jquery/dist/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>angular/angular.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>angular/angular-local-storage.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/checknet/js/jquery.checknet-1.6.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>app.js"></script>

<div class="navbar navbar-default navbar-fixed-top" style="text-align:center">
    <h1 class="navbar-header" style="color:white">Veilingadministratie</h1>

    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="<?php echo base_url();?>aankopen">Aankopen</a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Admin <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="artikels">Artikels</a></li>
                <li class="divider"></li>
                <li><a href="#">Gebruikers</a></li>
            </ul>
        </li>
        <li>&nbsp &nbsp &nbsp &nbsp</li>
    </ul>

</div>
<h1>Veilingadministratie</h1>
<?php if ($this->session->userdata('is_logged_in')) { ?>
<a href="<?php echo base_url();?>login/logout">Log Uit</a>
<?php }?>