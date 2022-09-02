<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Category;

use App\Enums\CategorySection;
use App\Enums\DefaultStatus;
use App\Models\Category;
use App\Models\User;
use App\Orchid\Screens\Layouts\CardListName;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'categories';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id', __('ID'))
                ->cantHide()
                ->sort()
                ->filter(Input::make())
                ->render(function (Category $category) {
                    return $category->id;
                }),

            TD::make('name', __('Name'))
                ->cantHide()
                ->sort()
                ->filter(Input::make())
                ->render(function (Category $category) {
                    return new CardListName($category->presenter());
                }),
//
//            TD::make('email', __('Email'))
//                ->sort()
//                ->cantHide()
//                ->filter(Input::make())
//                ->render(function (User $user) {
//                    return ModalToggle::make($user->email)
//                        ->modal('asyncEditUserModal')
//                        ->modalTitle($user->presenter()->title())
//                        ->method('saveUser')
//                        ->asyncParameters([
//                            'user' => $user->id,
//                        ]);
//                }),
//
            TD::make('section', __('Section'))
                ->filter(
                    Select::make()
                        ->options(CategorySection::toArray(false))
                )
                ->render(function (Category $category) {
                    return CategorySection::from($category->section)->text();
                }),

            TD::make('status', __('Status'))
                ->filter(
                    Select::make()
                        ->options(DefaultStatus::toArray(false))
                )
                ->render(function (Category $category) {
                    return $category->status->text();
                }),

            TD::make('created_at', __('Created at'))
                ->sort()
                ->render(function (Category $category) {
                    return $category->updated_at->toDateTimeString();
                }),

            TD::make(__('Actions'))
                ->cantHide()
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Category $category) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.systems.category.edit', $category->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Confirm category remove.'))
                                ->method('remove', [
                                    'id' => $category->id,
                                ]),
                        ]);
                }),
        ];
    }
}
