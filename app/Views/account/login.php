<h2><?= esc($title) ?></h2>

<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>
<h5><?= esc($error) ?></h5>

<form action="<?=base_url()?>/login" method="post">
    <?= csrf_field() ?>

	<div class="mb-3">
		<label for="username" class="form-label">Username</label>
		<input class="form-control" type="input" name="username" value="<?= set_value('username') ?>">
		<br>
	</div>
	<div class="mb-3">
		<label for="password" class="form-label">Password</label>
		<input class="form-control" type="password" name="password" value="<?= set_value('password') ?>">
		<br>
	</div>
	
    <input class="btn btn-primary" type="submit" name="submit" value="Login">
</form>
<a href="<?=base_url()?>/signup">Create an account</a><br>