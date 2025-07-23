<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="jumbotron text-center bg-primary text-white">
    <div class="container">
        <h1 class="jumbotron-heading">Welcome to <?php echo $siteName?></h1>
        <p class="lead">Explore a collection of unique and inspiring articles. Dive in now!</p>
        <p>
            <a href="#" class="btn btn-light my-2">Explore Now</a>
            <a href="#" class="btn btn-secondary my-2">Learn More</a>
        </p>
    </div>
</section>



<!-- Latest Blog Posts Section -->
<section class="py-5"> 
<div class="container d-flex flex-column">
  
    <div class="card">    
        <h2 class="display-4">Latest Matches </h2>
        <div class="row">
           
        </div>

        </div>
    
        <div class="card">
            <h2 class="display-4">Featured Users</h2>
            <div class="row">
               
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>