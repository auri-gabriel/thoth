<div class="container">
	<div class="card mb-4">
		<?php $this->load->view('pages/project/partials/card_header', ['active_tab' => 'export']); ?>
		<div class="card-body">
			<h4 class="mb-4">Export</h4>
			<nav>
				<ul class="nav nav-tabs mb-4" id="exportTab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="latex-tab" data-bs-toggle="tab" data-bs-target="#latex" type="button" role="tab" aria-controls="latex" aria-selected="true">
							<i class="fab fa-markdown"></i> LaTeX
						</button>
					</li>
					<?php if ($project->get_import() == 100) { ?>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="bibtex-tab" data-bs-toggle="tab" data-bs-target="#bibtex" type="button" role="tab" aria-controls="bibtex" aria-selected="false">
								<i class="fas fa-book"></i> BibTeX
							</button>
						</li>
					<?php } ?>
				</ul>
			</nav>
			<!-- Hidden input for project ID (required by export.js) -->
			<input type="hidden" id="id_project" value="<?php echo isset($project) ? $project->get_id() : ''; ?>">
			<div class="tab-content" id="exportTabContent">
				<div class="tab-pane fade show active" id="latex" role="tabpanel" aria-labelledby="latex-tab">
					<div class="mb-3">
						<div class="d-flex flex-wrap gap-3 justify-content-center">
							<?php if ($project->get_planning() == 100) { ?>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="check_planning" value="Planning" name="step">
									<label class="form-check-label" for="check_planning">Planning</label>
								</div>
							<?php } ?>
							<?php if ($project->get_import() == 100) { ?>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="check_import" value="Import" name="step">
									<label class="form-check-label" for="check_import">Import Studies</label>
								</div>
							<?php } ?>
							<?php if ($project->get_selection() > 0) { ?>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="check_selection" value="Selection" name="step">
									<label class="form-check-label" for="check_selection">Study Selection</label>
								</div>
							<?php } ?>
							<?php if ($project->get_quality() > 0) { ?>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="check_quality" value="Quality" name="step">
									<label class="form-check-label" for="check_quality">Quality Assessment</label>
								</div>
							<?php } ?>
						</div>
					</div>
					<form action="https://www.overleaf.com/docs" method="post" target="_blank">
						<textarea rows="16" class="form-control mb-3" name="snip" id="latex"></textarea>
						<button type="submit" class="btn btn-success opt"><i class="far fa-plus-square"></i> New Project in Overleaf</button>
					</form>
				</div>
				<?php if ($project->get_import() == 100) { ?>
					<div class="tab-pane fade" id="bibtex" role="tabpanel" aria-labelledby="bibtex-tab">
						<div class="mb-3">
							<div class="d-flex flex-wrap gap-3 justify-content-center">
								<?php if ($project->get_import() == 100) { ?>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="inlineRadioOptions" id="check_import_bib" value="Import">
										<label class="form-check-label" for="check_import_bib">Import</label>
									</div>
								<?php } ?>
								<?php if ($project->get_selection() > 0) { ?>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="inlineRadioOptions" id="check_selection_bib" value="Selection">
										<label class="form-check-label" for="check_selection_bib">Selection</label>
									</div>
								<?php } ?>
								<?php if ($project->get_quality() > 0) { ?>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="inlineRadioOptions" id="check_quality_bib" value="Quality">
										<label class="form-check-label" for="check_quality_bib">Quality</label>
									</div>
								<?php } ?>
								<?php if ($project->get_extraction() > 0) { ?>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="inlineRadioOptions" id="check_extraction_bib" value="Extraction">
										<label class="form-check-label" for="check_extraction_bib">Extraction</label>
									</div>
								<?php } ?>
							</div>
						</div>
						<textarea rows="16" class="form-control mb-3" id="bib_tex"></textarea>
						<a class="btn btn-success opt" id="export_bib" href="" download="Bib.bib" onclick="export_bib();"><i class="fas fa-download"></i> Download BibTeX</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>