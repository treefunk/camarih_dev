<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Camarih Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url('flatlab')?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url('flatlab')?>/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?=base_url('flatlab')?>/css/style.css" rel="stylesheet">
    <link href="<?=base_url('flatlab')?>/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-body">

    <div class="container">

      <form class="form-signin" action="<?php echo base_url('admin/auth'); ?>" method="post">
        <h2 class="form-signin-heading">Camarih</h2>
        <div class="login-wrap">
        <?php require_once "partials/alert.php"; ?> 
          
          <input type="text" name="username" id="email" class="form-control" placeholder="Email" autofocus>
          <input type="password" name="password" id="email" class="form-control" placeholder="Password">

          <br><br>
          <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
        </div>

      </form>

    </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?=base_url('flatlab')?>/js/jquery.js"></script>
    <script src="<?=base_url('flatlab')?>/js/bootstrap.min.js"></script>


  </body>
</html>
