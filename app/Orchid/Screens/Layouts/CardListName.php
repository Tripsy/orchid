<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Layouts;

use Illuminate\View\View;
use Orchid\Screen\Contracts\Personable;
use Orchid\Screen\Layouts\Content;

class CardListName extends Content
{
    /**
     * @var string
     */
    protected $template = 'layouts.cardListName';

    /**
     * @param Personable $entity
     * @return View
     */
    public function render(Personable $entity): View
    {
        return view($this->template, [
            'title'    => $entity->title(),
            'subTitle' => $entity->subTitle(),
            'image'    => $entity->image(),
            'url'      => $entity->url(),
        ]);
    }
}
