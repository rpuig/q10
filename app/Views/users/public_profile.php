<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="modal fade" id="profilePciModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profilePciModal"><?= $username ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="<?= $profilepicture ?>" class="img-fluid rounded-circle" alt="Full size image">
            </div>
        </div>
    </div>
</div>

<div class="container py-5 public-card">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="row g-0">
                    <!-- Profile Picture as Background -->
                    <div class="col-md-4">
                        <button type="button" class="btn p-0 w-100 h-100" data-bs-toggle="modal" data-bs-target="#profilePciModal">
                            <div 
                                class="profile-picture" 
                                style="background-image: url('<?= $profilepicture ?>');">
                            </div>
                        </button>
                    </div>
                    
                    <div class="col-md-8 d-flex flex-column">
                        <div class="d-flex flex-column justify-content-between">
                            <h2 class="card-title"><?= $username ?></h2>
                            <div class="mt-auto">
                                <?php
                                $profile_variables = [
                                    'username' => $username,
                                    'name' => $name,
                                    'surname' => $surname,
                                    'sex' => $sex,
                                    'bdate' => $birthdate,
                                    'birthTime' => $birthtime,
                                    'city' => $city,
                                    'birthcountry'=>$birthcountry,
                                    'profession' => $profession,
                                    'aboutMe' => $aboutme,
                                    'lookingFor' => $lookingfor,
                                ];

                                $visibilitySettings = json_decode($visibility, true);
                                if ($visibilitySettings !== null) {
                                    foreach ($profile_variables as $key => $label) {
                                        if (isset($visibilitySettings[$key]) && $visibilitySettings[$key] == 1) {
                                            echo "<p class='card-text'><span class='fw-bold'>$key:</span> " . $label . "</p>";
                                        }
                                    }
                                } else {
                                    echo "<p class='card-text text-danger'>Error decoding JSON</p>";
                                }
                                ?>
                            </div>

                            <div class="container mt-5">
                                
                                <?php if ($message_btn): ?>
                                    <?php echo form_open_multipart('messages/conversation/'.$userid, 'id="messageUser"') ?>
                                    <div class="input-group">
                                        <button type="submit" class="btn btn-primary">Message</button>
                                    </div>
                                    <?php echo form_close(); ?> 
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
