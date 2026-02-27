<div class="landing-page">
	<section class="hero text-center py-5 bg-gradient" style="background: linear-gradient(135deg, #f8fafc 0%, #e3e9f7 100%);">
		<img src="<?= base_url('assets/img/icone.svg'); ?>" alt="Thoth logo" width="256" height="256" class="mb-3">
		<h1 class="display-3 fw-bold mb-3">Accelerate Your Systematic Review</h1>
		<p class="lead mb-4">Thoth empowers researchers to collaborate, analyze, and publish evidence faster.<br><span class="text-primary fw-semibold">Trusted by academics and professionals worldwide.</span></p>
		<div class="d-flex justify-content-center gap-3 mb-4 flex-wrap">
			<a href="<?= base_url('register'); ?>" class="btn btn-success btn-lg px-4 py-2 shadow">Start Free</a>
			<a href="<?= base_url('login'); ?>" class="btn btn-outline-primary btn-lg px-4 py-2">Login</a>
		</div>
		<div class="d-flex justify-content-center align-items-center gap-4 mt-3 flex-wrap">
			<span class="text-muted small">40+ projects</span>
			<span class="text-muted small">Used by 60+ users</span>
		</div>
	</section>

	<section class="benefits container py-5">
		<div class="benefits-bg position-relative rounded shadow overflow-hidden" style="background: url('<?= base_url('assets/img/research-working.png'); ?>') center/cover no-repeat; min-height: 340px;">
			<div class="benefits-overlay position-absolute top-0 start-0 w-100 h-100" style="background: rgba(255,255,255,0.85); backdrop-filter: blur(2px);"></div>
			<div class="benefits-content position-relative z-2 d-flex flex-column justify-content-center align-items-start h-100 p-4">
				<h2 class="fw-bold mb-3">Why Thoth?</h2>
				<ul class="list-unstyled fs-5 mb-4">
					<li class="mb-2"><i class="fas fa-users text-primary me-2"></i> Seamless team collaboration</li>
					<li class="mb-2"><i class="fas fa-bolt text-success me-2"></i> Fast, intuitive workflow</li>
					<li class="mb-2"><i class="fas fa-shield-alt text-info me-2"></i> Secure & reliable data</li>
					<li class="mb-2"><i class="fas fa-trophy text-warning me-2"></i> Publish with confidence</li>
				</ul>
				<a href="<?= base_url('register'); ?>" class="btn btn-primary btn-lg px-4">Get Started</a>
			</div>
		</div>
	</section>

	<section class="features container py-5">
		<div class="row text-center">
			<div class="col-md-3 mb-4">
				<i class="fas fa-question fa-2x text-primary mb-2"></i>
				<h4 class="fw-semibold">Define Questions</h4>
				<p>Set clear research questions and objectives for your review.</p>
			</div>
			<div class="col-md-3 mb-4">
				<i class="fas fa-database fa-2x text-success mb-2"></i>
				<h4 class="fw-semibold">Find Relevant Data</h4>
				<p>Search and filter high-quality research matching your criteria.</p>
			</div>
			<div class="col-md-3 mb-4">
				<i class="fas fa-thumbs-up fa-2x text-warning mb-2"></i>
				<h4 class="fw-semibold">Assess Quality</h4>
				<p>Evaluate data quality using objective, transparent standards.</p>
			</div>
			<div class="col-md-3 mb-4">
				<i class="fas fa-chart-bar fa-2x text-info mb-2"></i>
				<h4 class="fw-semibold">Analyze & Synthesize</h4>
				<p>Combine and analyze data to generate actionable insights.</p>
			</div>
		</div>
	</section>

	<section class="cta text-center py-5 bg-light">
		<h2 class="fw-bold mb-3">Ready to transform your research?</h2>
		<p class="mb-4">Join Thoth and streamline your systematic review process with powerful features and collaboration tools.</p>
		<a href="<?= base_url('register'); ?>" class="btn btn-success btn-lg px-4 py-2 shadow">Create Account</a>
		<a href="<?= base_url('login'); ?>" class="btn btn-outline-secondary btn-lg px-4 py-2 ms-2">Login</a>
	</section>
</div>
