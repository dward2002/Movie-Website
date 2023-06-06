<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Movies extends BaseController
{
    public function index($order = 1)
    {
        $model = model(MovieModel::class);
		if($order == 1){
			$model -> orderBy('title', 'ASC');
		}
		else if($order == 2){
			$model -> orderBy('title', 'DESC');
		}

        $data = [
            'movies'  => $model->getMovie(),
            'title' => 'Movie archive',
        ];

        return view('templates/header', $data)
            . view('movies/index')
            . view('templates/footer');
    }

    public function view($slug = null)
    {
        $model = model(MovieModel::class);

        $data['movie'] = $model->getMovie($slug);

        if (empty($data['movie'])) {
            throw new PageNotFoundException('Cannot find the movie item: ' . $slug);
        }
		
		$MovieName = str_replace("-", " ", $data['movie']['movie_title']);
        $data['title'] = $MovieName;

        return view('templates/header', $data)
            . view('movies/view')
            . view('templates/footer');
    }
	
	public function viewReviews($movie_title = "",$movie_id = "", $order =1)
	{
		//grab our model
        $model = model(MovieModel::class);
		
		if($order == 1){
			$model -> orderBy('title', 'ASC');
		}
		else if($order == 2){
			$model -> orderBy('title', 'DESC');
		}

        //load SINGLE news item from model, passing in its slug (id)
        $data['movies'] = $model->getMovies($movie_title);
		$data['title'] = "Reviews";
		$data['movie_title'] = $movie_title;
		$data['movie_id'] = $movie_id;
		//print_r($data['movies']);
		
		        //load views passing our data object
        return view('templates/header', $data)
            . view('movies/reviews')
            . view('templates/footer');
	}

    public function create()
    {
        helper('form');

        // Checks whether the form is submitted.
        if (! $this->request->is('post')) {
            // The form is not submitted, so returns the form.
            return view('templates/header', ['title' => 'Create a movie review'])
                . view('movies/create')
                . view('templates/footer');
        }

        $post = $this->request->getPost(['title', 'body']);

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($post, [
            'title' => 'required|max_length[255]|min_length[3]',
            'body'  => 'required|max_length[5000]|min_length[10]',
        ])) {
            // The validation fails, so returns the form.
            return view('templates/header', ['title' => 'Create a movie review'])
                . view('movies/create')
                . view('templates/footer');
        }

        $model = model(MovieModel::class);

        $model->save([
            'title' => $post['title'],
            'slug'  => url_title($post['title'], '-', true),
            'body'  => $post['body'],
        ]);

		return redirect()->route('movies');	
			
    }
	
    public function createReview($movie_title, $movie_id)
    {
		$session = session();
		$username = $session->get('username');
        helper('form');
		
		if($username == null){
			$username = "";
		}
		
		$data['movie_title'] = $movie_title;
		$data['movie_id'] = $movie_id;

        // Checks whether the form is submitted.
		//step1 - This is called before submitting the form
        if (! $this->request->is('post')) {
            // The form is not submitted, so returns the form.
            return view('templates/header', ['title' => 'Create a movie review'])
                . view('movies/createReview', $data)
                . view('templates/footer');
        }

        $post = $this->request->getPost(['title', 'body']);

        //step2 - Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($post, [
            'title' => 'required|max_length[255]|min_length[3]',
            'body'  => 'required|max_length[5000]|min_length[10]',
        ])) {
            // The validation fails, so returns the form.
            return view('templates/header', ['title' => 'Create a movie review'])
                . view('movies/createReview', $data)
                . view('templates/footer');
        }
		
		//Grab our model, for database access
        $model = model(MovieModel::class);

        $model->save([
            'title' => $post['title'],
            'slug'  => url_title($post['title'], '-', true),
            'body'  => $post['body'],
			'movie_title'  => $movie_title,
			'username' => $username,
        ]);
		
		$redirectUrl = 'movies/reviews/'.$movie_title.'/'.$movie_id;
		return redirect()->to($redirectUrl);	
    }
	
	public function delete($slug = null)
	{	
		$model1 = model(MovieModel::class);
		
		$model1->where('slug',$slug);
        $model1->delete();		
		
		return redirect()->route('movies');	
	}
	
	public function deleteReview($movie_title = null,$movie_id = null,$slug = null)
	{	
		$model1 = model(MovieModel::class);
		
		$model1->where('slug',$slug);
        $model1->delete();		
		
		$redirectUrl = 'movies/reviews/'.$movie_title.'/'.$movie_id;
		return redirect()->to($redirectUrl);		
	}
	
	public function edit($slug = null){
		helper('form');

        //grab our model
        $model = model(MovieModel::class);

        //load SINGLE news item from model, passing in its slug (id)
        $data['movie'] = $model->getMovie($slug);

        //deal with case where slug does not exist
        if (empty($data['movie'])) {
            throw new PageNotFoundException('Cannot find the news item: ' . $slug);
        }
		
        // Checks whether the form is submitted.
		//step1 - This is called before submitting the form
        if (! $this->request->is('post')) {
            // The form is not submitted, so returns the form.
            return view('templates/header', ['title' => 'Edit a news item'])
                . view('movies/edit',$data)
                . view('templates/footer');
        }

        $post = $this->request->getPost(['title', 'body']);

        //step2 - Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($post, [
            'title' => 'required|max_length[255]|min_length[3]',
            'body'  => 'required|max_length[5000]|min_length[10]',
        ])) {
            // The validation fails, so returns the form.
            return view('templates/header', ['title' => 'Edit a news item'])
                . view('movies/edit',$data)
                . view('templates/footer');
        }
		
		$model->replace([
			'id' => $data['movie']['id'],
            'title' => $post['title'],
            'slug'  => url_title($post['title'], '-', true),
            'body'  => $post['body'],
        ]);
		
		return redirect()->route('movies');	
	}
	
	public function editReview($movie_title = null,$movie_id = null,$slug = null){
		$session = session();
		$username = $session->get('username');
		
		helper('form');
		

        //grab our model
        $model = model(MovieModel::class);

        //load SINGLE news item from model, passing in its slug (id)
        $data['movie'] = $model->getMovie($slug);
		$data['movie_title'] = $movie_title;
		$data['movie_id'] = $movie_id;

        //deal with case where slug does not exist
        if (empty($data['movie'])) {
            throw new PageNotFoundException('Cannot find the review: ' . $slug);
        }
		
        // Checks whether the form is submitted.
		//step1 - This is called before submitting the form
        if (! $this->request->is('post')) {
            // The form is not submitted, so returns the form.
            return view('templates/header', ['title' => 'Edit a review'])
                . view('movies/editReview',$data)
                . view('templates/footer');
        }

        $post = $this->request->getPost(['title', 'body']);

        //step2 - Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($post, [
            'title' => 'required|max_length[255]|min_length[3]',
            'body'  => 'required|max_length[5000]|min_length[10]',
        ])) {
            // The validation fails, so returns the form.
            return view('templates/header', ['title' => 'Edit a review'])
                . view('movies/editReview',$data)
                . view('templates/footer');
        }
		
		$model->replace([
			'id' => $data['movie']['id'],
            'title' => $post['title'],
            'slug'  => url_title($post['title'], '-', true),
            'body'  => $post['body'],
			'movie_title'  => $movie_title,
			'username' => $username,
        ]);
		
		$redirectUrl = 'movies/reviews/'.$movie_title."/".$movie_id;
		return redirect()->to($redirectUrl);
	}

}