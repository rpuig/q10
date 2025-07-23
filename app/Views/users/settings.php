


<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
   


<!-- begin of content |-->
        <div class="col-sm-12 col-md-6 col-lg-10 p-3">

                           <?php 
                           
                           $errors=session('errors');
                           
                           if (! empty($errors)): ?>
                         <div class="alert alert-danger" role="alert">
                         <ul>
                        <?php foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                        </ul>

                         <!-- Language Switcher Button -->
                       
                       </div>
                             <?php endif ?>
                              <?php echo form_open_multipart('UpdateUserSettings', 'id="updateAllForm"') ?>
                            <!-- User Profile Data |-->
                        <div class="card">

                            <div class="card-header">
                              

                                <h3 class="card-title"><?= lang('App.settings') ?></h3>
                            </div>

                           


                            <div class="card-body">
                                    <h4 class="card-title"><?= lang('App.email') ?></h4>
                                    
                                        <div class="row">
                                        <div class="col">    
                                    
                                        <?= form_input(['name' => 'email', 'value' => $email, 'placeholder' => $email, 'class' => 'form-control', 'id' => 'email']); ?>        
                                        <?= session('errors.email')  ?>
                                    </div>
                                        <?= form_hidden('userid', $userid); ?>
                                        <?= form_hidden('value', 'email'); ?>
                                        <div class="col-md-2">
                                        </div>
                                
                                    </div>
                            </div>
                                
                         
                                
                            <div class="card-body">
                            <h4 class="card-title"><?= lang('App.password') ?></h4>
                                    
                                        <div class="row">
                                        <div class="col">    
                                    
                                        <?= form_password(['name' => 'password', 'maxlength'=>10,'value' => $password, 'placeholder' => $password, 'class' => 'form-control', 'id' => 'password']); ?>        
                                        <?= session('errors.email')  ?>
                                    </div>
                                        <?= form_hidden('userid', $userid); ?>
                                        <?= form_hidden('value', 'password'); ?>
                                        <div class="col-md-2">

                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="showPasswordBtn">Show</button>
                                        </div>
                                        </div>
                                
                                    </div>
                            </div>

                   
                            
                                 <?= form_input(['type' => 'hidden', 'name' => 'userid', 'id' => 'alluserID', 'value' => $userid]); ?>
                                <?= form_submit(['name' => 'btnsubmit', 'id' => 'btnsubmit'], 'Update All'); ?>
                                <?php echo form_close(); ?> 

                           
                </div>
                <div class="card">
                <div class="card-body">
                                    <h4 class="card-title">Delete account forever</h4>
                                    
                                        <div class="row">
                                        <div class="col">    
                                    
                                      

                                        <div class="input-group-append">
                                        <a href="delete4ever" class="btn btn-outline-secondary" id="deleteAccount">Delete</a>
                                        </div>
                                        </div>
                                
                                    </div>
                            </div>

                <div class="card-body">
                                    <h4 class="card-title">Delete account in 30 days</h4>
                                    
                                        <div class="row">
                                        <div class="col">    
                                    
                                      

                                        <div class="input-group-append">
                                        <a href="deleteSoft" class="btn btn-outline-secondary" id="deleteAccount">Delete</a>
                                        </div>
                                        </div>
                                
                                    </div>
                </div>
                 
            </div>


            <div class="card-body">
                                    <h4 class="card-title">Display preferences</h4>
                                    
                                        <div class="row">
                                        <div class="col">    
                                    
                                      

                                        <div class="input-group-append"><br>
                                        <button id="theme-toggle-btn" class="btn btn-secondary">Toggle Theme</button>
                                        </div>
                                        </div>
                                
                                    </div>
            </div>

           
            <div class="card-body">
                                    <h4 class="card-title"></h4>
                                    
                                        <div class="row">
                                        <div class="col">    
                                    
                                      

                                        <div class="input-group-append">
                                    <?= form_dropdown('language', [
                                        'en' => 'English', 
                                        'es' => 'Español'
                                    ], $user['language'], ['class' => 'form-control', 'id' => 'languageSelect']) ?>
                                    <button id="switchLangBtn" class="btn btn-secondary">Switch</button>
                                </div>

                                        </div>

                                        
                                
                                    </div>
            </div>



              
                 
            </div>

          
             
        </div>

       
        
       

                
<script>
        $(document).ready(function() {
            $('#birthDate').datepicker({
                format: 'dd/mm/yyyy'
            });
        });
</script><script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>   


<script>
    document.getElementById('showPasswordBtn').addEventListener('click', function() {
        var passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.textContent = 'Hide';
        } else {
            passwordInput.type = 'password';
            this.textContent = 'Show';
        }
    });
</script>

<!-- Add JavaScript to handle language switch -->
<script>


document.getElementById('switchLangBtn').addEventListener('click', function (e) {
    e.preventDefault(); // Prevent the button's default behavior

    const language = document.getElementById('languageSelect').value;

    fetch('<?= base_url('updateLanguage') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '<?= csrf_hash() ?>', // Add CSRF token for security
        },
        body: JSON.stringify({ language }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Language updated successfully!');
            location.reload(); // Reload the page to apply the new language
        } else {
            console.log('Failed to update language.');
        }
    })
    .catch(error => console.error('Error:', error));
});

    



</script>

<?= $this->endSection() ?>

