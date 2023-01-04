<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $list = $this->postsList();

        return view('index', compact('list'));
    }

    public function postsList($count = 10)
    {
        $list = Post::orderBy('id', 'desc')->take($count)->get();

        if( ! empty($list)) {
            foreach ($list as &$v) {
                $v->url = '/blog/' . $v->keyword;
            } unset($v);
        }

        return $list;
    }
}
