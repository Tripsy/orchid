<?php

declare(strict_types=1);

namespace App\Orchid\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class LocaleDataEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            //todo ViewField maybe
            //https://blog.orchid.software/dive-into-elements-and-forms/
            Input::make('slug')
                ->type('text')
                ->required()
                ->title(__('Slug'))
                ->placeholder(__('Slug'))
                ->help('Enter entity slug'),

            Input::make('meta_title')
                ->type('text')
                ->title(__('Meta Title'))
                ->placeholder(__('Meta title')),

            Input::make('meta_keywords')
                ->type('text')
                ->title(__('Meta Keywords'))
                ->placeholder(__('Meta keywords'))
                ->maxlength(225),

            TextArea::make('meta_description')
                ->title(__('Meta Description'))
                ->placeholder(__('Meta description'))
                ->maxlength(225),
        ];
    }
}
