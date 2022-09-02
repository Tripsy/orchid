<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UpdatingObserver
{
    /**
     * Handle the "updating" event.
     *
     * @param Model $model
     * @return void
     */
    public function updating(Model $model): void
    {
        $model->updated_by = Auth::guard(config('app.guards.web'))->user()->id;
    }
}
