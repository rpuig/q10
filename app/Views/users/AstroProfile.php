<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="row h-100 justify-content-center align-items-center">
    <div class="col-sm-12 col-md-10 col-lg-10 p-3">
        <div class="card">
            <!-- Accordion Header -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Astro Profile</h3>
                <button id="toggleAccordion" class="btn btn-primary btn-sm">Expand All</button>
            </div>
            <div class="card-body">
                <div class="accordion" id="profileAccordion">
                 

                    <!-- ZD Profile Section -->
                    <div class="accordion-item ">
                        <h2 class="accordion-header" id="headingZd">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapseZd" aria-expanded="false" aria-controls="collapseZd">
                                Zd Profile
                            </button>
                        </h2>
                        <div id="collapseZd" class="accordion-collapse " aria-labelledby="headingZd" data-bs-parent="#profileAccordion">
                            <div class="accordion-body">
                                <?= $zdProfile ?>
                            </div>
                        </div>
                  
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapseHd" aria-expanded="false" aria-controls="collapseHd">
                                Hd Profile
                            </button>
                        </h2>
                        <div id="collapseHd" class="accordion-collapse " aria-labelledby="headingHd" data-bs-parent="#profileAccordion">
                            <div class="accordion-body">
                                <?= $hdProfile  ?>
                            </div>
                        </div>
                    </div>

            
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleAccordionBtn = document.getElementById('toggleAccordion');
        const accordionItems = document.querySelectorAll('#profileAccordion .accordion-collapse');

        let isExpanded = false; // Tracks whether accordion items are expanded or collapsed

        toggleAccordionBtn.addEventListener('click', () => {
            accordionItems.forEach(item => {
                if (isExpanded) {
                    item.classList.remove('show'); // Collapse all items
                } else {
                    item.classList.add('show'); // Expand all items
                }
            });

            // Toggle button text and state
            isExpanded = !isExpanded;
            toggleAccordionBtn.textContent = isExpanded ? 'Collapse All' : 'Expand All';
        });
    });
</script>

<?= $this->endSection() ?>
