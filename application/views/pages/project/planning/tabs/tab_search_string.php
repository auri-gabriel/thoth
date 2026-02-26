<?php $readonly = (isset($readonly) && $readonly === true); ?>
<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_search_string">
	<div class="row justify-content-center">

		<div class="card shadow-sm">
			<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3">
				<strong>Search String</strong>
				<a onclick="modal_help('modal_help_ss')" class="ms-auto text-secondary opt" tabindex="0" aria-label="Help about search string" data-bs-toggle="tooltip" title="What is a search string?"><i class="fas fa-question-circle"></i></a>
			</div>
			<div class="card-body">

				<?php if (!$readonly): ?>
					<!-- Terms -->
					<label class="form-label fw-semibold mb-2">Term</label>
					<div class="row g-3 mb-4">
						<div class="col-md-4">
							<div class="input-group">
								<input type="text" class="form-control" id="term" placeholder="Add new term" aria-label="Term">
								<button class="btn btn-success" type="button" onclick="add_term();" data-bs-toggle="tooltip" title="Add term">
									<i class="fas fa-plus"></i>
								</button>
							</div>
						</div>
					</div>

					<!-- Synonyms -->
					<label class="form-label fw-semibold mb-2">Synonym</label>
					<div class="row g-3 mb-2">
						<div class="col-md-4">
							<label for="list_term" class="form-label text-muted small">Select Term</label>
							<select class="form-select" id="list_term" onchange="related_terms(this.value);" aria-label="Select term">
								<option value="" disabled selected>Select term</option>
								<?php foreach ($project->get_terms() as $term): ?>
									<option value="<?= $term->get_description() ?>"><?= $term->get_description() ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-6">
							<label for="synonym" class="form-label text-muted small">Synonym</label>
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Add synonym" id="synonym" aria-label="Synonym">
								<button class="btn btn-success" type="button" onclick="add_synonym();" data-bs-toggle="tooltip" title="Add synonym">
									<i class="fas fa-plus"></i>
								</button>
							</div>
						</div>
					</div>

					<div id="related-terms" class="mb-3"></div>
				<?php endif; ?>

				<div class="table-responsive mt-4">
					<table id="table_search_string" class="table table-bordered table-hover align-middle mb-0">
						<caption class="visually-hidden">List of Terms</caption>
						<thead class="table-light">
							<tr>
								<th scope="col" style="width:20%">Term</th>
								<th scope="col">Synonyms</th>
								<?php if (!$readonly): ?><th scope="col" class="text-end">Actions</th><?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($project->get_terms() as $term): ?>
								<tr>
									<td class="fw-semibold"><?= $term->get_description() ?></td>
									<td>
										<table id="table_<?= $term->get_description() ?>" class="table table-bordered table-sm mb-0">
											<thead class="table-light">
												<tr>
													<th>Synonym</th>
													<?php if (!$readonly): ?><th class="text-end">Actions</th><?php endif; ?>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($term->get_synonyms() as $synonym): ?>
													<tr>
														<td><?= $synonym ?></td>
														<?php if (!$readonly): ?>
															<td class="text-end">
																<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_synonym(this)"><i class="fas fa-edit"></i></button>
																<button class="btn btn-outline-danger btn-sm" onClick="delete_synonym(this)"><i class="far fa-trash-alt"></i></button>
															</td>
														<?php endif; ?>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</td>
									<?php if (!$readonly): ?>
										<td class="text-end">
											<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_term($(this).parents('tr'))"><i class="fas fa-edit"></i></button>
											<button class="btn btn-outline-danger btn-sm" onClick="delete_term($(this).parents('tr'));"><i class="far fa-trash-alt"></i></button>
										</td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

				<!-- Strings per database -->
				<div id="strings" class="mt-4">
					<div class="d-flex align-items-center mb-3">
						<label class="mb-0 fw-semibold">Generated Strings</label>
						<a onclick="modal_help('modal_help_strings')" class="ms-auto text-secondary opt" tabindex="0" aria-label="Help about strings" data-bs-toggle="tooltip" title="What are strings?"><i class="fas fa-question-circle"></i></a>
					</div>
					<?php foreach ($project->get_search_strings() as $search_string): ?>
						<div class="mb-4 p-3 border rounded bg-white" id="div_string_<?= $search_string->get_database()->get_name() ?>">
							<a target="_blank" href="<?= $search_string->get_database()->get_link() ?>" class="fw-semibold d-inline-block mb-2">
								<i class="fas fa-external-link-alt me-1 small"></i><?= $search_string->get_database()->get_name() ?>
							</a>
							<textarea class="form-control mb-2" id="string_<?= $search_string->get_database()->get_name() ?>" rows="4" aria-label="String for <?= $search_string->get_database()->get_name() ?>" <?= $readonly ? 'readonly' : '' ?>><?= $search_string->get_description() ?></textarea>
							<?php if (!$readonly): ?>
								<button type="button" class="btn btn-primary btn-sm opt" onclick="generate_string('<?= $search_string->get_database()->get_name() ?>');" data-bs-toggle="tooltip" title="Generate string">
									<i class="fas fa-magic me-1"></i> Generate
								</button>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>

			</div>
		</div>

	</div>
	<div class="d-flex justify-content-between align-items-center mt-4 mb-5">
		<a href="#tab_databases" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><i class="fas fa-backward me-1"></i> Previous</a>
		<a href="#tab_search_strategy" class="btn btn-primary opt" data-bs-toggle="tooltip" title="Go to next step">Next <i class="fas fa-forward ms-1"></i></a>
	</div>
</div>
<script src="<?= base_url('assets/js/search_string.js'); ?>"></script>