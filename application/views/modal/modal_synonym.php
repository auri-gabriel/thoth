<div class="modal fade" id="modal_synonym" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Edit Synonym</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="term_synonym">
				<input type="hidden" id="index_synonym">
				<input type="hidden" id="old_synonym">
				<label for="now_synonym" class="col-sm-12 col-md-2">Synonym</label>
				<div class="d-flex flex-wrap align-items-end gap-2">
					<input type="text" id="now_synonym" class="form-control col-sm-12 col-md-12">
				</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
				<a class="btn btn-success" onclick="edit_synonym()">Save</a>
			</div>
		</div>
	</div>
</div>
