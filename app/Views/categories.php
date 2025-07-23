<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <?php foreach ($categories as $category) : ?>
            <div class="col-md-4 col-lg-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <a href="<?= base_url('categories/' . $category['slug'] . '/posts') ?>" class="stretched-link text-decoration-none">
                            <h5 class="card-title text-capitalize"><?= esc($category['name']) ?></h5>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?= $this->endSection() ?>
