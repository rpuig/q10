<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
   


<!-- begin of content |-->
        <div class="col-sm-12 col-md-12 col-lg-10 p-3">

                              <!-- Full profile picture  Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- modal-xl for extra large modal -->
                        <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?= $username ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                                <img src=<?=$profpicture ?> class="img-fluid" alt="Full size image">
                        </div>
                        </div>
                        </div>
                        </div>   

                <?php echo form_open_multipart('updateAllProfile', 'id="updateAllForm"') ?>
                    <!-- User Profile Data |-->
                <div class="card">

                            <div class="card-header">

                            <div class="row align-items-center">
                            <div class="col">
                            <h3 class="card-title text-capitalize"><?= $username ?></h3>
                            </div>
                            <div class="col-auto">
                            <?= form_submit(['name' => 'btnsubmit','class'=>'btn btn-outline-primary','id' => 'btnsubmit'],  lang('App.button_update_prof') ); ?>

                            <a href="<?=base_url('publicProfile') ?>" class="btn btn-secondary"><?=   lang('App.button_preview_prof') ?> </a>
                            
                            </div>
                            </div>

                        <div class="card-body">
                        <h4 class="card-title"><?= lang('App.profile_picture') ?></h4>
                                    <div class="col-lg-5">
                                    <button type="button" class="btn " data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <img src="<?=$profpicture ?>" class="img-fluid rounded w-100 h-50 py-1"  alt="Profile Picture">
                                    </button>

                                    </div>
                                    <div class="row">
                                    <div class="col-lg-5">
                                    <?= form_upload(['name' => 'profilepicture', 'class' => 'form-control my-2','value' => old('profilepicture') , 'id' => 'profilepicture','label' => 'Upload Picture']); ?>        
                                            <?php if(session('errors.profilepicture')): ?> <p class="alert alert-danger" role="alert"> <?= session('errors.profilepicture')  ?> </p><?php endif; ?>  
                                  
                                    <?= form_hidden('value', 'profilepicture'); ?>
                                    </div>
                                    <hr>
                                    </div>
                            </div>

                                
                        <div class="card-body">
                        <h4 class="card-title"><?= lang('App.name') ?></h4>
                        <div class="row">
                                    <div class="col">                            
                                    <?= form_input(['name' => 'name', 'value' => set_value('name', $name), 'placeholder' => $name, 'class' => 'form-control', 'id' => 'name']); ?> 
                                    <?php if(session('errors.name')): ?> <p class="alert alert-danger" role="alert">  <?= session('errors.name')  ?>    </p><?php endif; ?>                                      
                                    <div class="float-end"> <label class="px-2" for="visibilityname">Show  in Public Profile</label>
                                 

                                    <input class="form-check-input" type="checkbox" value="1" <?= isset(json_decode($visibility_settings)->name) && json_decode($visibility_settings)->name == "1" ? 'checked' : '' ?> id="visibilityname" name="visibilityname">
                                    </div>
                                  
                                    <?= form_hidden('value', 'name'); ?>
                                    <div class="col-md-2"> 
                                    </div>
                                    </div>
                            </div>
                            </div>  
                            
                            
                        <div class="card-body">
                        <h4 class="card-title"><?= lang('App.surname') ?></h4>
                        <div class="row">
                                        <div class="col">                            
                                        <?= form_input(['name' => 'surname', 'value' => set_value('surname', $surname), 'placeholder' => $surname, 'class' => 'form-control', 'id' => 'surname']); ?> 
                                        <?php if(session('errors.surname')): ?> 
                                                <p class="alert alert-danger" role="alert"> <?= session('errors.surname') ?> </p>
                                        <?php endif; ?>                                    
                                        <div class="float-end"> 
                                                <label class="px-2" for="visibilitysurname">Show in Public Profile</label>
                                                <input class="form-check-input" type="checkbox" value="1" <?= isset(json_decode($visibility_settings)->surname) && json_decode($visibility_settings)->surname == "1" ? 'checked' : '' ?> id="visibilitysurname" name="visibilitysurname">
                                        </div>
                                        <?= form_hidden('value', 'surname'); ?>
                                        <div class="col-md-2"> 
                                        </div>
                                        </div>
                                </div>
                                </div>

                       
                        <div class="card-body">
                        <h4 class="card-title"><?= lang('App.sex') ?></h4>
                        <div class="row">
                                        <div class="col">
                                        <?= form_dropdown('sex', array_combine(\App\Models\User::$sexOptions, \App\Models\User::$sexOptions), set_value('sex', $sex), ['class'=>"form-control",'id' => 'sex']);?>
                                        <div class="float-end"> 
                                                <label class="px-2" for="visibilitysex">Show in Public Profile</label>
                                                <input class="form-check-input" type="checkbox" value="1" <?= isset(json_decode($visibility_settings)->sex) && json_decode($visibility_settings)->sex == "1" ? 'checked' : '' ?> id="visibilitysex" name="visibilitysex">
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                        </div>
                                        <?= form_hidden('value', 'sex'); ?>
                                </div>
                                </div>


                        <div class="card-body">
                        <h4 class="card-title"><?= lang('App.looking_for') ?></h4>
                        <div class="row">
                                        <div class="col">
                                    <?= form_dropdown('lookingfor', array_combine(\App\Models\userInterests::$LookingForOptions, \App\Models\userInterests::$LookingForOptions),set_value('lookingfor', $lookingFor["lookingfor"]) , ['class'=>"form-control",'id' => 'lookingfor']);?>
                                    <div class="float-end"> <label  class="px-2" for="visibilitylookingfor">Show  in Public Profile</label>
                                 
                                    <input class="form-check-input" type="checkbox" value="1" <?= isset(json_decode($visibility_settings)->lookingFor) && json_decode($visibility_settings)->lookingFor == "1" ? 'checked' : '' ?> id="visibilitylookingfor" name="visibilitylookingfor">

                                    </div>
                                    <div class="col-md-2">
                                    </div>
                                    </div>
                                 
                                    <?= form_hidden('value', 'looking'); ?>
                            
                            </div>
                            </div>

                        <div class="card-body">
                        <h4 class="card-title"><?= lang('App.profession') ?></h4>
                        <div class="row">
                                    <div class="col">
                                    <?= form_dropdown('profession', array_combine(\App\Models\UserProf::$professionOptions, \App\Models\UserProf::$professionOptions),  set_value('profession', $profession), ['class'=>"form-control",'id' => 'profession']) ?>
                                    <div class="float-end"> <label class="px-2" for="visibilityprofession">Show  in Public Profile</label>
                                   
                                    <input class="form-check-input" type="checkbox" value="1" <?= isset(json_decode($visibility_settings)->profession) && json_decode($visibility_settings)->profession == "1" ? 'checked' : '' ?> id="visibilityprofession" name="visibilityprofession">

                                    </div>                                  
                                        <div class="col-md-2">
                                    </div>
                                    </div>                                 
                               
                                    <?= form_hidden('value', 'profession'); ?>                              
                            </div>
                            </div>
                            

                        <div class="card-body"> 
                        <h4 class="card-title"><?= lang('App.birth_date') ?></h4>
                        <div class="row">
                                    <div class="col">
                                    <div class="input-group date" id="datepicker">
                                    <?php if( $birthdate!=NULL && $birthdate!='//') echo form_input(['name' => 'birthdate', 'type' => 'text', 'class' => 'form-control', 'id' => 'birthDate', 'value' => $birthdate]);
                                    else
                                    echo form_input(['name' => 'birthdate', 'type' => 'text', 'class' => 'form-control', 'id' => 'birthDate', 'value' => '']);
                                    ?>
                                    </div>
                                    <?php if(session('errors.birthdate')): ?> <p class="alert alert-danger" role="alert">   <?= session('errors.birthdate') ?>     </p><?php endif; ?>    
                                    <div class="float-end"> <label class="px-2"for="visibilitybdate">Show  in Public Profile</label>
                                    <input class="form-check-input" type="checkbox" value="1" <?= isset(json_decode($visibility_settings)->bdate) && json_decode($visibility_settings)->bdate == "1" ? 'checked' : '' ?> id="visibilitybdate" name="visibilitybdate">
                                        </div>
                                    <div class="col-md-2">              
                                        </div>
                                        </div>
                                
                                    <?= form_hidden('value', 'birthdate');?>  
                                    </div>
                            </div>

                        <div class="card-body">
                        <h4 class="card-title"><?= lang('App.birth_time') ?></h4>                                  

                                   
                                    <div class="row">
                                    <div class="col">
                                    <?php 
                                    if ($birthtime != NULL) {

                                    echo form_input(['name' => 'birthtime', 'type' => 'text', 'class' => 'form-control  datetimepicker-input', 'id' => 'timepicker', 'value' => $birthtime, 'placeholder' => $birthtime]); 
                                  
                                            }

                                    
                                    else 

                                    echo form_input(['name' => 'birthtime', 'type' => 'text', 'class' => 'form-control  datetimepicker-input', 'id' => 'timepicker', 'value' => '12:00', 'placeholder' => 'dd/mm/yyyy']);         
                                   
                                      ?> 
                                 
                                    <?php if(session('errors.birthtime')): ?> <p class="alert alert-danger" role="alert">   <?= session('errors.birthtime') ?>  </p><?php endif; ?>  
                                    <div class="float-end">  
                                    <label class="form-check-label px-2" for="unknownTimeCheckbox">Unknown Time</label>
                                    <input class="form-check-input" type="checkbox" value="1" <?= isset($unknownTime) && $unknownTime === "1" ? 'checked' : '' ?> id="unknownTimeCheckbox" name="unknown_time">
                                    
            

                                    </div> 
                                </div>
                        </div>
                        </div> 

                        <div class="card-body">
                        <h4 class="card-title"><?= lang('App.time_zone') ?></h4>
                        <div class="row">
                                <div class="col">
                        <?php 
                            echo form_input(['name' => 'timezone_display', 'type' => 'text', 'class' => 'form-control', 'id' => 'timezone', 'value' => $timezone, 'placeholder' => $timezone]); 
                              ?> 
                                                        
                        </div> 
                        </div>
                        </div>
                        




                        <div class="card-body">
                        <h4 class="card-title"><?= lang('App.city_of_birth') ?></h4>
                        <div class="row">
                                        <div class="col">
                                        <?= form_input(['name' => 'city', 'value' => $city, 'placeholder' => $city, 'class' => 'form-control', 'id' => 'city', 'autocomplete' => 'off']); ?>
                                        <?php if(session('errors.city')): ?> 
                                                <p class="alert alert-danger" role="alert">  
                                                <?= session('errors.city') ?> 
                                                </p>
                                        <?php endif; ?>

                        <!-- Hidden input for timezone -->
                                       
                                        <ul id="suggestions" class="list-group"></ul>
                                        <div class="float-end"> 
                                                <label class="px-2" for="visibilitycity">Show in Public Profile</label>
                                                <input class="form-check-input" type="checkbox" value="1" 
                                                <?= isset(json_decode($visibility_settings)->city) && json_decode($visibility_settings)->city == "1" ? 'checked' : '' ?> 
                                                id="visibilitycity" name="visibilitycity">
                                        </div>
                                        <?= form_hidden('value', 'city'); ?>
                                        <?= form_input(['type'  => 'hidden','name'  => 'timezone_txt','id' => 'timezone_txt']); ?> 
                                      

                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                </div>
                                </div>



                        <div class="card-body">
                        <h4 class="card-title"><?= lang('App.country_of_birth') ?></h4>
                        <div class="row">
                                        <div class="col">
                                        <?= form_input(['name' => 'birthcountry', 'value' => $birthcountry, 'placeholder' => 'Country', 'class' => 'form-control', 'id' => 'birthCountry', 'readonly' => true]); ?>
                                      
                                            <!-- Hidden input for country -->
                                        <?= form_hidden('value', 'birthcountry'); ?>             
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                </div>
                        </div>
                                
          


                                   
                        <div class="card-body">
                        <h4 class="card-title"><?= lang('App.about_me') ?></h4>
                        <div class="row">
                                    <div class="col-12">
                                    <?= form_textarea(['name' => 'aboutme', 'class' => 'form-control', 'id' => 'aboutme', 'value' => $aboutMe ? $aboutMe : 'Tell a little bit about yourself']); ?>
                                    <?php if(session('errors.aboutme')): ?> <p class="alert alert-danger" role="alert"> <?= session('errors.aboutme') ?>  </p><?php endif; ?>
                                        <div class="float-end"> <label class="px-2" for="visibilityAbout"> Show in Public Profile</label>
                                    <input class="form-check-input" type="checkbox" value="1" <?= isset(json_decode($visibility_settings)->aboutMe) && json_decode($visibility_settings)->aboutMe == "1" ? 'checked' : '' ?> id="visibilityAbout" name="visibilityAbout">
                                    </div>
                        </div> 

                                  
                                    <?= form_hidden('value', 'aboutMe'); ?>
                                    
                                    <div class="col-md-2"> 
                                    </div> 
                                    </div>
                                </div>
                            
                          

                            <div class="card-body"><div class="float-end b" >         
                            <?= form_submit(['name' => 'btnsubmit','class'=>'btn btn-outline-primary','id' => 'btnsubmit'],  lang('App.button_update_prof') ); ?>

                            <?= csrf_field() ?>
                            <?= form_input(['type' => 'hidden', 'name' => 'userid', 'id' => 'alluserID', 'value' => $userId]); ?>
                            </div> </div>

                           
                            <input type="hidden" id="longitude" name="longitude" value="<?= esc($user["birthInfo"]["lon"]) ?>">
                            <input type="hidden" id="latitude" name="latitude" value="<?= esc($user["birthInfo"]["lat"]) ?>">
                            
                            <?php echo form_close(); ?> 

                        
                         
                </div>

         
             
        </div>

       
        
       

                
<script>

document.addEventListener('DOMContentLoaded', function () {
        const picker = new tempusDominus.TempusDominus(document.getElementById('timepicker'), {
            display: {
                components: {
                    calendar: false,   // Disable date picker, only time
                    hours: true,       // Show hours
                    minutes: true,     // Show minutes
                    seconds: false     // Hide seconds if not needed
                },
                theme: 'dark'         // Optional: Apply dark theme
            },
                localization: {
                locale: 'en',         // Set locale
                format: 'HH:mm'       // 24-hour format without seconds
            }
        });
    });


    $('#birthDate').on('change', function() {
    console.log('Selected Date:', $(this).val()); // Check format in console
});

$(document).ready(function() {
            $('#birthDate').datepicker({
                format: 'dd/mm/yyyy',
                changeYear: true,       // Enable year selection dropdown
                yearRange: '1900:2024', // Set the range of years (e.g., 1900 to 2024)
                beforeShow: function(input, inst) {
                inst.dpDiv.addClass("custom-datepicker"); // Add custom class if needed
                }
            });
        });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>   



<script src="<?= base_url('assets/js/geo.js') ?>"></script>





<?= $this->endSection() ?>