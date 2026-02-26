<div class="project-card-header">
	<div>
		<h4 class="project-title" aria-label="Project Title"><?= htmlspecialchars($project->get_title()); ?></h4>
		<input type="hidden" id="id_project" value="<?= $project->get_id(); ?>">
	</div>
	<nav class="project-stages-nav" aria-label="Project stages navigation">
		<!-- Overview -->
		<a href="<?= site_url('projects/' . $project->get_id()) ?>"
			class="btn btn-sm opt <?= (isset($active_tab) && $active_tab === 'overview') ? 'btn-primary' : 'btn-outline-primary' ?>"
			aria-current="<?= (isset($active_tab) && $active_tab === 'overview') ? 'page' : false ?>">
			<i class="fas fa-binoculars me-1"></i> Overview
		</a>
		<span class="stage-arrow d-none d-md-inline" aria-hidden="true">&#8594;</span>
		<!-- Planning -->
		<a href="<?= site_url('projects/' . $project->get_id() . '/planning') ?>"
			class="btn btn-sm opt <?= (isset($active_tab) && $active_tab === 'planning') ? 'btn-primary' : 'btn-outline-primary' ?>"
			aria-current="<?= (isset($active_tab) && $active_tab === 'planning') ? 'page' : false ?>">
			<i class="fas fa-list me-1"></i> Planning
		</a>
		<span class="stage-arrow d-none d-md-inline" aria-hidden="true">&#8594;</span>
		<!-- Conducting -->
		<?php if ($this->session->level == "4"): ?>
			<a href="<?= site_url('projects/' . $project->get_id() . '/study-selection-admin') ?>"
				class="btn btn-sm opt <?= (isset($active_tab) && $active_tab === 'conducting') ? 'btn-primary' : 'btn-outline-primary' ?>"
				aria-current="<?= (isset($active_tab) && $active_tab === 'conducting') ? 'page' : false ?>">
				<i class="fas fa-play-circle me-1"></i> Conducting
			</a>
		<?php else: ?>
			<a href="<?= site_url('projects/' . $project->get_id() . '/conducting') ?>"
				class="btn btn-sm opt <?= (isset($active_tab) && $active_tab === 'conducting') ? 'btn-primary' : 'btn-outline-primary' ?>"
				aria-current="<?= (isset($active_tab) && $active_tab === 'conducting') ? 'page' : false ?>">
				<i class="fas fa-play-circle me-1"></i> Conducting
			</a>
		<?php endif; ?>
		<span class="stage-arrow d-none d-md-inline" aria-hidden="true">&#8594;</span>
		<!-- Reporting -->
		<a href="<?= site_url('projects/' . $project->get_id() . '/reporting') ?>"
			class="btn btn-sm opt <?= (isset($active_tab) && $active_tab === 'reporting') ? 'btn-primary' : 'btn-outline-primary' ?>"
			aria-current="<?= (isset($active_tab) && $active_tab === 'reporting') ? 'page' : false ?>">
			<i class="fas fa-chart-line me-1"></i> Reporting
		</a>
		<?php if ($project->get_planning() == 100): ?>
			<span class="d-none d-md-inline">&nbsp;</span>
			<a href="<?= site_url('projects/' . $project->get_id() . '/export') ?>"
				class="btn btn-sm opt btn-export <?= (isset($active_tab) && $active_tab === 'export') ? 'btn-primary' : 'btn-outline-primary' ?>"
				aria-current="<?= (isset($active_tab) && $active_tab === 'export') ? 'page' : false ?>">
				<i class="fas fa-file-download me-1"></i> Export
			</a>
		<?php endif; ?>
	</nav>
</div>