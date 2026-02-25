<div class="container py-4">
	<div class="card">
		<?php $this->load->view('pages/project/partials/card_header', ['active_tab' => 'reporting']); ?>
		<?php $this->load->view('pages/project/reporting/partials/tab_nav'); ?>
		<div class="card-body">
			<div class="tab-content">
				<div class="tab-pane fade show active container-fluid" id="tab_overview" role="tabpanel" aria-labelledby="tab_overview-tab">
					<?php $this->load->view('pages/project/reporting/tabs/tab_overview'); ?>
				</div>
				<div class="tab-pane fade container-fluid" id="tab_import" role="tabpanel" aria-labelledby="tab_import-tab">
					<?php $this->load->view('pages/project/reporting/tabs/tab_import'); ?>
				</div>
				<div class="tab-pane fade container-fluid" id="tab_selection" role="tabpanel" aria-labelledby="tab_selection-tab">
					<?php $this->load->view('pages/project/reporting/tabs/tab_selection'); ?>
				</div>
				<div class="tab-pane fade container-fluid" id="tab_quality" role="tabpanel" aria-labelledby="tab_quality-tab">
					<?php $this->load->view('pages/project/reporting/tabs/tab_quality'); ?>
				</div>
				<div class="tab-pane fade container-fluid" id="tab_extraction" role="tabpanel" aria-labelledby="tab_extraction-tab">
					<?php $this->load->view('pages/project/reporting/tabs/tab_extraction'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
