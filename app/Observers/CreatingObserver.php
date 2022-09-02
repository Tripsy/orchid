<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreatingObserver
{
    /**
     * Handle the "creating" event.
     *
     * @param Model $model
     * @return void
     */
    public function creating(Model $model): void
    {
        $model->created_by = Auth::guard(config('app.guards.web'))->user()->id;
    }
}
