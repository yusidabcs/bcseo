<?php

namespace Modules\Bcseo\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\User\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('bcseo::seos.title.seos'), function (Item $item) {

                $item->weight(11);
                $item->icon('fa fa-copy');
                $item->route('admin.bcseo.seo.index');
                $item->authorize(
                    $this->auth->hasAccess('bcseo.index')
                );
// append

            });
        });

        return $menu;
    }
}
