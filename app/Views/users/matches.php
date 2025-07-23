<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <?php foreach ($matches as $match): ?>
            <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                <div class="card matchCard h-100 shadow-sm" data-url="publicProfile?userID=<?= $match['userMatch_userId'] ?>" style="background-image: url('<?= $match['UserMatch_ProfPicture']; ?>'); background-size: cover; background-position: center;">
                    <div class="card-body d-flex flex-column justify-content-end text-white" style="background: rgba(0, 0, 0, 0.5);">
                        <div class="d-flex align-items-center mb-3">
                            <img src="<?= $match['UserMatch_ProfPicture']; ?>" alt="<?= $match['UserMatch_Username']; ?>" width="50" height="50" class="rounded-circle border border-white me-3">
                            <div>
                                <h5 class="card-title mb-0"><?= $match['UserMatch_Username']; ?></h5>
                                <small class="badge bg-secondary"><?= $match["UserMatch_Age"] ?> years old</small>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="badge bg-primary"><?= $match['MatchScore']; ?>% Match</span>
                            <a href="publicProfile?userID=<?= $match['userMatch_userId'] ?>" class="btn btn-outline-light btn-sm">View Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.querySelectorAll(".matchCard").forEach(function(div) {
    div.addEventListener("click", function() {
        var url = div.getAttribute("data-url");
        if (url) {
            window.location.href = url;
        }
    });
});
</script>

<style>
.matchCard {
    border: none;
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
}
.matchCard:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}
.card-body {
    backdrop-filter: blur(5px);
}
</style>

<?= $this->endSection() ?>
