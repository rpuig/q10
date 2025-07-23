<?= $this->extend('layouts/home') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->


<div class="container" style="height:100vh ">
            <div class="row h-100">



                  <section id="welcome"  class="row a">

                     <div class=" col align-self-center jumbotron text-center text-white ">

                      <h1 class="display-4"><?= lang('App.about') ?></h1>
                      <h2 class="display-4">The power of better choices </h2>
                      </div>  
                     
                  </section>


                  <!-- Latest Blog Posts Section -->
                  <section id="Action" class="row text-center"> 

                      <div class="container d-flex flex-column">    
                      <div class="jumbotron text-left">   
                      <br>
                      <button id="welcome_button" class="transition_btn">                
                      <a>Get Free Access</a>                
                      </button>
                      </div>
                      </div>
                      
                   </section>


              </div>

 </div>

<?= $this->endSection() ?>