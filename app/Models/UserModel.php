<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	//what table is this model working with
    protected $table = 'movies_user';
	
	//what fields inside the table is the model allowed to update
	protected $allowedFields = ['username', 'password'];

    //This funcion returns news items from the db
    public function getUser($username = false)
    {
        //if no slug (id) prvided, select all
        if ($username === false) {
            return $this->findAll();
        }

        //if slug provided, select just that one
        return $this->where(['username' => $username])->first();
    }

	public function getUserName($username = false)
    {
        //if slug provided, select just that one
		$this->select('username');
        return $this->where(['username' => $username])->first();
    }
}