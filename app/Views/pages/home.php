<?= $this->extend('layouts/home') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->


<div class="container" style="height:100vh ">
            <div class="row h-100">



                  <section id="welcome"  class="row a">

                     <div class=" col align-self-center jumbotron text-center text-white ">

                      <h1 ><?= lang('App.slogan') ?></h1>
                      <h2 >Matching for every type of relationships </h2>
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