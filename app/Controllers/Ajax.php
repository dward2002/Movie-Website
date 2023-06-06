<?php

namespace App\Controllers;

use App\Models\MovieModel;

class Ajax extends BaseController
{
	public function get($slug = null)
	{
		$model = model(MovieModel::class);
		$data = $model->getMovie($slug);

		print(json_encode($data));
	}
	
	public function user($username = null)
	{
		$model = model(UserModel::class);
		$data = $model->getUserName($username);

		print(json_encode($data));
	}
	
}