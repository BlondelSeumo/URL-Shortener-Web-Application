<?php

namespace App\Observers;

use App\Link;

class LinkObserver
{
    /**
     * Handle the Link "deleted" event.
     *
     * @param  \App\Link  $link
     * @return void
     */
    public function deleting(Link $link)
    {
        $link->stats()->delete();
        $link->pixels()->detach();
    }
}
