<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
         $system = ItemPermission::group(__('System'))
            ->addPermission('platform.systems.roles', __('Roles'))
            ->addPermission('platform.systems.users', __('Users'));

        $dashboard->registerPermissions($system);

        $data = ItemPermission::group('Data')
            ->addPermission('platform.systems.category', __('Categories'));

        $dashboard->registerPermissions($data);

        $content = ItemPermission::group('Content')
            ->addPermission('platform.systems.article', __('Articles'));

        $dashboard->registerPermissions($content);
    }
}
