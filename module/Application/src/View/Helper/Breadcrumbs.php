<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * This view helper class displays breadcrumbs.
 */
class Breadcrumbs extends AbstractHelper {

    /**
     * Array of items.
     * @var array
     */
    private $items = [];

    private $top_image_banner = null;

    private $page_label = null;

    /**
     * Constructor.
     * @param array $items Array of items (optional).
     */
    public function __construct($items = []) {
        $this->items = $items;
    }

    /**
     * Sets the items.
     * @param array $items Items.
     */
    public function setItems($items) {
        $this->items = $items;
    }

    /**
     * @return string
     */
    public function getTopImageBanner() {
        return $this->top_image_banner;
    }

    /**
     * @param string $top_image_banner
     */
    public function setTopImageBanner($top_image_banner) {
        $this->top_image_banner = $top_image_banner;
    }

    /**
     * @return string
     */
    public function getPageLabel() {
        return $this->page_label;
    }

    /**
     * @param string $page_label
     */
    public function setPageLabel($page_label) {
        $this->page_label = $page_label;
    }


    /**
     * Renders the breadcrumbs.
     * @return string HTML code of the breadcrumbs.
     */
    public function render() {

        if (count($this->items) == 0)
            return ''; // Do nothing if there are no items.

        // Resulting HTML code will be stored in this var
        if (isset($this->top_image_banner)) {
            $result = '<div class="specific_page-head_agile_info_w3l" 
            style="background: url(' . $this->top_image_banner . ')
             no-repeat center;">';
        } else {
            $result = '<div class="specific_page-head_agile_info_w3l">';
        }


        $result .= '<div class="container">';
        isset($this->page_label) ? $result .= '<h3>' . $this->page_label . '</h3>' : '';
        $result .= '<div class="services-breadcrumb">';
        $result .= '<div class="agile_inner_breadcrumb">';
        $result .= '<ul class="w3_short">';

        // Get item count
        $itemCount = count($this->items);

        $itemNum = 1; // item counter

        // Walk through items
        foreach ($this->items as $label => $link) {

            // Make the last item inactive
            $isActive = ($itemNum == $itemCount ? true : false);

            // Render current item
            $result .= $this->renderItem($label, $link, $isActive);

            // Increment item counter
            $itemNum++;

        }

        $result .= '</ul>';
        $result .= '</div>';
        $result .= '</div>';
        $result .= '</div>';
        $result .= '</div>';

        return $result;

    }

    /**
     * Renders an item.
     * @param string $label
     * @param string $link
     * @param boolean $isActive
     * @return string HTML code of the item.
     */

    protected function renderItem($label, $link, $isActive) {

        $escapeHtml = $this->getView()->plugin('escapeHtml');

        $result = $isActive ? '<li class="active">' : '<li>';

        if (!$isActive)
            $result .= '<a href="' . $escapeHtml($link) . '">' . $escapeHtml($label) . '</a> <i>|</i>';
        else
            $result .= $escapeHtml($label);

        $result .= '</li>';

        return $result;
    }
}
