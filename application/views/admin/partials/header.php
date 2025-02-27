<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Admin - Camarih</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url('flatlab')?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url('flatlab')?>/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?=base_url('flatlab')?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!--right slidebar-->
    <link href="<?=base_url('flatlab')?>/css/slidebars.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=base_url('flatlab')?>/css/style.css" rel="stylesheet">
    <link href="<?=base_url('flatlab')?>/css/style-responsive.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?=base_url('flatlab')?>/css/jquery.steps.css">

    <!-- <link rel="stylesheet" href="<?php //base_url('frontend')?>/css/jquery.filer.css"> -->

    <link href="<?=base_url()?>assets/css/app.css" rel="stylesheet" />

    <link href="<?=base_url('frontend')?>/css/jqueryfiler/jquery.filer.css" rel="stylesheet">
    <link href="<?=base_url('frontend')?>/css/jqueryfiler/jquery.filer-dragdropbox-theme.css" rel="stylesheet">

    <!-- fancybox for gallery -->
    <link href="<?=base_url('flatlab')?>/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=base_url('flatlab')?>/css/gallery.css">

    <!-- datepicker -->
    <link rel="stylesheet" type="text/css" href="<?=base_url('flatlab')?>/assets/bootstrap-datepicker/css/datepicker.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url('flatlab')?>/assets/bootstrap-timepicker/compiled/timepicker.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url('flatlab')?>/css/custom.css">

  <!-- toastr -->
  <link href="<?=base_url('flatlab')?>/assets/toastr-master/toastr.css" rel="stylesheet" type="text/css">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  
      <script src="<?=base_url('flatlab')?>/js/jquery.js"></script>
    <!-- <script src="<?php //base_url('frontend')?>/js/jquery.filer.min.js"></script> -->
    <script src="<?=base_url('frontend')?>/js/jqueryfiler/jquery.filer.min.js" type="text/javascript"></script>
    <script src="<?=base_url('flatlab')?>/js/bootstrap-validator.min.js" type="text/javascript"></script>
    <script src="<?=base_url('flatlab')?>/js/jquery.steps.min.js"></script>
    <script src="<?=base_url('flatlab')?>/js/jquery.stepy.js"></script>

    <script src="<?=base_url('flatlab')?>/assets/fancybox/source/jquery.fancybox.js"></script>
    <script src="<?=base_url('flatlab')?>/js/modernizr.custom.js"></script>
    <script src="<?=base_url('flatlab')?>/js/jquery.scrollTo.min.js"></script>
    <script src="<?=base_url('flatlab')?>/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="<?=base_url('flatlab')?>/js/respond.min.js"></script>
    <script src="<?=base_url('flatlab')?>/js/toucheffects.js"></script>

    <script type="text/javascript" src="<?=base_url('flatlab')?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?=base_url('flatlab')?>/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>



    <script>
      // custom functions
    // function createInfoList(elem,obj){
    //     for(var header_name in obj){
    //       $('<h3>' + header_name + "</h3>").appendTo(elem)
    //        $('<ul>').appendTo(elem)
    //        for(var key in obj[header_name]){
    //            console.log(obj[header_name][key])
    //            var li = "<li style='list-style:none;'>" +
    //            "<label><h4>"+ key +":</h4></label>" +
    //            "<div>" +
    //             obj[header_name][key] +
    //            "</div>"
    //            "</li>"
    //            $(li).appendTo(elem)
    //        }
    //        $('</ul>').appendTo(elem)
    //    }
    // }

    function createInfoList(elem,obj){
      // <div class="form-group">
      //   <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email</label>
      //   <div class="col-lg-10">
      //     <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
      //   </div>
      // </div>
        for(var header_name in obj){
          $('<h3>' + header_name + "</h3>").appendTo(elem)
           $('<div class="form-horizontal" role="form">').appendTo(elem)
           for(var key in obj[header_name]){
               var li = 
               '<div class="form-group">' +
                '<div class="row">' +
                  '<div class="col-lg-3"><label>'+ key +"</label></div>" +
                  '<div class="col-lg-9">' + 
                      '<input type="text" class="form-control" disabled value="' + obj[header_name][key] +'">'
                   +
                  "</div>" +
                  "</div>" +
               "</div>"
               $(li).appendTo(elem)
           }
           $('</div>').appendTo(elem)
       }
    }
    </script>
    
    <!-- <div class="row">
  <div class="col-lg-3">
    <label>a12321</label>
  </div>
  <div class="col-lg-9">
      
  </div>

</div>    
     -->