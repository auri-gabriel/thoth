<div class="container py-4">
	<div class="card">
		<?php $this->load->view('pages/project/partials/card_header', ['active_tab' => 'reporting']); ?>
		<?php $this->load->view('pages/project/reporting/partials/tab_nav'); ?>
		<div class="card-body">
			<div class="tab-content">
				<div class="tab-pane container-fluid active" id="tab_overview">
					<?php $this->load->view('pages/project/reporting/tabs/tab_overview'); ?>
				</div>
				<div class="tab-pane container-fluid" id="tab_import">
					<?php $this->load->view('pages/project/reporting/tabs/tab_import'); ?>
				</div>
				<div class="tab-pane container-fluid" id="tab_selection">
					<?php $this->load->view('pages/project/reporting/tabs/tab_selection'); ?>
				</div>
				<div class="tab-pane container-fluid" id="tab_quality">
					<?php $this->load->view('pages/project/reporting/tabs/tab_quality'); ?>
				</div>
				<div class="tab-pane container-fluid" id="tab_extraction">
					<?php $this->load->view('pages/project/reporting/tabs/tab_extraction'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
