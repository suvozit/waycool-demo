<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container my-3">
	<div class="row justify-content-md-center">
		<div class="col col-md-5">
			<h1>Register</h1>

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

			<?php echo form_open('auth/register'); ?>
			  	<div class="form-group">
				    <label for="inputName">Name *</label>
				    <input type="text" class="form-control" id="inputName" placeholder="Enter full name" name="name" value="<?php echo set_value('name'); ?>">
			  	</div>
			  	<div class="form-group">
				    <label for="inputAge">Age</label>
				    <input type="text" class="form-control" id="inputAge" placeholder="Enter age" name="age" value="<?php echo set_value('age'); ?>">
			  	</div>
			  	<div class="form-group">
			  	    <label for="selectGender">Gender</label>
			  	    <select class="form-control" id="selectGender" name="gender">
			  	      	<option value="male" <?php echo set_select('gender', 'male', TRUE); ?>>Male</option>
			  	      	<option value="female" <?php echo set_select('gender', 'female'); ?>>Female</option>
			  	    </select>
			  	</div>
		  	  	<div class="form-group">
		  		    <label for="inputLocation">Location</label>
		  		    <input type="text" class="form-control" id="inputLocation" placeholder="Enter location" name="location" value="<?php echo set_value('location'); ?>">
		  	  	</div>
			  	<div class="form-group">
				    <label for="inputEmail">Email address *</label>
				    <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="<?php echo set_value('email'); ?>">
				    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			  	</div>
			  	<button type="submit" class="btn btn-primary btn-block">Sign up</button>
			<?php echo form_close(); ?>

			<br>
			<h4>Social</h4>
			<a class="social-popup btn btn-outline-secondary btn-sm btn-block" href="<?php echo base_url('social/add/facebook'); ?>" role="button">Facebook</a>
			<a class="social-popup btn btn-outline-secondary btn-sm btn-block" href="<?php echo base_url('social/add/google'); ?>" role="button">Google</a>
		</div>
	</div>
</div>