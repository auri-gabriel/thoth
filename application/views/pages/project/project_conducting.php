
<script src="<?= base_url('assets/js/bibupload.js'); ?>"></script>
<div class="card">
    <?php $this->load->view('pages/project/partials/card_header', ['active_tab' => 'conducting']); ?>
    <div class="card-body">
        <h4>Conducting</h4>
        <?php
        if ($project->get_planning() == 100) {
            // Tab navigation partial
            $this->load->view('pages/project/conducting/partials/tab_nav');

            // Tab content
            $this->load->view('pages/project/conducting/tabs/tab_import');
            $this->load->view('pages/project/conducting/tabs/tab_selection');
            $this->load->view('pages/project/conducting/tabs/tab_quality');
            $this->load->view('pages/project/conducting/tabs/tab_extraction');
        } else {
            $this->load->view('pages/project/conducting/partials/alert_incomplete');
        }
        ?>
    </div>
</div>
