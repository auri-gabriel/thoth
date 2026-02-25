<ul class="nav nav-pills nav-justified flex-column flex-sm-row">
    <?php if ($this->session->level != "4") { ?>
        <li class="nav-item">
            <a class="nav-link active flex-sm-fill text-sm-center"
               href="<?= base_url('conducting/' . $project->get_id()) ?>">Import Studies <i class="fas fa-upload"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link flex-sm-fill text-sm-center" href="<?= base_url('study_selection/' . $project->get_id()) ?>">Study
                Selection <i class="fas fa-clipboard-check"></i></a>
        </li>
    <?php } ?>
    <?php if ($this->session->level == "4") { ?>
        <li class="nav-item">
            <a class="nav-link flex-sm-fill text-sm-center" href="<?= base_url('study_selection_adm/' . $project->get_id()) ?>">Review
                Study Selection <i class="fas fa-book-reader"></i></a>
        </li>
    <?php } ?>
    <?php if ($this->session->level != "4") { ?>
        <li class="nav-item">
            <a class="nav-link flex-sm-fill text-sm-center"
               href="<?= base_url('quality_assessment/' . $project->get_id()) ?>">Quality
                Assessment <i class="fas fa-star-half-alt"></i></a>
        </li>
    <?php } ?>
    <?php if ($this->session->level == "4") { ?>
        <li class="nav-item">
            <a class="nav-link flex-sm-fill text-sm-center" href="<?= base_url('quality_adm/' . $project->get_id()) ?>">Review
                Quality Assessment <i class="fas fa-book-reader"></i></a>
        </li>
    <?php } ?>
    <?php if ($this->session->level != "4") { ?>
        <li class="nav-item">
            <a class=" nav-link flex-sm-fill text-sm-center" href="<?= base_url('data_extraction/' . $project->get_id()) ?>">Data
                Extraction <i class="fas fa-table"></i></a>
        </li>
    <?php } ?>
</ul>
