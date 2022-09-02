<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class DeletingLocaleSlugObserver
{
    /**
     * Handle the "deleting" event.
     *
     * @param Model $model
     * @return void
     */
    public function deleting(Model $model): void
    {
        $model->localeSlug()->delete();
    }
}
