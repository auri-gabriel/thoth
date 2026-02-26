<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom sticky-top" style="z-index: 1000;">
	<div class="container">
		<a class="navbar-brand d-flex align-items-center fw-bold text-decoration-none text-white" href="<?= (isset($_SESSION['logged_in']) ? base_url('dashboard') : base_url()) ?>" title="Thoth - Evidence Synthesis Platform">
			<h1 class="mb-0">
				<span class="me-3 p-2 bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="height: 32px; font-size: 1rem; font-weight: bold;">
					<img id="logo" src="<?= base_url('assets/img/icone.svg'); ?>" width="24" height="24" class="d-inline-block align-top me-2" alt="">
					Thoth
				</span>
			</h1>
			<span class="d-none d-xl-block text-dark ms-2" style="line-height: 1.2; max-width: 300px; font-size: 0.85rem; overflow-wrap: break-word; hyphens: auto; white-space: normal;">
				Systematic Literature Review Platform
			</span>
		</a>
		<button class="navbar-toggler" type="button" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation" data-bs-toggle="collapse" data-bs-target="#menu">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="menu">
			<ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center flex-row gap-2">
				<li class="nav-item d-flex align-items-center">
					<a class="nav-link" href="<?= base_url('about') ?>">About</a>
				</li>
				<li class="nav-item d-flex align-items-center">
					<a class="nav-link" href="<?= base_url('help') ?>">Help</a>
				</li>
				<li class="nav-item align-self-center" style="min-width: 260px;">
					<form class="d-flex w-100 align-items-center" action="<?= base_url('search') ?>" style="margin-bottom: 0;">
						<input class="form-control me-2 opt flex-grow-1 align-self-center" name="search" type="search" placeholder="Search in Thoth" aria-label="Search" style="height: 38px;">
						<button class="btn btn-outline-primary opt d-flex align-items-center gap-1 align-self-center" type="submit" style="height: 38px;">
							<span class="fas fa-search"></span> <span class="d-none d-md-inline">Search</span>
						</button>
					</form>
				</li>
				<?php if (isset($_SESSION['logged_in'])): ?>
					<li class="nav-item d-flex align-items-center ms-3">
						<a class="nav-link" href="<?= base_url('profile') ?>">
							<span class="fas fa-address-card fa-lg"></span> <?= $this->session->name; ?>
						</a>
					</li>
					<li class="nav-item d-flex align-items-center">
						<a class="nav-link" href="<?= base_url('sign_out'); ?>">
							<span class="fas fa-sign-out-alt fa-lg"></span> Sign out
						</a>
					</li>
				<?php else: ?>
					<li class="nav-item d-flex align-items-center ms-3">
						<a class="nav-link aut" href="<?= base_url('login'); ?>">
							<span class="fas fa-sign-in-alt fa-lg"></span> Sign in
						</a>
					</li>
					<li class="nav-item d-flex align-items-center">
						<a class="nav-link" href="<?= base_url('sign_up'); ?>">
							<span class="fas fa-user-plus fa-lg"></span> Sign up
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</nav>

<br>
<?php
foreach (
	[
		'error' => 'danger',
		'success' => 'success',
		'info' => 'info',
		'warning' => 'warning',
	] as $type => $class
) {
	if (isset($_SESSION[$type])) {
?>
		<div class="alert alert-<?= $class ?> container-fluid alert-dismissible fade show mt-2" role="alert">
			<strong><?= $_SESSION[$type]; ?></strong>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<br>
<?php
	}
}
?>
<div class="container-fluid">
