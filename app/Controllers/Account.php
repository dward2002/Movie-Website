<?php

namespace App\Controllers;

use App\Models\UserModel;

class Account extends BaseController
{
	public function signUp()
	{        
        helper('form');

        // Checks whether the form is submitted.
		//step1 - This is called before submitting the form
        if (! $this->request->is('post')) {
            // The form is not submitted, so returns the form.
            return view('templates/header', ['title' => 'Sign up'])
                . view('account/signUp')
                . view('templates/footer');
        }

        $post = $this->request->getPost(['username', 'password']);

        //step2 - Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($post, [
            'username' => 'required|max_length[255]|min_length[3]',
            'password'  => 'required|max_length[5000]|min_length[10]',
        ])) {
            // The validation fails, so returns the form.
            return view('templates/header', ['title' => 'Sign up'])
                . view('account/signUp')
                . view('templates/footer');
        }
		
		//Grab our model, for database access
        $model = model(UserModel::class);

        $model->save([
            'username' => $post['username'],
            'password'  => $post['password'],
        ]);
		
		$session = session();
		
		$newdata = [
			'username'  => $post['username'],
			'logged_in' => true,
		];

		$session->set($newdata);
		
		return redirect()->route('apis/movie');
	}
	
	public function login()
	{        
        helper('form');

        // Checks whether the form is submitted.
		//step1 - This is called before submitting the form
        if (! $this->request->is('post')) {
            // The form is not submitted, so returns the form.
            return view('templates/header', ['title' => 'Login'])
                . view('account/login', ['error' => ''])
                . view('templates/footer');
        }

        $post = $this->request->getPost(['username', 'password']);

        //step2 - Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($post, [
            'username' => 'required|max_length[255]|min_length[3]',
            'password'  => 'required|max_length[5000]|min_length[10]',
        ])) {
            // The validation fails, so returns the form.
            return view('templates/header', ['title' => 'Sign up'])
                . view('account/login', ['error' => ''])
                . view('templates/footer');
        }
		
		//Grab our model, for database access
        $model = model(UserModel::class);

		$data['account'] = $model->getUser($post['username']);
		
		if($data['account'] != null && $data['account']['password'] == $post['password']){
			$session = session();
		
			$newdata = [
				'username'  => $post['username'],
				'logged_in' => true,
			];

			$session->set($newdata);
		
			return redirect()->route('apis/movie');
		}
		else{
			return view('templates/header', ['title' => 'Login'])
                . view('account/login', ['error' => 'incorrect username/password'])
                . view('templates/footer');
		}
	}	
	
	public function logout(){
		$session = session();
		session_destroy();
		return redirect()->route('apis/movie');
	}
	
}