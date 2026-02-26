</div>
<br>
<footer class="footer bg-body-tertiary border-top py-4">
	<div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
		<div class="small text-secondary text-center text-md-start">
			&copy; <?= date('Y') ?> Thoth — Open Source SLR Platform
		</div>
		<div class="d-flex align-items-center justify-content-center gap-3">
			<a target="_blank" href="https://github.com/ProjetoESE/Thoth" class="text-secondary-emphasis fs-4" aria-label="GitHub Repository">
				<i class="fab fa-github"></i>
			</a>
			<a target="_blank" href="https://github.com/ProjetoESE/Thoth/issues" class="text-danger fs-5" aria-label="Report an Issue">
				<i class="fas fa-bug"></i>
			</a>
		</div>
	</div>
</footer>
<input type="hidden" id="base_url" value="<?= base_url() ?>">
</body>

</html>