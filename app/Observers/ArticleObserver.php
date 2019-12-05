<?php

namespace App\Observers;

use App\Model\Article;

class ArticleObserver
{
    //
    public function creating(Article $article)
    {
        $cnt_url = request()->get('cnt_url');

        $article->cnt_url = $cnt_url == null ? '' : $cnt_url;

    }


    public function updating(Article $article)
    {
        $cnt_url = request()->get('cnt_url');
        $article->cnt_url = $cnt_url == null ? '' : $cnt_url;

    }

}
