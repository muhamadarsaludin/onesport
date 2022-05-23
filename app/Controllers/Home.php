<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title'  => 'Home | Sportpedia',
        ];
        // dd($data);
        return view('public/index', $data);
    }
}
