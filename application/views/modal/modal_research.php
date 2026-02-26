<div class="modal fade" id="modal_research" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Edit Research Question</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="index_research">
				<div class="d-flex flex-wrap align-items-end gap-2">
					<div class="input-group col-md-3">
						<label for="edit_research_id" class="col-sm-12">ID</label>
						<input type="text" id="edit_research_id" class="form-control">
					</div>
					<div class="input-group col-md-9">
						<label for="edit_research_question" class="col-sm-12">Description</label>
						<input type="text" id="edit_research_question" class="form-control">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
				<a class="btn btn-success" onclick="edit_research()">Save</a>
			</div>
		</div>
	</div>
</div>
