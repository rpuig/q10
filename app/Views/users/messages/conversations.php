<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<title>My Conversations</title>

<div class="d-flex justify-content-center mt-5">
    <div class="container">
        <h2>My Conversations</h2>
        <div id="conversations-container" class="list-group">
            <!-- Conversations will be dynamically loaded here -->
        </div>
    </div>
</div>


<script src="<?= base_url('assets/js/conversations.js') ?>"></script>

<?= $this->endSection() ?>


