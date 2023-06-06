<?php $session = session();?>
<link rel="stylesheet" href="<?=base_url()?>/stylesheets/stylesheet2.css">

<h2><?= esc($title) ?></h2>

<div id = "dropDown" class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    More options...
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" onclick="getMovieData(<?= esc($movie_id) ?>)" otype="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
	Movie Data
	</a></li>
    <li><a class="dropdown-item" href="<?=base_url()?>/movies/createReview/<?=$movie_title ?>/<?= esc($movie_id) ?>">Create article</a></li>
	<li><a onclick="getLocation()" otype="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#weatherModal">
Weather data
</a></li>
  </ul>
</div>

<p id="ajaxArticle"></p>

<p id="ajaxMovie"></p>

<p id="charging"></p>

<!-- Button trigger modal -->
<a id="movieBtn" onclick="getMovieData(<?= esc($movie_id) ?>)" otype="button" class="btn btn-outline-info mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
View Movie data via Ajax
</a>

<!-- Modal -->
<div class="modal fade" style="max-height:700px" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button onclick="" "type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6 id="bodyLabel"></h6>
		<br>
		<img id="imgid" src="" class="card-img-top" alt="...">
		<br>
		<br>
		<p id="date"></p>
		<p id="rating"></p>
	  </div>
      <div class="modal-footer">
        <button onclick="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<a id = "createBtn" class="btn btn-outline-success mb-4" href="<?=base_url()?>/movies/createReview/<?=$movie_title ?>/<?= esc($movie_id) ?>">Create article</a>

<!-- Button trigger modal -->
<a id="movieBtn" onclick="getLocation()" otype="button" class="btn btn-outline-info mb-4" data-bs-toggle="modal" data-bs-target="#weatherModal">
Weather data
</a>

<!-- Modal -->
<div class="modal fade" id="weatherModal" tabindex="-1" aria-labelledby="weatherModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="weatherModalLabel">Modal title</h5>
        <button onclick="" "type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6 id="weatherBodyLabel"></h6>
		<img id="weatherImgid" src="" class="card-img-top" alt="..." style="style="object-fit: cover;">
		<p id="date"></p>
		<p id="rating"></p>
	  </div>
      <div class="modal-footer">
        <button onclick="" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Sort
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="<?=base_url()?>/movies/reviews/<?= esc($movie_title) ?>/<?= esc($movie_id) ?>/1">Ascending</a></li>
    <li><a class="dropdown-item" href="<?=base_url()?>/movies/reviews/<?= esc($movie_title) ?>/<?= esc($movie_id) ?>/2">Descending</a></li>
  </ul>
</div>

<?php if (! empty($movies) && is_array($movies)): ?>

	<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
	
    <?php foreach ($movies as $movie_item): ?>
		<div class="col">
			<div class="card m-2 h-100">
			  <div class="card-body">
				<h5 class="card-title"><?= esc($movie_item['title']) ?></h5>
				<?php if(strlen($movie_item['body']) > 35){
					$body = substr($movie_item['body'], 0, 36);
					$body .= "...";
				}
				else{
					$body = $movie_item['body'];
				}
				?>
				<p class="card-text"><?= esc($body) ?></p>
				<p class="card-text">posted by: <?= esc($movie_item['username']) ?></p>
			  </div>
			  <div class="card-footer">
				<a href="<?=base_url()?>/movies/<?= esc($movie_item['slug'], 'url') ?>" class="btn btn-outline-primary"><i class="bi bi-eye"></i></a>
				<?php
					if($session->get('logged_in') == null){
						
					}
						
					elseif($session->get('username') == $movie_item['username']){
						echo("<a href=\"".base_url()."/movies/editReview/".$movie_title."/".$movie_id."/".esc($movie_item['slug'], 'url')."\" class=\"btn btn-outline-success m-1\"><i class=\"bi bi-pencil\"></i></a>");
						echo("<a href=\"".base_url()."/movies/deleteReview/".$movie_title."/".$movie_id."/".esc($movie_item['slug'], 'url')."\" class=\"btn btn-outline-danger m-1\"><i class=\"bi bi-trash\"></i></a>");
					}
				?>
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

let nIntervId;
//batteryFunction();

	/*function batteryFunction(){
		  console.log("bat");
		  navigator.getBattery().then(battery => {
			let m = ""
			let level = 0;
			m = battery.level * 100 + "%"
			level = battery.level * 100;

			if (battery.charging) {
			  m += " ⚡";
			  nIntervId = setInterval('refresh()', 5000);
			}
			else if(level > 65){
				nIntervId = setInterval('refresh()', 10000);
			}
			else if(level > 45){
				nIntervId = setInterval('refresh()', 15000);
			}
			else{
				nIntervId = setInterval('refresh()', 20000);
				//darker screen fo energy saving
				//remove ajax button for energy saving
				//var elem = document.getElementById('movieBtn');
				//elem.parentNode.removeChild(elem);
			}
			console.log(m);
			document.getElementById("charging").innerHTML = m;
			
		  })
	}*/




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
	
	function getMovieData(movieId) {
		// Fetch data
		fetch('https://api.themoviedb.org/3/movie/'+movieId+'?api_key=enter your own key here')
			
		  // Convert response string to json object
		  .then(response => response.json())
		  .then(response => {

			// Copy one element of response to our HTML paragraph
			document.getElementById("exampleModalLabel").innerHTML = response.title;
			document.getElementById("bodyLabel").innerHTML = response.overview;
			document.getElementById("imgid").src="https://image.tmdb.org/t/p/w500/"+response.poster_path;
			document.getElementById("date").innerHTML = "Release Date: "+response.release_date;
			document.getElementById("rating").innerHTML = "Rating: "+response.vote_average;
			//clearInterval(nIntervId);
		  
		  })
		  .catch(err => {
			
			// Display errors in console
			console.log(err);
		});
	}
	
	function getLocation(){
		navigator.geolocation.getCurrentPosition((position) => {
		  console.log(position.coords.latitude);
		  console.log(position.coords.longitude);
		  var lat = position.coords.latitude;
		  var lon = position.coords.longitude;
		  //clearInterval(nIntervId);
		  getWeather(lat,lon);
		});
	}
	
	function getWeather(lat,lon){
		
		// Fetch data
		fetch('https://api.openweathermap.org/data/2.5/weather?lat='+lat+'&lon='+lon+'&appid=Enter your own key here')
			
		  // Convert response string to json object
		  .then(response => response.json())
		  .then(response => {

			// Copy one element of response to our HTML paragraph
			console.log(response.weather[0].main);
			console.log(response.weather[0].icon);
			var weather = response.weather[0].icon;
			var message = "";
			if(weather == "01d"){
				message = "today is sunny, so make sure you get your vitamin d, before you watch tv";
			}
			else if(weather == "02d"){
				message = "the weather is fairly nice, why not put away your device, and instead watch a film on the night";
				
			}
			else if(weather == "03d"){
				message = "Scattered clouds above, the cinema aglow, As the film takes flight, imagination starts to flow.";
			}
			else if(weather == "04d"){
				message = "Broken clouds dance across the sky, Why not lose yourself in a movie's high.";
			}
			else if(weather == "09d"){
				message = "When shower rain dampens the day, Watch a movie and keep the gloom at bay.";
			}
			else if(weather == "10d"){
				message = "When the raindrops start to fall, Watching a movie beats it all.";
			}
			else if(weather == "11d"){
				message = "When a thunderstorm makes you cower, A movie's sound can drown its power.";
			}
			else if(weather == "13d"){
				message = "Go play in the snow, it's a rare delight, Then come back inside to warm up and watch a movie all night.";
			}
			else if(weather == "50d"){
				message = "When misty fog makes it hard to roam, Stay in and watch a movie at home.";
			}
			else{
				message = "";
			}
			console.log(message);
			document.getElementById("weatherModalLabel").innerHTML = response.weather[0].main;
			document.getElementById("weatherBodyLabel").innerHTML = message;
			document.getElementById("weatherImgid").src='http://openweathermap.org/img/wn/'+weather+'@2x.png';
			//document.getElementById("exampleModalLabel").innerHTML = response.title;
			//document.getElementById("bodyLabel").innerHTML = response.overview;
			//document.getElementById("imgid").src="https://image.tmdb.org/t/p/w500/"+response.poster_path;
			//document.getElementById("date").innerHTML = "Release Date: "+response.release_date;
			//document.getElementById("rating").innerHTML = "Rating: "+response.vote_average;
			//clearInterval(nIntervId);
		  
		  })
		  .catch(err => {
			
			// Display errors in console
			console.log(err);
		});
		
		
		
	}
	
	
	
	
	function refresh() {
        window.location.reload();
    }
</script>