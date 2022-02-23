<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Samgyngobr\Scarlet\Models\Scarlet;


class Index extends Controller
{
    public function index()
    {
        $sk = new Scarlet('about-us');
        $aboutUs = $sk->fetchUnique();

        $sk2 = new Scarlet('list');
        $list = $sk2->fetch([
            //'limit'  => 2,
            //'offset' => 1
        ]);

        return view('content/index/index', compact( 'aboutUs', 'list' ));
    }
}
