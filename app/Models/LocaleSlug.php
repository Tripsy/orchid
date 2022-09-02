<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocaleSlug extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locale_slug';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale',
        'section',
        'entry_id',
        'content',
    ];
}
