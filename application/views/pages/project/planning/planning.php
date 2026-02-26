<div class="container py-4">
	<div class="card">
		<?php $this->load->view('pages/project/partials/card_header', ['active_tab' => 'planning', 'is_owner' => true]); ?>
		<div class="card-body bg-light">
			<h4>Planning</h4>
			<?php $this->load->view('pages/project/planning/partials/tab_nav'); ?>
		</div>
		<div class="tab-content p-3">
			<?php $this->load->view('pages/project/planning/tabs/tab_overall'); ?>
			<?php $this->load->view('pages/project/planning/tabs/tab_research'); ?>
			<?php $this->load->view('pages/project/planning/tabs/tab_databases'); ?>
			<?php $this->load->view('pages/project/planning/tabs/tab_search_string'); ?>
			<?php $this->load->view('pages/project/planning/tabs/tab_search_strategy'); ?>
			<?php $this->load->view('pages/project/planning/tabs/tab_criteria'); ?>
			<?php $this->load->view('pages/project/planning/tabs/tab_quality'); ?>
			<?php $this->load->view('pages/project/planning/tabs/tab_data_extraction'); ?>
		</div>
		<br>
	</div>
</div>

<?php
// Criteria modals
$this->load->view('modal/modal_inclusion_criteria');
$this->load->view('modal/modal_exclusion_criteria');

// Search string modals
$this->load->view('modal/modal_synonym');
$this->load->view('modal/modal_term');

// Quality modals
$this->load->view('modal/modal_general_score');
$this->load->view('modal/modal_question_quality');
$this->load->view('modal/modal_score_quality');

// Data extraction modals
$this->load->view('modal/modal_question_extraction');
$this->load->view('modal/modal_option');

// Overall modals
$this->load->view('modal/modal_research');
$this->load->view('modal/modal_keyword');
$this->load->view('modal/modal_domain');

// Help modals
$this->load->view('modal/help/modal_help_domain');
$this->load->view('modal/help/modal_help_languages');
$this->load->view('modal/help/modal_help_study_type');
$this->load->view('modal/help/modal_help_keyword');
$this->load->view('modal/help/modal_help_date');
$this->load->view('modal/help/modal_help_research_question');
$this->load->view('modal/help/modal_help_database');
$this->load->view('modal/help/modal_help_ss');
$this->load->view('modal/help/modal_help_strings');
$this->load->view('modal/help/modal_help_criteria');
$this->load->view('modal/help/modal_help_general_score');
$this->load->view('modal/help/modal_help_qa');
$this->load->view('modal/help/modal_help_data_extraction');
$this->load->view('modal/help/modal_help_strategy');
?>