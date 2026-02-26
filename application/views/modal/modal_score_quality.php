<div class="modal fade" id="modal_score_quality" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Edit Question Quality</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="index_score">
				<input type="hidden" id="old_score_rule">
				<input type="hidden" id="id_qa_score">
				<div class="d-flex flex-wrap align-items-end gap-2">
					<div class="input-group col-md-6">
						<label for="edit_score_rule" class="col-sm-12">Score Rule</label>
						<input type="text" class=" form-control" id="edit_score_rule">
					</div>
					<div class="input-group col-md-6">
						<label for="edit_score" id="edit_lbl_score" class="col-sm-12">Score: 50%</label>
						<input type="range" min="0" max="100" class="form-range" id="edit_score" step="5"
							   oninput="update_text_score(this.value)" onchange="update_text_score(this.value)"">
					</div>
					<div class="input-group col-md-12">
						<label for="edit_desc_score" class="col-sm-12">Description</label>
						<input type="text" class=" form-control" id="edit_desc_score">
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
				<a class="btn btn-success" onclick="edit_score_quality()">Save</a>
			</div>
		</div>
	</div>
</div>
