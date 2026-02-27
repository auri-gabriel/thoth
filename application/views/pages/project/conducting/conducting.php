<div class="container py-4" id="conducting-tabs" data-project-id="<?= htmlspecialchars($project->get_id(), ENT_QUOTES, 'UTF-8'); ?>">
	<div class="card">
		<?php $this->load->view('pages/project/partials/card_header', ['active_tab' => 'conducting', 'is_owner' => true]); ?>
		<div class="card-body bg-light">
			<h4>Conducting</h4>
			<?php $this->load->view('pages/project/conducting/partials/tab_nav'); ?>

			<div class="tab-content p-3">
				<?php if ($project->get_planning() == 100) { ?>
					<div class="tab-pane fade show active" id="tab_import" role="tabpanel">
						<?php $this->load->view('pages/project/conducting/tabs/tab_import_studies'); ?>
					</div>
					<div class="tab-pane fade" id="tab_selection" role="tabpanel">
						<?php $this->load->view('pages/project/conducting/tabs/tab_study_selection'); ?>
					</div>
					<div class="tab-pane fade" id="tab_quality" role="tabpanel">
						<?php $this->load->view('pages/project/conducting/tabs/tab_quality_assessment'); ?>
					</div>
					<div class="tab-pane fade" id="tab_extraction" role="tabpanel">
						<?php $this->load->view('pages/project/conducting/tabs/tab_data_extraction'); ?>
					</div>
				<?php } else { ?>
					<?php $this->load->view('pages/project/conducting/partials/alert_incomplete'); ?>
				<?php } ?>
			</div>
		</div>
		<br>
	</div>
</div>
<script src="<?= base_url('assets/js/bibupload.js'); ?>"></script>
<script src="<?= base_url('assets/js/conducting_tabs.js'); ?>"></script>

<?php
// Conducting modals
// $this->load->view('modal/modal_paper_selection');
// $this->load->view('modal/modal_paper_qa');
// $this->load->view('modal/modal_paper_extraction');
?>