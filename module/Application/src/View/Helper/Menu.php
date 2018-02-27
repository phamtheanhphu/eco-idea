<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * This view helper class displays a menu bar.
 */
class Menu extends AbstractHelper {

    /**
     * Url view helper.
     * @var \Zend\View\Helper\Url
     */
    private $urlHelper;

    /**
     * Menu items array.
     * @var array
     */
    protected $main_menu_items = [];
    protected $user_menu_items = [];


    /**
     * Active item's ID.
     * @var string
     */
    protected $activeItemId = '';

    /**
     * Constructor.
     * @param array $items Menu items.
     */
    public function __construct($items = [], $user_menu_items = null, $urlHelper) {
        $this->main_menu_items = $items;
        $this->user_menu_items = $user_menu_items;
        $this->urlHelper = $urlHelper;
    }

    /**
     * Sets menu items.
     * @param array $main_menu_items Menu items.
     */
    public function setMainmenuItems($main_menu_items) {
        $this->main_menu_items = $main_menu_items;
    }

    /**
     * Sets ID of the active items.
     * @param string $activeItemId
     */
    public function setActiveItemId($activeItemId) {
        $this->activeItemId = $activeItemId;
    }

    /**
     * Renders the menu.
     * @return string HTML code of the menu.
     */
    public function renderMainMenu() {

        if (count($this->main_menu_items) == 0)
            return ''; // Do nothing if there are no items.

        $result = '<ul class="nav navbar-nav menu__list">';

        // Render items
        foreach ($this->main_menu_items as $item) {
            $result .= $this->renderItem($item);
        }

        $result .= '</ul>';


        return $result;

    }

    public function renderUserMenu() {

        $url = $this->urlHelper;

        if ($this->user_menu_items != null) {

            $result = '<div class="wthreecartaits wthreecartaits2 cart cart box_1">';
            $result .= '<a style="color: #ffffff;padding: 10px;" href="'.$url('logout').'"><i class="fa fa-sign-out"></i> Thoát khỏi</a>';
            $result .= '</div>';

        } else {

            $result = '<div class="wthreecartaits wthreecartaits2 cart cart box_1">';
            $result .= '<a style="color: #ffffff;padding: 10px;" href="'.$url('login').'"><i class="fa fa-user"></i> Đăng nhập</a>';
            $result .= '</div>';
        }


        return $result;

    }

    /**
     * Renders an item.
     * @param array $item The menu item info.
     * @return string HTML code of the item.
     */

    protected function renderItem($item) {

        $id = isset($item['id']) ? $item['id'] : '';
        $isActive = ($id == $this->activeItemId);
        $label = isset($item['label']) ? $item['label'] : '';

        $result = '';

        $escapeHtml = $this->getView()->plugin('escapeHtml');

        if (isset($item['dropdown'])) {

            $dropdownItems = $item['dropdown'];

            $result .= '<li class="dropdown menu__item ' . ($isActive ? 'active' : '') . '">';
            $result .= '<a href="#" class="dropdown-toggle menu__link" data-toggle="dropdown" role="button"
                       aria-haspopup="true" aria-expanded="false">';
            isset($item['icon']) ? $result .= '<i class="' . $item['icon'] . '" aria-hidden="true"></i> ' : '';
            $result .= $escapeHtml($label) . ' <b class="caret"></b>';

            $result .= '</a>';

            $result .= '<ul class="dropdown-menu agile_short_dropdown">';


            foreach ($dropdownItems as $item) {

                $link = isset($item['link']) ? $item['link'] : '#';
                $label = isset($item['label']) ? $item['label'] : '';
                $result .= '<li>';
                $result .= '<a style="padding: 13px; text-align: left;" href="' . $escapeHtml($link) . '">' . $escapeHtml($label) . '</a>';
                $result .= '</li>';

            }

            $result .= '</ul>';
            $result .= '</li>';

        } else {

            $link = isset($item['link']) ? $item['link'] : '#';

            $result .= $isActive ? '<li class="active menu__item menu__item--current">'
                : '<li class="menu__item">';
            $result .= '<a class="menu__link" href="' . $escapeHtml($link) . '">';
            isset($item['icon']) ? $result .= '<i class="' . $item['icon'] . '" aria-hidden="true"></i> ' : '';
            $result .= $escapeHtml($label) . '</a>';
            $result .= '</li>';
        }

        return $result;

    }
}
