<div class="card-header d-flex flex-column flex-md-row align-items-center justify-content-between py-3 bg-light border-bottom shadow-sm">
	<div class="d-flex flex-column align-items-center align-items-md-start w-80 mb-2 mb-md-0">
		<h4 class="mb-1 fw-bold text-primary" aria-label="Project Title"><?= htmlspecialchars($project->get_title()); ?></h4>
		<input type="hidden" id="id_project" value="<?= $project->get_id(); ?>">
	</div>
	<nav class="d-flex flex-row flex-wrap align-items-center gap-0" aria-label="Project stages navigation">
		<!-- Overview -->
		<a href="<?= base_url('open/' . $project->get_id()) ?>"
		   class="btn btn-sm opt rounded-0 rounded-start <?= (isset($active_tab) && $active_tab === 'overview') ? 'btn-primary' : 'btn-outline-primary' ?>"
		   aria-current="<?= (isset($active_tab) && $active_tab === 'overview') ? 'page' : false ?>"
		   style="min-width:110px">
			<i class="fas fa-binoculars me-1"></i> Overview
		</a>
		<span class="stage-arrow d-none d-md-inline" aria-hidden="true" style="font-size:1.2em;margin:0 0.25rem;">&#8594;</span>
		<!-- Planning -->
		<a href="<?= base_url('planning/' . $project->get_id()) ?>"
		   class="btn btn-sm opt rounded-0 <?= (isset($active_tab) && $active_tab === 'planning') ? 'btn-primary' : 'btn-outline-primary' ?>"
		   aria-current="<?= (isset($active_tab) && $active_tab === 'planning') ? 'page' : false ?>"
		   style="min-width:110px">
			<i class="fas fa-list me-1"></i> Planning
		</a>
		<span class="stage-arrow d-none d-md-inline" aria-hidden="true" style="font-size:1.2em;margin:0 0.25rem;">&#8594;</span>
		<!-- Conducting -->
		<?php if ($this->session->level == "4"): ?>
			<a href="<?= base_url('study_selection_adm/' . $project->get_id()) ?>"
			   class="btn btn-sm opt rounded-0 <?= (isset($active_tab) && $active_tab === 'conducting') ? 'btn-primary' : 'btn-outline-primary' ?>"
			   aria-current="<?= (isset($active_tab) && $active_tab === 'conducting') ? 'page' : false ?>"
			   style="min-width:110px">
				<i class="fas fa-play-circle me-1"></i> Conducting
			</a>
		<?php else: ?>
			<a href="<?= base_url('conducting/' . $project->get_id()) ?>"
			   class="btn btn-sm opt rounded-0 <?= (isset($active_tab) && $active_tab === 'conducting') ? 'btn-primary' : 'btn-outline-primary' ?>"
			   aria-current="<?= (isset($active_tab) && $active_tab === 'conducting') ? 'page' : false ?>"
			   style="min-width:110px">
				<i class="fas fa-play-circle me-1"></i> Conducting
			</a>
		<?php endif; ?>
		<span class="stage-arrow d-none d-md-inline" aria-hidden="true" style="font-size:1.2em;margin:0 0.25rem;">&#8594;</span>
		<!-- Reporting -->
		<a href="<?= base_url('reporting/' . $project->get_id()) ?>"
		   class="btn btn-sm opt rounded-0 rounded-end <?= (isset($active_tab) && $active_tab === 'reporting') ? 'btn-primary' : 'btn-outline-primary' ?>"
		   aria-current="<?= (isset($active_tab) && $active_tab === 'reporting') ? 'page' : false ?>"
		   style="min-width:110px">
			<i class="fas fa-chart-line me-1"></i> Reporting
		</a>
		<?php if ($project->get_planning() == 100): ?>
			<span class="d-none d-md-inline" style="margin:0 0.25rem;">&nbsp;</span>
			<a href="<?= base_url('export/' . $project->get_id()) ?>"
			   class="btn btn-sm btn-outline-primary opt ms-2 rounded-pill"
			   style="min-width:90px">
				<i class="fas fa-file-download me-1"></i> Export
			</a>
		<?php endif; ?>
	</nav>
</div>
