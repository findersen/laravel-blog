<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    public function catsList($paginate = 10)
    {
        $list = $this->orderBy('sort', 'asc')->paginate($paginate); //DB::table(BLOG_CATEGORIES_TABLE)->get();

        return $list; //json_decode($list, true);
    }
}
