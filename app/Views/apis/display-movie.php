<link rel="stylesheet" href="<?=base_url()?>/stylesheets/stylesheet1.css">

<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Genre
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="<?=base_url()?>/apis/movie/16">Animation</a></li>
    <li><a class="dropdown-item" href="<?=base_url()?>/apis/movie/878">Science Fiction</a></li>
	<li><a class="dropdown-item" href="<?=base_url()?>/apis/movie/27">Horror</a></li>
  </ul>
</div>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">

<?php $count = 0; ?>
<?php foreach ($movies->results as $movie): ?>
	<div class="col">
		<div class="card m-2 h-100">
		  <a id = "movieLink" href="<?= esc($link[$count])?>">
			<img src="https://image.tmdb.org/t/p/w500/<?=$movie->poster_path?>" class="card-img-top" alt="..." style="object-fit: cover">
		  </a>
		  <div class="card-body">
			<h5 class="card-title"><?= esc($movie->title) ?></h5>
			<p class="card-text"><?= esc($movie->overview) ?></p>
			<p class="card-text">Release Date: <?= esc($movie->release_date) ?></p>
			<p class="card-text">Rating: <?= esc($movie->vote_average) ?></p>
		  </div>
		  <div class="card-footer">
			<a href="<?=base_url()?>/movies/reviews/<?= url_title(esc($movie->title))?>/<?= esc($movie->id)?>" class="btn btn-outline-primary">View reviews</a>
		  </div>
		</div>
	</div>
	<?php $count = $count + 1; ?>

<?php endforeach ?>

</div>



