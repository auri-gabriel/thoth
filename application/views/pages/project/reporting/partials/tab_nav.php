<nav class="reporting-tabs-nav mb-4 shadow-sm rounded bg-white p-2" aria-label="Reporting tabs">
    <ul class="nav nav-pills nav-fill flex-nowrap overflow-auto" role="tablist" style="white-space:nowrap;">
        <li class="nav-item" style="min-width:140px;">
            <a data-toggle="pill" class="nav-link active d-flex flex-column align-items-center justify-content-center py-2 px-3 fw-bold" href="#tab_over" aria-label="Overview">
                <i class="fas fa-info-circle mb-1 fa-lg"></i>
                <span class="tab-label">Overview</span>
            </a>
        </li>
        <li class="nav-item" style="min-width:140px;">
            <a data-toggle="pill" class="nav-link d-flex flex-column align-items-center justify-content-center py-2 px-3 fw-bold" href="#tab_import" aria-label="Import Studies">
                <i class="fas fa-upload mb-1 fa-lg"></i>
                <span class="tab-label">Import Studies</span>
            </a>
        </li>
        <li class="nav-item" style="min-width:140px;">
            <a data-toggle="pill" class="nav-link d-flex flex-column align-items-center justify-content-center py-2 px-3 fw-bold" href="#tab_selection" aria-label="Study Selection">
                <i class="fas fa-clipboard-check mb-1 fa-lg"></i>
                <span class="tab-label">Study Selection</span>
            </a>
        </li>
        <li class="nav-item" style="min-width:140px;">
            <a data-toggle="pill" class="nav-link d-flex flex-column align-items-center justify-content-center py-2 px-3 fw-bold" href="#tab_qa" aria-label="Quality Assessment">
                <i class="far fa-star mb-1 fa-lg"></i>
                <span class="tab-label">Quality Assessment</span>
            </a>
        </li>
        <?php if ($project->get_extraction() > 0): ?>
        <li class="nav-item" style="min-width:140px;">
            <a data-toggle="pill" class="nav-link d-flex flex-column align-items-center justify-content-center py-2 px-3 fw-bold" href="#tab_ex" aria-label="Data Extraction">
                <i class="fas fa-table mb-1 fa-lg"></i>
                <span class="tab-label">Data Extraction</span>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</nav>
