<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CategorySection;
use App\Enums\DefaultStatus;
use App\Observers\CreatingObserver;
use App\Observers\DeletingLocaleDataObserver;
use App\Observers\DeletingLocaleSlugObserver;
use App\Observers\UpdatingObserver;
use App\Orchid\Presenters\CategoryPresenter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Category extends Model
{
    use AsSource, Filterable, Attachable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'section',
        'depth',
        'parent_id',
        'path',
        'image',
        'sequence',
        'status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => DefaultStatus::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'slug'
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected array $allowedFilters = [
        'status',
        'created_at',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected array $allowedSorts = [
        'id',
        'created_at',
    ];

    protected static function boot()
    {
        parent::boot();

        self::observe(CreatingObserver::class);
        self::observe(UpdatingObserver::class);
        self::observe(DeletingLocaleSlugObserver::class);
        self::observe(DeletingLocaleDataObserver::class);
    }

    public function localeSlug()
    {
        return $this->hasOne(LocaleSlug::class, 'entry_id', 'id')
            ->where('section', '=', 'category')
            ->where('locale', '=', app()->getLocale());
    }

    public function localeDataOne(string $name)
    {
        return $this->hasOne(LocaleData::class, 'entry_id', 'id')
            ->where('section', '=', 'category')
            ->where('locale', '=', app()->getLocale())
            ->where('name', '=', $name);
    }

    public function localeData()
    {
        return $this->hasMany(LocaleData::class, 'entry_id', 'id')
            ->where('section', '=', 'category')
            ->where('locale', '=', app()->getLocale());
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    /**
     * Slug attribute
     *
     * @return Attribute
     */
    protected function slug(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->localeSlug()->sole()->content,
//            set: fn ($value) => $value,
        );
    }

    /**
     * Name attribute
     *
     * @return Attribute
     */
    protected function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->localeDataOne('name')->first()->content,
//            set: fn ($value) => $value,
        );
    }

    /**
     * Section id attribute
     *
     * @return Attribute
     */
    protected function sectionEnum(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => CategorySection::from($attributes['section']),
        );
    }

    /**
     * @return CategoryPresenter
     */
    public function presenter(): CategoryPresenter
    {
        return new CategoryPresenter($this);
    }
}
