<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;

use App\Enums\CategorySection;
use App\Models\Category;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class CategorySettingsEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Select::make('category.section')
                ->options(CategorySection::toArray())
                ->required()
                ->title(__('Section'))
                ->help('Specify which section this category should belong to'),

//            Select::make('category.parent_id')
//                ->options(CategorySection::toArray())
//                ->title(__('Parent'))
//                ->help('Specify top category'),


//            Select::make('category.position')
//                ->fromModel(Category::class, 'name')
//                ->title(__('Parent category'))
//                ->help('Specify parent category'),
        ];
    }
}
