<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="dark">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $seo_title ?> </title>

  <!-- Bootstrap Icons (local) -->
  <link rel="stylesheet" href="<?= rtrim(base_url(), '/') ?>/assets/bootstrap-icons/font/bootstrap-icons.css">

  <!-- Custom Styles -->
 
  <link rel="stylesheet" href="<?= rtrim(base_url(), '/') ?>/assets/bootstrap-icons/font/bootstrap-icons.css">


   <link rel="stylesheet" href="<?= rtrim(base_url(), '/') ?>/assets/css/tempus-dominus.min.css">
<!-- Bootstrap CSS (local) -->
<link rel="stylesheet" href="<?= rtrim(base_url(), '/') ?>/assets/css/bootstrap.min.css">
<link href="<?= rtrim(base_url(), '/') ?>/assets/css/custom.css" rel="stylesheet">
<link href="<?= rtrim(base_url(), '/') ?>/assets/css/style.css" rel="stylesheet">
  <!-- jQuery (local) -->
  <script src="<?= rtrim(base_url(), '/') ?>/assets/js/jquery.min.js"></script>
  
  <script src="<?= rtrim(base_url(), '/') ?>/assets/js/popper.min.js"></script>

  <!-- Bootstrap JS (local, includes Popper.js) -->

  <script src="<?= rtrim(base_url(), '/') ?>/assets/js/bootstrap.bundle.min.js"></script>

  <script src="<?= rtrim(base_url(), '/') ?>/assets/js/tempus-dominus.min.js"></script>




  
  <style>
    /* Add custom styles here */
    @media (max-width: 992px) {
      .sidebar-collapse {
        display: none;
      }
    }
  </style>
</head>

<body class="d-flex flex-column">


<main>
<nav class="navbar navbar-expand-lg d-flex flex-row justify-content-between mx-auto">
 

    <button id="collapseButton" class="navbar-toggler" type="button" data-bs-toggle="collapse" 
        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="row px-5 pl-sm-1">
        <a class="navbar-brand " href="home">
            <?php $config = config('App'); echo $config->siteName;?>
        </a>
    </div>
    
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <div class="navbar-nav">
            <?php echo render_menu_left($loggedIn); ?>
           
            <?php echo render_menu_right($loggedIn); ?>
        </div>
    </div>
</nav>



<div class="container">





    
    


     


  <!-- end of navbar |-->

      
<!--Begin row  -->
<div class="row justify-content-center">




  

  

  
    
   
   
      
        
     