<div class='wrapper'>
	<?php echo validation_errors(); ?>

	<?php if ( ! empty($error)): ?>
		<p class='error'>There was a problem saving your profile.</p>
	<?php endif; ?>

	<?php echo form_open_multipart('/user/profile') ?>

		<h2><?php echo $user['username']; ?>&rsquo;s Profile</h2>

		<label for='email'>Email: </label>
		<input type='email' name='email' id='email' value='<?= $profile["email"]; ?>' /><br />

		<label for='first_name'>First Name: </label>
		<input type='text' name='first_name' id='first_name' value='<?= $profile["first_name"]; ?>' /><br />

		<label for='last_name'>Last Name: </label>
		<input type='text' name='last_name' id='last_name' value='<?= $profile["last_name"]; ?>' /><br />

		<label for='password'>Password: </label>
		<input type='password' name='password' id='password' /><br />

		<label for='pwdconf'>Confirm Password: </label>
		<input type='password' name='pwdconf' id='pwdconf' /><br />

		<label for='image'>User Image: </label>
		<input type='file' name='image' id='image' /><br />	

		<input type='hidden' name='username' value='<?= $user["username"]; ?>'>
		<input type='hidden' name='uid' value='<?= $user["uid"]; ?>'>

		<input type='submit' name='submit' value='Save Profile' />

	</form>
</div>