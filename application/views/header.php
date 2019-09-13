<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container">
		<a class="navbar-brand mb-0 h1" href="<?php echo base_url(); ?>">Demo</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link <?php if ($active_tab == 'dashboard') echo 'active'; ?>" href="<?php echo base_url(); ?>">Home</a>
				</li>
				<li class="nav-item <?php if ($active_tab == 'profile') echo 'active'; ?>">
					<a class="nav-link" href="<?php echo base_url('profile'); ?>">Profile</a>
				</li>
			</ul>

			<ul class="navbar-nav">
				<li class="nav-item float-right">
					<a class="nav-link" href="<?php echo base_url('auth/logout'); ?>">Log out</a>
				</li>
			</ul>
		</div>
	</div>
</nav>