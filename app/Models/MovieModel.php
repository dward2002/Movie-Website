<?php

namespace App\Models;

use CodeIgniter\Model;

class MovieModel extends Model
{
    protected $table = 'movies';
	protected $allowedFields = ['title', 'slug', 'body', 'movie_title', 'username'];
	
	    public function getMovie($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
	
	//This funcion returns news items from the db
    public function getMovies($movie_title = false)
    {
        //if no slug (id) prvided, select all
        if ($movie_title === false) {
            return $this->findAll();
        }

        //if slug provided, select just that one
        return $this->where(['movie_title' => $movie_title])->findAll();
    }
}