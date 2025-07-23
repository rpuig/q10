<?= $this->extend('layouts/home') ?> 

<?= $this->section('content') ?>



<div class="container" style="height:100vh ">
<div class="row h-100 justify-content-center align-items-center">


<div class="col-lg-6 col-md-12 py-3 "> 
    

    <div class="text-center mb-4 ">
       
       
        
            

            <?php if (session()->getFlashdata('failed password')) : ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('failed password') ?>
                </div>
            <?php endif; ?>

            <?= form_open('validateLogin', ['class' => 'card card-md']) ?>   
                <div class="card-body">
                    <?php if(isset($Registered_Message)){ ?>
                        <h2 class="card-title text-center mb-4"><?= $Registered_Message ?></h2>
                    <?php } ?>
                    <h2 class="card-title text-center mb-4">Login to q10</h2>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <?= form_input(['name' => 'username', 'class' => 'form-control', 'placeholder' => 'Enter username']) ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group input-group-flat">

                            <?= form_password(['name' => 'password', 'class' => 'form-control', 'placeholder' => 'Enter password']) ?>
                            <span class="input-group-text">
                                <a id="passwordToggle" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="12" cy="12" r="2"></circle>
                                        <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path>
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="form-footer">
                        <?php $return_url = base_url('users/profile'); ?>
                        <?= form_hidden('return_url', $return_url) ?>
                        <?= form_submit(['name' => 'submit', 'value' => 'Sign in', 'class' => 'btn btn-primary w-100 py-3']) ?>
                    </div>
                </div>
            <?= form_close() ?>
        </div>

        <?php if (isset($session) ){ ?>
            <div class="card-body">
                <!-- Flash messages -->
                <?php if ($session->getFlashdata('success')) : ?>
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-title">Wow! Everything worked!</h4>
                        <div class="text-muted"><?= $session->getFlashdata('success') ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($session->getFlashdata('bad_request')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-title">Error</h4>
                        <div class="text-muted"><?= $session->getFlashdata('bad_request') ?></div>
                    </div>
                <?php endif; ?>

              

               
                
                            <?php if ($session->getFlashdata('error')) : ?>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-title">Error</h4>
                    <?php error_log($session->getFlashdata('error')); // Logs the error to PHP error log ?>

                    <div class="text-muted"><?= $session->getFlashdata('error') ?></div>
                </div>
            <?php endif; ?>


                <?php if ($session->getFlashdata('verification_link')) : ?>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-title">Error</h4>
                    <div class="text-muted"><?= $session->getFlashdata('verification_link') ?></div>
                </div>
            <?php endif; ?>

            <div class="loGRegBox">
                <?php if (isset($validation) && $validation->getErrors()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($validation->getErrors() as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

                <!-- Your existing form here -->
            </div>
                <!-- Flash messages -->
            </div>

            
        <?php } ?>
    </div>
</div>



</div>

</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        var passwordField = document.querySelector('input[name="password"]');
        var toggleButton = document.getElementById('passwordToggle');
        
        toggleButton.addEventListener('click', function (evt) {
            evt.preventDefault();
            if (passwordField.type === 'text') {
                passwordField.type = 'password';
            } else {
                passwordField.type = 'text';
            }
        });
    });
</script>
<script src="<?= base_url(); ?>/assets/js/tabler.min.js"></script>

<?= $this->endSection() ?>

<!-- Libs JS -->
<!-- Tabler Core -->




