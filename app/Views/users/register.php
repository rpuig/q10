
<?= $this->extend('layouts/home') ?> 

<?= $this->section('content') ?>
<div class="container" style="height:100vh ">
    

<div class="row h-100 justify-content-center align-items-center">


	<div class="col-lg-6 col-md-12 py-3 ">
	

		
	<?= form_open('users/register', ['class' => 'card card-md']) ?>
    <div class="card-body">
        <h2 class="card-title text-center mb-4"><?= $title ?></h2>

        <div class="mb-3">
            <?= form_label('Username', 'username', ['class' => 'form-label']) ?>
            <?= form_input('username', set_value('username'), ['class' => 'form-control', 'placeholder' => 'Enter username']) ?>
            <?= isset($validation) ? '<div class="text-danger">' . $validation->getError('username') . '</div>' : '' ?>
           
    
        <div class="mb-3">
            <?= form_label('Email', 'email', ['class' => 'form-label']) ?>
            <?= form_input('email', set_value('email'), ['class' => 'form-control', 'placeholder' => 'r@r.com']) ?>
            <?= isset($validation) ? '<div class="text-danger">' . $validation->getError('email') . '</div>' : '' ?>
        </div>

        <div class="mb-3">
            <?= form_label('Password', 'password', ['class' => 'form-label']) ?>
            <?= form_password('password', '', ['class' => 'form-control', 'placeholder' => 'dddddd']) ?>
            <?= isset($validation) ? '<div class="text-danger">' . $validation->getError('password') . '</div>' : '' ?>
        </div>

        <div class="mb-3">
            <?= form_label('Confirm Password', 'password2', ['class' => 'form-label']) ?>
            <?= form_password('password2', '', ['class' => 'form-control', 'placeholder' => 'dddddd']) ?>
            <?= isset($validation) ? '<div class="text-danger">' . $validation->getError('password2') . '</div>' : '' ?>
        </div>
        <?= csrf_field() ?>
        </div>
        </div>
        <?= form_submit('submit', 'Register', ['class' => 'btn btn-primary w-100 py-3']) ?>
    </div>
<?= form_close() ?>


</div>

</div>


<?= $this->endSection() ?>				