<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class Blog extends Controller
{
    public function index()
    {
        $list = Post::orderBy('id', 'desc')->paginate(12);

        if( ! empty($list)) {
            foreach ($list as &$v) {
                $v->url = '/blog/' . $v->keyword;
            } unset($v);
        }

        $menu = $this->menu();

        return view('blog.index', compact(['list', 'menu']));
    }

    public function category($keyword)
    {
        $category = PostCategory::where('keyword', '=', $keyword)->first();

        $list = Post::where([
            ['cat_id', '=', $category->id],
        ])->orderBy('id', 'desc')->paginate(12);

        $menu = $this->menu();

        return view('blog.index', compact(['list', 'category', 'menu']));
    }

    public function menu()
    {
        $list = PostCategory::all();

        if( ! empty($list)) {
            foreach ($list as &$v) {
                $v->url = '/blog/category/' . $v->keyword;
            } unset($v);
        }

        return view('blog.menu', compact('list'));
    }

    public function post($keyword)
    {
        $post = Post::where([
            ['keyword', '=', $keyword],
        ])->first();

        return view('blog.post', compact('post'));
    }
}
