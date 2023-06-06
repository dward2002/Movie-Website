<h2><?= esc($title) ?></h2>

<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<form action="<?=base_url()?>/movies/createReview/<?= $movie_title ?>/<?= $movie_id ?>" method="post">
    <?= csrf_field() ?>

	<div class="mb-3">
		<label for="title" class="form-label">Title</label>
		<input class="form-control" type="input" name="title" value="<?= set_value('title') ?>">
		<br>
	</div>
	<div class="mb-3">
		<label for="body" class="form-label">Text</label>
		<textarea class="form-control" name="body" cols="45" rows="4"><?= set_value('body') ?></textarea>
		<br>
	</div>
	
    <input class="btn btn-primary" type="submit" name="submit" value="Create news item">
</form>