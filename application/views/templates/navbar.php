<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom sticky-top" style="z-index: 1000;">
	<div class="container">
		<a class="navbar-brand d-flex align-items-center fw-bold text-decoration-none text-white" href="<?= (isset($_SESSION['logged_in']) ? site_url('dashboard') : site_url()) ?>" title="Thoth - Evidence Synthesis Platform">
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
				<li class="nav-item align-self-center mx-auto" style="min-width: 260px;">
					<form class="d-flex w-100 align-items-center" action="<?= site_url('search') ?>" style="margin-bottom: 0;">
						<input class="form-control me-2 opt flex-grow-1 align-self-center" name="search" type="search" placeholder="Search in Thoth" aria-label="Search" style="height: 38px;">
						<button class="btn btn-outline-primary opt d-flex align-items-center gap-1 align-self-center" type="submit" style="height: 38px;">
							<span class="fas fa-search"></span> <span class="d-none d-md-inline">Search</span>
						</button>
					</form>
				</li>
			</ul>
			<ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center flex-row gap-2">
				<li class="nav-item d-flex align-items-center">
					<a class="nav-link" href="<?= site_url('about') ?>">About</a>
				</li>
				<li class="nav-item d-flex align-items-center">
					<a class="nav-link" href="<?= site_url('help') ?>">Help</a>
				</li>
				<?php if (isset($_SESSION['logged_in'])): ?>
					<li class="nav-item d-flex align-items-center ms-3">
						<div class="dropdown text-end">
							<a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
								<span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;font-size:1.1rem;font-weight:bold;">
									<?= strtoupper(substr($this->session->name, 0, 1)); ?>
								</span>
								<span class="fw-semibold"><?= $this->session->name; ?></span>
							</a>
							<ul class="dropdown-menu dropdown-menu-end text-small shadow">
								<li><a class="dropdown-item" href="<?= site_url('project/new'); ?>">New project...</a></li>
								<li><a class="dropdown-item" href="<?= site_url('profile'); ?>">Profile</a></li>
								<li>
									<hr class="dropdown-divider">
								</li>
								<li><a class="dropdown-item" href="<?= site_url('logout'); ?>">Sign out</a></li>
							</ul>
						</div>
					</li>
				<?php else: ?>
					<li class="nav-item d-flex align-items-center ms-2">
						<a class="nav-link aut px-2" href="<?= site_url('login'); ?>">Login</a>
					</li>
					<li class="nav-item d-flex align-items-center ms-1">
						<a class="nav-link px-2" href="<?= site_url('signup'); ?>">Register</a>
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