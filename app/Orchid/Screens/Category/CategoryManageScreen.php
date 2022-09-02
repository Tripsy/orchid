<?php

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use App\Orchid\Layouts\Category\CategorySettingsEditLayout;
use App\Orchid\Layouts\ImageSingleEditLayout;
use App\Orchid\Layouts\LocaleDataEditLayout;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryManageScreen extends Screen
{
    /**
     * @var Category
     */
    public Category $category;

    /**
     * Query data.
     *
     * @param Category $category
     *
     * @return array
     */
    public function query(Category $category): iterable
    {
        $localeDataResult = $category->localeData()->get();

        $returnData = [
            'slug' => $category->exists ? $category->slug : '',
            'category' => $category,
        ];

        foreach ($localeDataResult as $row) {
            $returnData[$row->name] = $row->content;
        }

        return $returnData;
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->category->exists ? 'Edit category' : 'Add category';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Specify category details';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.systems.category',
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Remove category'))
                ->method('remove')
                ->canSee($this->category->exists),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * @return Layout[]
     */
    public function layout(): iterable
    {
        return [

            Layout::block(LocaleDataEditLayout::class)
                ->title(__('Meta data'))
                ->description(__('Enter category meta data'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->category->exists)
                        ->method('save')
                ),

            Layout::block(CategorySettingsEditLayout::class)
                ->title(__('Settings'))
                ->description(__('Set category specific settings.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->category->exists)
                        ->method('save')
                ),

            Layout::block(ImageSingleEditLayout::class)
                ->title(__('Image'))
                ->description(__('Set category image.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->category->exists)
                        ->method('save')
                ),
        ];
    }

    /**
     * @param Category $category
     * @param Request $request
     * @return RedirectResponse
     */
    public function save(Category $category, Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required'
            ],
            'slug' => [
                'required',
//                Rule::unique(User::class, 'email')->ignore($user),
            ],
        ]);

//        $permissions = collect($request->get('permissions'))
//            ->map(function ($value, $key) {
//                return [base64_decode($key) => $value];
//            })
//            ->collapse()
//            ->toArray();
//
//        $user->when($request->filled('user.password'), function (Builder $builder) use ($request) {
//            $builder->getModel()->password = Hash::make($request->input('user.password'));
//        });
//
//        $category
//            ->fill($request->collect('user')->except(['password', 'permissions', 'roles'])->toArray())
//            ->save();

        $category
            ->fill($request->collect('category')->toArray())
            ->save();

        $category->localeSlug()->updateOrCreate(
            [
                'entry_id' => $category->id,
            ],
            [
                'locale' => app()->getLocale(),
                'section' => 'category',
                'entry_id' => $category->id,
                'content' => $request->input('slug')
            ]
        );

        $localeDataRequest = $request->only('name', 'meta_title', 'meta_keywords', 'meta_description');

        foreach ($localeDataRequest as $k => $v) {
            if (empty($v) === true) {
                $category->localeDataOne($k)->delete();
            } else {
                $category->localeDataOne($k)->updateOrCreate(
                    [
                        'entry_id' => $category->id,
                    ],
                    [
                        'locale' => app()->getLocale(),
                        'section' => 'category',
                        'entry_id' => $category->id,
                        'name' => $k,
                        'content' => $v
                    ]
                );
            }
        }

        Toast::info(__('Category was saved.'));

        return redirect()->route('platform.systems.category.list');
    }

    /**
     * @param Category $category
     *
     * @throws Exception
     *
     * @return RedirectResponse
     *
     */
    public function remove(Category $category): RedirectResponse
    {
        $category->delete();

        Toast::info(__('Category was removed'));

        return redirect()->route('platform.systems.category.list');
    }
}
