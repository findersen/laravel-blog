<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "saving" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function saving(Post $post)
    {
        $slug = str_slug($post->title);
        $title = $post->title;
        $i = 1;

        do {
            $check = Post::where([
                ['keyword', '=', $slug],
                ['id', '<>', $post->id],
            ])->first();

            if( ! empty($check)) {
                $slug = str_slug($post->title) .'-'. $i;
                $title = $post->title .' '. $i;
                $i += 1;
            }
        } while($check);

        $post->keyword = $slug;
        $post->title = $title;

        if(empty($post->meta_title)) {
            $post->meta_title = $post->title;
        }
        if(empty($post->meta_description)) {
            $description = str_limit($post->text, 140, '...');
            $post->meta_description = strip_tags($description);
        }
    }

    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
