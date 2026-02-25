<nav class="reporting-tabs-nav mb-4 shadow-sm rounded bg-white p-2" aria-label="Reporting tabs">
    <ul class="nav nav-pills nav-fill flex-nowrap overflow-auto" role="tablist" style="white-space:nowrap;">
        <li class="nav-item" style="min-width:140px;">
            <a data-bs-toggle="tab" class="nav-link active d-flex flex-column align-items-center justify-content-center py-2 px-3 fw-bold" id="tab_overview-tab" href="#tab_overview" role="tab" aria-controls="tab_overview" aria-selected="true" aria-label="Overview">
                <i class="fas fa-info-circle mb-1 fa-lg"></i>
                <span class="tab-label">Overview</span>
            </a>
        </li>
        <li class="nav-item" style="min-width:140px;">
            <a data-bs-toggle="tab" class="nav-link d-flex flex-column align-items-center justify-content-center py-2 px-3 fw-bold" id="tab_import-tab" href="#tab_import" role="tab" aria-controls="tab_import" aria-selected="false" aria-label="Import Studies">
                <i class="fas fa-upload mb-1 fa-lg"></i>
                <span class="tab-label">Import Studies</span>
            </a>
        </li>
        <li class="nav-item" style="min-width:140px;">
            <a data-bs-toggle="tab" class="nav-link d-flex flex-column align-items-center justify-content-center py-2 px-3 fw-bold" id="tab_selection-tab" href="#tab_selection" role="tab" aria-controls="tab_selection" aria-selected="false" aria-label="Study Selection">
                <i class="fas fa-clipboard-check mb-1 fa-lg"></i>
                <span class="tab-label">Study Selection</span>
            </a>
        </li>
        <li class="nav-item" style="min-width:140px;">
            <a data-bs-toggle="tab" class="nav-link d-flex flex-column align-items-center justify-content-center py-2 px-3 fw-bold" id="tab_quality-tab" href="#tab_quality" role="tab" aria-controls="tab_quality" aria-selected="false" aria-label="Quality Assessment">
                <i class="far fa-star mb-1 fa-lg"></i>
                <span class="tab-label">Quality Assessment</span>
            </a>
        </li>
        <?php if ($project->get_extraction() > 0): ?>
        <li class="nav-item" style="min-width:140px;">
            <a data-bs-toggle="tab" class="nav-link d-flex flex-column align-items-center justify-content-center py-2 px-3 fw-bold" id="tab_extraction-tab" href="#tab_extraction" role="tab" aria-controls="tab_extraction" aria-selected="false" aria-label="Data Extraction">
                <i class="fas fa-table mb-1 fa-lg"></i>
                <span class="tab-label">Data Extraction</span>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</nav>
