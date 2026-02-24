<div class="text-center card-header">
	<h4><?= $project->get_title(); ?></h4>
	<input type="hidden" id="id_project" value="<?= $project->get_id(); ?>">
	<br>
	<a href="<?= base_url('open/' . $project->get_id()) ?>"
		class="btn form-inline opt <?= (isset($active_tab) && $active_tab === 'overview') ? 'btn-primary' : 'btn-outline-primary' ?>">Overview <i class="fas fa-binoculars"></i></a>
	<a href="<?= base_url('planning/' . $project->get_id()) ?>"
		class="btn form-inline opt <?= (isset($active_tab) && $active_tab === 'planning') ? 'btn-primary' : 'btn-outline-primary' ?>">Planning <i class="fas fa-list"></i></a>
	<?php if ($this->session->level == "4"): ?>
		 <a href="<?= base_url('study_selection_adm/' . $project->get_id()) ?>"
			 class="btn form-inline opt <?= (isset($active_tab) && $active_tab === 'conducting') ? 'btn-primary' : 'btn-outline-primary' ?>">Conducting <i class="fas fa-play-circle"></i></a>
	<?php else: ?>
		 <a href="<?= base_url('conducting/' . $project->get_id()) ?>"
			 class="btn form-inline opt <?= (isset($active_tab) && $active_tab === 'conducting') ? 'btn-primary' : 'btn-outline-primary' ?>">Conducting <i class="fas fa-play-circle"></i></a>
	<?php endif; ?>
	<a href="<?= base_url('reporting/' . $project->get_id()) ?>"
		class="btn form-inline opt <?= (isset($active_tab) && $active_tab === 'reporting') ? 'btn-primary' : 'btn-outline-primary' ?>">Reporting <i class="fas fa-chart-line"></i></a>
	<?php if ($project->get_planning() == 100): ?>
		<a href="<?= base_url('export/' . $project->get_id()) ?>"
		   class="btn form-inline btn-outline-primary opt">Export <i class="fas fa-file-download"></i></a>
	<?php endif; ?>
</div>
