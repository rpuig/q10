<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<title>Conversation with <?= esc($otherUsername) ?></title>

</head>
<body>
    
<div id="chat" class="container md-5 lg-5 mt-4">
<h2>Conversation with <?= esc($otherUsername) ?></h2>
    <div id="message-container" class="mb-3"></div>
   

    <form id="message-form">

        <div class="input-group">
            <input type="text" id="message-input" class="form-control" required>
          

            <?=csrf_field()?> 
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    </form>
</div><script>

const currentUserId = <?= $currentUserId ?>;
const otherUserId = <?= $otherUserId ?>;
</script>
<script src="<?= base_url('assets/js/conversation.js') ?>"></script>



<?= $this->endSection() ?>
