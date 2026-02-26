<div class="modal fade" id="modal_help_database" tabindex="-1" aria-labelledby="modal_help_database_label" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title fs-5" id="modal_help_database_label">Help: Article Database</h2>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<section>
					<p>An article database lets you search journals for articles on specific topics. Each database covers a unique set of journals.</p>
				</section>
				<section>
					<h3 class="h6 mt-3">Supported Databases</h3>
					<ul>
						<?php foreach ($databases as $database) { ?>
							<li><?= $database ?></li>
						<?php } ?>
					</ul>
				</section>
				<section>
					<p class="mt-3">You can add custom databases and set search strings for each.</p>
				</section>
			</div>
		</div>
	</div>
</div>
