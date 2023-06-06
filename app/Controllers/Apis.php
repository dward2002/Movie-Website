<?php

namespace App\Controllers;

use App\Models\MovieModel;

class Apis extends BaseController
{
	public function movieapi($genre = 16)
	{
		//get movie data for a specific genre (gets 20 movies from that genre)
		$url = "https://api.themoviedb.org/3/discover/movie?api_key= Enter your own key here &language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_genres=".$genre."&with_watch_monetization_types=flatrate";

		// Get data from URL and store in object
		$json = file_get_contents($url);
		$data['movies'] = json_decode($json);
		$data['title'] = "Movie List";

		//print_r($data['movies']);
		
		//get the link to movie pages, uses the id from the previous fetch
		$count = 0;
		foreach ($data['movies']->results as $movie){
			$movieId = $movie -> id;
			$url1 = "https://api.themoviedb.org/3/movie/".$movieId."?api_key=Enter your own key here";

			// Get data from URL and store in object
			$json1 = file_get_contents($url1);
			$data1['oneMovie'] = json_decode($json1);
			
			//homepage is the link to web page url
			$data['link'][$count] = $data1['oneMovie'] -> homepage;
			$count = $count + 1;
		}
		
		echo view('templates/header', $data);
		echo view('apis/display-movie', $data);
		echo view('templates/footer', $data);
	}
	
}