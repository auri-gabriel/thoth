<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
	<div class="container-fluid">
		<a class="navbar-brand d-flex align-items-center gap-2"
			 href="<?= (isset($_SESSION['logged_in']) ? base_url('dashboard') : base_url()) ?>">
			<img id="logo"
					 src="<?= base_url('assets/img/icone.svg'); ?>"
					 width="30"
					 height="30"
					 class="d-inline-block align-top me-2"
					 alt="">
			Thoth
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu"
						aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="menu">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center">
				<li class="nav-item">
					<a class="nav-link" href="<?= base_url('about') ?>">About</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= base_url('help') ?>">Help</a>
				</li>
				<li class="nav-item">
					<form class="d-flex align-items-center" action="<?= base_url('search') ?>">
						<input class="form-control me-2 opt" name="search" type="search" placeholder="Search in Thoth"
									 aria-label="Search">
						<button class="btn btn-outline-success opt d-flex align-items-center gap-1" type="submit">
							<span class="fas fa-search"></span> Search
						</button>
					</form>
				</li>
			</ul>
			<ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
				<?php
				if (isset($_SESSION['logged_in'])) {
					?>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('profile') ?>">
							<span class="fas fa-address-card fa-lg"></span> <?= $this->session->name; ?>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('sign_out'); ?>">
							<span class="fas fa-sign-out-alt fa-lg"></span> Sign out
						</a>
					</li>
					<?php
				} else {
					?>
					<li class="nav-item">
						<a class="nav-link aut" href="<?= base_url('login'); ?>">
							<span class="fas fa-sign-in-alt fa-lg"></span> Sign in
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('sign_up'); ?>">
							<span class="fas fa-user-plus fa-lg"></span> Sign up
						</a>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
	</div>
</nav>

<br>
<?php
if (isset($_SESSION['error'])) {
	?>
	<div class="alert alert-danger container-fluid alert-dismissible fade show" role="alert">
		<strong>
			<?= $_SESSION['error']; ?>
		</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<br>
	<?php
}
?>

<?php
if (isset($_SESSION['success'])) {
	?>
	<div class="alert alert-success container-fluid alert-dismissible fade show" role="alert">
		<strong>
			<?= $_SESSION['success']; ?>
		</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<br>
	<?php
}
?>

<?php
if (isset($_SESSION['info'])) {
	?>
	<div class="alert alert-info container-fluid alert-dismissible fade show" role="alert">
		<strong>
			<?= $_SESSION['info']; ?>
		</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<br>
	<?php
}
?>

<?php
if (isset($_SESSION['warning'])) {
	?>
	<div class="alert alert-warning container-fluid alert-dismissible fade show" role="alert">
		<strong>
			<?= $_SESSION['warning']; ?>
		</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<br>
	<?php
}
?>
<div class="container-fluid">
