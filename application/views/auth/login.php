<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container my-3">
	<div class="row justify-content-md-center">
		<div class="col col-md-5">
			<h1>Login</h1>

			<?php
			if ($message = $this->session->flashdata('error_message'))
			{
				?>
				<div class="alert alert-danger" role="alert">
					<?php echo $message; ?>
				</div>
				<?php
			}
			?>

			<?php echo validation_errors(); ?>

			<?php echo form_open('auth/login'); ?>
			  	<div class="form-group">
				    <label for="inputEmail">Email address</label>
				    <input type="email" class="form-control" id="inputEmail" placeholder="Enter email" name="email" value="<?php echo set_value('email'); ?>">
			  	</div>
			  	<div class="form-group">
				    <label for="inputPassword">Password</label>
				    <input type="password" class="form-control" id="inputPassword" placeholder="Password" placeholder="Enter password" name="password" value="<?php echo set_value('password'); ?>">
				</div>
			  	<button type="submit" class="btn btn-primary btn-block">Login</button>
			<?php echo form_close(); ?>

			<br>
			<h4>Social</h4>
			<a class="social-popup btn btn-outline-secondary btn-sm btn-block" href="<?php echo base_url('social/add/facebook'); ?>" role="button">Facebook</a>
			<a class="social-popup btn btn-outline-secondary btn-sm btn-block" href="<?php echo base_url('social/add/google'); ?>" role="button">Google</a>

			<br>
			<a href="<?php echo base_url('auth/register'); ?>">Create a new account</a>
		</div>
	</div>
</div>