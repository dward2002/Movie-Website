<?php

namespace App\Controllers;

class Map extends BaseController
{
    public function map()
    {
		$data = [
            'title' => 'Cinema map',
        ];
		
        return view('templates/header', $data)
            . view('map/map')
            . view('templates/footer');
    }
}