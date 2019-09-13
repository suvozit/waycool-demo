<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('header', ['active_tab' => 'profile']); ?>

<div class="container my-4">
	<div class="row">
		<div class="col col-lg-12">
			<h1>Profile #<?php echo $user['user_id']; ?></h1>

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

			<?php
			if ($message = $this->session->flashdata('success_message'))
			{
				?>
				<div class="alert alert-success" role="alert">
					<?php echo $message; ?>
				</div>
				<?php
			}
			?>

			<?php echo validation_errors(); ?>

		</div>
	</div>

	<div class="row">
		<div class="col-lg-7 mb-4">
			
			<?php echo form_open('profile'); ?>
			  	<div class="form-group">
				    <label for="inputName">Name *</label>
				    <input type="text" class="form-control" id="inputName" placeholder="Enter full name" name="name" value="<?php echo set_value('name', $user['name']); ?>">
			  	</div>
			  	<div class="form-group">
				    <label for="inputAge">Age</label>
				    <input type="text" class="form-control" id="inputAge" placeholder="Enter age" name="age" value="<?php echo set_value('age', $user['age']); ?>">
			  	</div>
			  	<div class="form-group">
			  	    <label for="selectGender">Gender</label>
			  	    <select class="form-control" id="selectGender" name="gender">
			  	      	<option value="male" <?php echo set_select('gender', 'male', $user['gender'] == 'male'); ?>>Male</option>
			  	      	<option value="female" <?php echo set_select('gender', 'female', $user['gender'] == 'female'); ?>>Female</option>
			  	    </select>
			  	</div>
		  	  	<div class="form-group">
		  		    <label for="inputLocation">Location</label>
		  		    <input type="text" class="form-control" id="inputLocation" placeholder="Enter location" name="location" value="<?php echo set_value('location', $user['location']); ?>">
		  	  	</div>
			  	<div class="form-group">
				    <label for="inputEmail">Email address *</label>
				    <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="<?php echo set_value('email', $user['email']); ?>">
				    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			  	</div>
			  	<button type="submit" class="btn btn-primary btn-block">Update</button>
			<?php echo form_close(); ?>

		</div>
		<div class="col-lg-5">
			<h4>Social</h4>

			<?php
			if (!is_null($user['facebook_id']))
			{
				?>
				<p>Facebook <code><?php echo $user['facebook_id']; ?></code></p>
				<?php
			}
			else
			{
				?>
				<a class="social-popup btn btn-outline-secondary btn-sm btn-block" href="<?php echo base_url('social/add/facebook'); ?>" role="button">Facebook</a>
				<?php
			}
			?>

			<?php
			if (!is_null($user['google_id']))
			{
				?>
				<p>Google <code><?php echo $user['google_id']; ?></code></p>
				<?php
			}
			else
			{
				?>
				<a class="social-popup btn btn-outline-secondary btn-sm btn-block" href="<?php echo base_url('social/add/google'); ?>" role="button">Google</a>
				<?php
			}
			?>

			<br>
			<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#exampleModalCenter">
				Delete Account
			</button>

		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a class="btn btn-danger" href="<?php echo base_url('profile/delete_user'); ?>">Delete</a>
      </div>
    </div>
  </div>
</div>
