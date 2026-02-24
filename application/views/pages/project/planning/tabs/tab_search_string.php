<div class="tab-pane container-fluid" role="tabpanel" id="tab_search_string">
	<div class="form-inline">
		<label for="term"><strong>Search String</strong></label>
		<a onclick="modal_help('modal_help_ss')" class="float-right opt">
			<i class="fas fa-question-circle"></i>
		</a>
	</div>

	<!-- Add Term -->
	<div class="form-inline">
		<div class="input-group col-md-4">
			<label for="term" class="col-sm-12">Term</label>
			<input type="text" class="form-control" id="term">
			<div class="input-group-append">
				<button class="btn btn-success" type="button" onclick="add_term();">
					<span class="fas fa-plus"></span>
				</button>
			</div>
		</div>
	</div>
	<br>

	<!-- Add Synonym -->
	<div class="form-inline">
		<label for="list_term"><strong>Synonym</strong></label>
	</div>
	<div class="form-inline">
		<div class="input-group col-md-4">
			<label for="list_term" class="col-sm-12">Term</label>
			<select class="form-control" id="list_term" onchange="related_terms(this.value);">
				<option value="" disabled selected>Select term</option>
				<?php foreach ($project->get_terms() as $term): ?>
					<option value="<?= $term->get_description() ?>"><?= $term->get_description() ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="col-md-6">
			<div class="input-group">
				<label for="synonym" class="col-sm-12">Synonym</label>
				<input type="text" class="form-control" placeholder="Add a Synonym to Term" id="synonym">
				<div class="input-group-append">
					<button class="btn btn-success" type="button" onclick="add_synonym();">
						<span class="fas fa-plus"></span>
					</button>
				</div>
			</div>
		</div>
	</div>
	<div id="related-terms"></div>
	<br>

	<!-- Terms Table -->
	<table id="table_search_string" class="table table-responsive-sm">
		<caption>List of Term</caption>
		<thead>
			<tr>
				<th>Term</th>
				<th>Synonyms</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($project->get_terms() as $term): ?>
				<tr>
					<td><?= $term->get_description() ?></td>
					<td>
						<table id="table_<?= $term->get_description() ?>" class="table">
							<thead>
								<tr>
									<th>Synonym</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($term->get_synonyms() as $synonym): ?>
									<tr>
										<td><?= $synonym ?></td>
										<td>
											<button class="btn btn-warning opt" onClick="modal_synonym(this)">
												<span class="fas fa-edit"></span>
											</button>
											<button class="btn btn-danger" onClick="delete_synonym(this)">
												<span class="far fa-trash-alt"></span>
											</button>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</td>
					<td>
						<button class="btn btn-warning opt" onClick="modal_term($(this).parents('tr'))">
							<span class="fas fa-edit"></span>
						</button>
						<button class="btn btn-danger" onClick="delete_term($(this).parents('tr'));">
							<span class="far fa-trash-alt"></span>
						</button>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<br>

	<h6><strong><a target="_blank" href="https://stringimprover.herokuapp.com/index.html">String Improver</a></strong></h6>
	<br>

	<!-- Generated Strings per Database -->
	<div id="strings">
		<div class="form-inline">
			<label><strong>Strings</strong></label>
			<a onclick="modal_help('modal_help_strings')" class="float-right opt">
				<i class="fas fa-question-circle"></i>
			</a>
		</div>
		<?php foreach ($project->get_search_strings() as $search_string): ?>
			<div class="form-group" id="div_string_<?= $search_string->get_database()->get_name() ?>">
				<a target="_blank" href="<?= $search_string->get_database()->get_link() ?>">
					<?= $search_string->get_database()->get_name() ?>
				</a>
				<textarea class="form-control" id="string_<?= $search_string->get_database()->get_name() ?>"><?= $search_string->get_description() ?></textarea>
				<button type="button" class="btn btn-info opt"
					onclick="generate_string('<?= $search_string->get_database()->get_name() ?>');">
					Generate
				</button>
				<hr>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="form-inline container-fluid justify-content-between">
		<a href="#tab_databases" class="btn btn-secondary"><span class="fas fa-backward"></span> Previous</a>
		<a href="#tab_search_strategy" class="btn btn-secondary opt">Next <span class="fas fa-forward"></span></a>
	</div>
</div>
