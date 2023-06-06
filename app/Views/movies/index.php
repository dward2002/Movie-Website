<h2><?= esc($title) ?></h2>

<p id="ajaxArticle"></p>

<a class="btn btn-outline-success mb-4" href="<?=base_url()?>/movies/create">Create movie review</a>

<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Sort
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="<?=base_url()?>/movies/1">Ascending</a></li>
    <li><a class="dropdown-item" href="<?=base_url()?>/movies/2">Descending</a></li>
  </ul>
</div>

<?php if (! empty($movies) && is_array($movies)): ?>

	<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
	
    <?php foreach ($movies as $movie_item): ?>
		<div class="col">
			<div class="card m-2 h-100">
				<div class="card-body">
					<h5 class="card-title"><?= esc($movie_item['title']) ?></h5>
					<p class="card-text"><?= esc($movie_item['body']) ?></p>
				</div>
				<div class="card-footer">
					<a href="<?=base_url()?>/movies/<?= esc($movie_item['slug'], 'url') ?>" class="btn btn-outline-primary">View review</a>
					<a href="<?=base_url()?>/movies/edit/<?= esc($movie_item['slug'], 'url') ?>" class="btn btn-outline-success">Edit review</a>
					<a href="<?=base_url()?>/movies/delete/<?= esc($movie_item['slug'], 'url') ?>" class="btn btn-outline-danger">Delete review</a>
					<a onclick="getData('<?= esc($movie_item['slug'], 'url') ?>')"class="btn btn-outline-info">Ajax</a>
				</div>
			</div>
		</div>
		
    <?php endforeach ?>
	
	</div>

<?php else: ?>

    <h3>No Reviews</h3>

    <p>Unable to find any reviews for you.</p>

<?php endif ?>

<script>
	function getData(slug) {
		
		// Fetch data
		fetch('https://mi-linux.wlv.ac.uk/~2008458/ci4-demo3/public/ajax/get/' + slug)
			
		  // Convert response string to json object
		  .then(response => response.json())
		  .then(response => {

			// Copy one element of response to our HTML paragraph
			document.getElementById("ajaxArticle").innerHTML = response.title + ": " + response.body;
		  })
		  .catch(err => {
			
			// Display errors in console
			console.log(err);
		});
	}
</script>