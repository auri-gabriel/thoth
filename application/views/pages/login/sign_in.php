
<section class="login-section py-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-md-7 col-lg-5">
				<div class="card shadow-sm border-0">
					<div class="card-header bg-white text-center">
						<h2 class="fw-bold mb-0">Sign In</h2>
					</div>
					<div class="card-body p-4">
						<?php echo form_open('Login_Controller/log_into', array('class' => 'form-signin')); ?>
							<div class="mb-3">
								<label for="InputEmail1" class="form-label">Email address</label>
								<input type="email" name="email" class="form-control form-control-lg" id="InputEmail1" aria-describedby="emailHelp"
									   placeholder="Enter email" required autofocus>
								<small id="emailHelp" class="form-text text-muted">Enter your login information.</small>
							</div>
							<div class="mb-3">
								<label for="InputPassword" class="form-label">Password</label>
								<input type="password" name="password" class="form-control form-control-lg" id="InputPassword"
									   placeholder="Password" required>
							</div>
							<div class="d-grid gap-2">
								<button type="submit" class="btn btn-success btn-lg">Sign In</button>
							</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

