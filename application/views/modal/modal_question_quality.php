<div class="modal fade" id="modal_question_quality" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Edit Question Quality</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="index_qa">
				<div class="d-flex flex-wrap align-items-end gap-2">
					<div class="input-group col-md-3">
						<label for="edit_id_qa" class="col-sm-12">ID</label>
						<input type="text" class=" form-control" id="edit_id_qa">
					</div>
					<div class="input-group col-md-9">
						<label for="edit_desc_qa" class="col-sm-12">Description</label>
						<input type="text" class=" form-control" id="edit_desc_qa">
					</div>
					<div class="input-group col-md-3">
						<label for="edit_weight_qa" class="col-sm-12">Weight</label>
						<input type="number" class="form-control" id="edit_weight_qa" step="0.5">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
				<a class="btn btn-success" onclick="edit_qa()">Save</a>
			</div>
		</div>
	</div>
</div>
