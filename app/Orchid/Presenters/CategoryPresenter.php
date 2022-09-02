<?php

declare(strict_types=1);

namespace App\Orchid\Presenters;

//use Illuminate\Support\Str;
//use Laravel\Scout\Builder;
use Orchid\Screen\Contracts\Personable;
//use Orchid\Screen\Contracts\Searchable;
use Orchid\Support\Presenter;

//class CategoryPresenter extends Presenter implements Searchable, Personable
class CategoryPresenter extends Presenter implements Personable
{
//    /**
//     * @return string
//     */
//    public function label(): string
//    {
//        return 'Users';
//    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->entity->name;
    }

    /**
     * @return string
     */
    public function subTitle(): string
    {
        $queryData = $this->entity->localeDataOne('meta_title')->first();

        return $queryData ? $queryData->content : '';
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return '#';//route('platform.systems.users.edit', $this->entity);
    }

    /**
     * @return string|null
     */
    public function image(): ?string
    {
        return null;
    }

//    /**
//     * The number of models to return for show compact search result.
//     *
//     * @return int
//     */
//    public function perSearchShow(): int
//    {
//        return 3;
//    }

//    /**
//     * @param string|null $query
//     *
//     * @return Builder
//     */
//    public function searchQuery(string $query = null): Builder
//    {
//        return $this->entity->search($query);
//    }
}
