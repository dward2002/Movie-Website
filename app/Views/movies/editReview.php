<h2><?= esc($title) ?></h2>

<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<form action="<?=base_url()?>/movies/editReview/<?=$movie_title?>/<?=$movie_id?>/<?=$movie['slug']?>" method="post">
    <?= csrf_field() ?>
	
	<div class="mb-3">
		<label for="title" class="form-label">Title</label>
		<?php
			//if there is no errors from validation (first loaded this page)
			if(empty(validation_list_errors())){
				//load input with value from database
				echo("<input class=\"form-control\" type=\"input\" name=\"title\" value=\"".$movie['title']."\">");
			}
			else{
				//load input with last inputted value before the error
				echo("<input class=\"form-control\" type=\"input\" name=\"title\" value=\"".set_value('title')."\">");
			}
			echo("<br>");
		?>
	</div>
	
	<div class="mb-3">
		<label for="body" class="form-label">Text</label>
		<?php
			//if there is no errors from validation (first loaded this page)
			if(empty(validation_list_errors())){
				echo("<textarea class=\"form-control\" name=\"body\" cols=\"45\" rows=\"4\">".$movie['body']."</textarea>");
			}
			else{
				//load input with last inputted value before the error
				echo("<textarea class=\"form-control\" name=\"body\" cols=\"45\" rows=\"4\">".set_value('body')."</textarea>");
			}
			echo("<br>");
		?>
	</div>

    <input class="btn btn-primary" type="submit" name="submit" value="Edit Review">
</form>