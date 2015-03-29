<!DOCTYPE html>
<html ng-app="veilingapp">
<head lang="en">
    <meta charset="UTF-8">
    <title>Veilingadministratie</title>
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
<!--    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap.css" rel="stylesheet">-->
<!--    <link href="./bootstrap/css/bootstrap.css" rel="stylesheet">-->
    <!--//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/sandstone/bootstrap.min.css /bootstrap/css/bootstrap.min.css -->

</head>
<body>
<script src="http://code.jquery.com/jquery-2.1.3.js"></script>
<script src="./assets/js/bootstrap.js"></script>
<script src="./angular/angular.js"></script>
<script type="text/javascript" src="app.js"></script>

<div class="navbar navbar-default navbar-fixed-top" style="text-align:center">
    <h1 class="navbar-header" style="color:white">Veilingadministratie</h1>
</div>
<h1>Veilingadministratie</h1>
<?php if ($this->session->userdata('is_logged_in')) { ?>
<a href="<?php echo base_url();?>login/logout">Log Uit</a>
<?php }?>