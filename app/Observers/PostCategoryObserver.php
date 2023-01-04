<?php

namespace App\Observers;

use App\Models\PostCategory;

class PostCategoryObserver
{
    /**
     * Handle the Post "saving" event.
     *
     * @param  \App\Models\PostCategory  $postCategory
     * @return void
     */
    public function saving(PostCategory $postCategory)
    {
        $slug = str_slug($postCategory->title);
        $title = $postCategory->title;
        $i = 1;

        do {
            $check = PostCategory::where([
                ['keyword', '=', $slug],
                ['id', '<>', $postCategory->id],
            ])->first();

            if( ! empty($check)) {
                $slug = str_slug($postCategory->title) .'-'. $i;
                $title = $postCategory->title .' '. $i;
                $i += 1;
            }
        } while($check);

        $postCategory->keyword = $slug;
        $postCategory->title = $title;

        if(empty($postCategory->meta_title)) {
            $postCategory->meta_title = $postCategory->title;
        }

        if(empty($postCategory->h1_title)) {
            $postCategory->h1_title = $postCategory->title;
        }

        if(empty($postCategory->meta_description)) {
            $postCategory->meta_description = str_limit($postCategory->seo_text, 80, '...');
        }
    }

    /**
     * Handle the PostCategory "created" event.
     *
     * @param  \App\Models\PostCategory  $postCategory
     * @return void
     */
    public function created(PostCategory $postCategory)
    {
        //
    }

    /**
     * Handle the PostCategory "updated" event.
     *
     * @param  \App\Models\PostCategory  $postCategory
     * @return void
     */
    public function updated(PostCategory $postCategory)
    {
        //
    }

    /**
     * Handle the PostCategory "deleted" event.
     *
     * @param  \App\Models\PostCategory  $postCategory
     * @return void
     */
    public function deleted(PostCategory $postCategory)
    {
        //
    }

    /**
     * Handle the PostCategory "restored" event.
     *
     * @param  \App\Models\PostCategory  $postCategory
     * @return void
     */
    public function restored(PostCategory $postCategory)
    {
        //
    }

    /**
     * Handle the PostCategory "force deleted" event.
     *
     * @param  \App\Models\PostCategory  $postCategory
     * @return void
     */
    public function forceDeleted(PostCategory $postCategory)
    {
        //
    }
}
