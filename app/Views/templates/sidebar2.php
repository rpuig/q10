<div class="col-sm-auto bg-light sticky-top">
            <div class="d-flex flex-sm-column flex-row flex-nowrap bg-light align-items-center sticky-top">
                
            
                <ul class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto mx-auto text-center justify-content-between w-100 px-3 align-items-center">
                    <li class="nav-item">
                        <a href=<?= base_url()."home" ?> class="d-flex align-items-bottom justify-content-center p-1 link-dark text-decoration-none " title="Home" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Home">
                            <i class="bi-house fs-1"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#"  class="d-flex align-items-bottom justify-content-center p-1 link-dark text-decoration-none " title="Statistics" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Dashboard">
                            <i class="bi-speedometer2 fs-1"></i>
                        </a>
                    </li>
                    
                    <li>
                        <a href=<?= base_url()."matches" ?>  class="d-flex align-items-bottom justify-content-center p-1 link-dark text-decoration-none " title="Matches" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Products">
                            <i class="bi-heart fs-1"></i>
                        </a>
                    </li>

                    <li>
                        <a href="#"  class="d-flex align-items-bottom justify-content-center p-1 link-dark text-decoration-none " title="Charts" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Products">
                            <i class="bi-table fs-1"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#"  class="d-flex align-items-bottom justify-content-center p-1 link-dark text-decoration-none " title="Friends" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Customers">
                            <i class="bi-people fs-1"></i>
                        </a>
                    </li>
                </ul>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center justify-content-center p-1 link-dark text-decoration-none dropdown-toggle" id="dropdownUser3" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi-person-circle h2"></i>
                    </a>
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser3">
                      
                        <li><a class="dropdown-item"  href=<?= base_url()."settings" ?>>Settings</a></li>
                        <li><a class="dropdown-item" href=<?= base_url()."profile" ?>>Profile</a></li>
                    </ul>
                </div>
            </div>
        </div>