<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
  <title><?= $seo_title ?> </title> 
  
   <!-- Bootstrap Icons (local) -->
   <link rel="stylesheet" href="<?= rtrim(base_url(), '/') ?>/assets/bootstrap-icons/font/bootstrap-icons.css">

<!-- Custom Styles -->

<link rel="stylesheet" href="<?= rtrim(base_url(), '/') ?>/assets/bootstrap-icons/font/bootstrap-icons.css">

<!-- Bootstrap CSS (local) -->
<link rel="stylesheet" href="<?= rtrim(base_url(), '/') ?>/assets/css/bootstrap.min.css">
<link href="<?= rtrim(base_url(), '/') ?>/assets/css/custom.css" rel="stylesheet">
<link href="<?= rtrim(base_url(), '/') ?>/assets/css/style.css" rel="stylesheet">
<!-- jQuery (local) -->
<script src="<?= rtrim(base_url(), '/') ?>/assets/js/jquery.min.js"></script>
<script src="<?= rtrim(base_url(), '/') ?>/assets/js/popper.min.js"></script>
<!-- Bootstrap JS (local, includes Popper.js) -->
<script src="<?= rtrim(base_url(), '/') ?>/assets/js/bootstrap.bundle.min.js"></script>
  
  
  <style>
        /* Add custom styles here */
        @media (max-width: 992px) { /* Collapse sidebar on medium and smaller screens */
            .sidebar-collapse {
                display: none;
            }
        }
    </style>

    <!-- header home -->

</head>

<body class="home">

<div class="home-container container">

   <nav data-bs-theme="light" class="navbar navbar-nav-home navbar-expand-lg navbar-light  mx-auto zindex-2 ">  <!-- begin of navbar |-->
   <?php $config = config('App');?>
      <a class="navbar-brand ps-1" href="<?= $config->baseURL?>"> <h1> 
      <?= $config->siteName?></h1></a>  
          
        <button id=collapseButton class="navbar-toggler" type="button" data-bs-toggle="collapse" 
        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
              <div class="navbar-nav">
                <?php echo render_menu_left($loggedIn); ?>
                <li class='nav-item me-3'>
                
                </li>
                <?php echo render_menu_right($loggedIn); ?>
              </div>
        </div>
      
      </nav>
    
    


     


  <!-- end of navbar |-->

      
<!--Begin row  -->
<div class="row justify-content-center">



 <!-- <div  class="col-sm p-3 min-vh-100 l-12">   -->
  

  

  
    
   
   
      
        
     