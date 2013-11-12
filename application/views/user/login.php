<div class='wrapper'>
	<?php echo validation_errors(); ?>

	<?php if ( ! empty($error)): ?>
		<p class='error'>Sorry, we couldn't log you in with that information.</p>
	<?php endif; ?>

	<?php echo form_open('') ?>

		<h2>Login</h2>

		<label for='username'>Username: </label>
		<input type='text' name='username' id='username' /><br />

		<label for='password'>Password: </label>
		<input type='password' name='password' id='password' /><br />

		<input type='submit' name='submit' value='Login' />

	</form>
</div>