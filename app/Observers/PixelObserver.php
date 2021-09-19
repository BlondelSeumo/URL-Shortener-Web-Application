<?php

namespace App\Observers;

use App\Pixel;

class PixelObserver
{
    /**
     * Handle the Pixel "deleted" event.
     *
     * @param  \App\Pixel  $pixel
     * @return void
     */
    public function deleting(Pixel $pixel)
    {
        $pixel->links()->detach();
    }
}
