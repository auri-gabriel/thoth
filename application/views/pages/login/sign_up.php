
<section class="signup-section py-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-md-7 col-lg-5">
				<div class="card shadow-sm border-0">
					<div class="card-header bg-white text-center">
						<h2 class="fw-bold mb-0">Join Thoth</h2>
					</div>
					<div class="card-body p-4">
						<?php echo form_open('Login_Controller/log_up', array('class' => 'form-signup')); ?>
							<div class="mb-3">
								<label for="name" class="form-label">Name</label>
								<input type="text" class="form-control form-control-lg" name="name" id="name" placeholder="Your Name" required autofocus>
							</div>
							<div class="mb-3">
								<label for="InputEmail1" class="form-label">Email address</label>
								<input type="email" name="email" class="form-control form-control-lg" id="InputEmail1" aria-describedby="emailHelp"
									   placeholder="Enter email" required>
							</div>
							<div class="mb-3">
								<label for="InputPassword" class="form-label">Password</label>
								<input type="password" name="password" class="form-control form-control-lg" id="InputPassword"
									   placeholder="Password" required>
							</div>
							<div class="d-grid gap-2">
								<button type="submit" class="btn btn-success btn-lg">Create a new account</button>
							</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
