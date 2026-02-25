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
            ?>
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="tab_import" role="tabpanel">
                    <?php $this->load->view('pages/project/conducting/tabs/tab_import'); ?>
                </div>
                <div class="tab-pane fade" id="tab_selection" role="tabpanel">
                    <?php $this->load->view('pages/project/conducting/tabs/tab_selection'); ?>
                </div>
                <div class="tab-pane fade" id="tab_quality" role="tabpanel">
                    <?php $this->load->view('pages/project/conducting/tabs/tab_quality'); ?>
                </div>
                <div class="tab-pane fade" id="tab_extraction" role="tabpanel">
                    <?php $this->load->view('pages/project/conducting/tabs/tab_extraction'); ?>
                </div>
            </div>
            <?php
        } else {
            $this->load->view('pages/project/conducting/partials/alert_incomplete');
        }
        ?>
    </div>
</div>
