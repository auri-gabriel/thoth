<div class="modal fade" id="modal_option" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Edit Option</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="index_op">
				<input type="hidden" id="old_op">
				<input type="hidden" id="qe_op">
				<div class="d-flex flex-wrap align-items-end gap-2">
					<div class="input-group col-md-12">
						<label for="now_op" class="col-sm-12">Option</label>
						<input type="text" class=" form-control" id="now_op">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-danger" data-bs-dismiss="modal">Cancel</a>
				<a class="btn btn-success" onclick="edit_option();">Save</a>
			</div>
		</div>
	</div>
</div>
