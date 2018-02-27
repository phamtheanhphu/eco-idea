<?php
/**
 * Created by PhpStorm.
 * User: phu.pham
 * Date: 22/2/2018
 * Time: 3:39 PM
 */

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * This view helper class displays a menu bar.
 */
class TopMenu extends AbstractHelper {

    /**
     * Url view helper.
     * @var \Zend\View\Helper\Url
     */
    private $urlHelper;

    /**
     * Auth service.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    /**
     * TopMenu constructor.
     * @param \Zend\View\Helper\Url $urlHelper
     * @param \Zend\Authentication\AuthenticationService $authService
     */
    public function __construct(\Zend\View\Helper\Url $urlHelper, \Zend\Authentication\AuthenticationService $authService) {
        $this->urlHelper = $urlHelper;
        $this->authService = $authService;
    }

    public function renderItems() {
        $url = $this->urlHelper;
        $result = '<ul>';
        if (!$this->authService->hasIdentity()) {
            $result .= '<li><a href="#" data-toggle="modal" data-target="#login_modal"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Đăng nhập</a></li>';
            $result .= '<li><a href="#" data-toggle="modal" data-target="#signup_modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Đăng ký</a></li>';
        } else {

            $result .= '<li>';
            $result .= '<a href="#"><i class="fa fa-user" aria-hidden="true"></i>' . $this->authService->getIdentity() . '</a>';
            $result .= '</li>';

            $result .= '<li>';
            $result .= '<a href="'.$url('logout').'"><i class="fa fa-sign-out" aria-hidden="true"></i>Đăng xuất</a>';
            $result .= '</li>';
        }

        $result .= '<li><i class="fa fa-phone" aria-hidden="true"></i> Điện thoại: (84)-28-38303625</li>';

        $result .= '<li><i class="fa fa-envelope-o" aria-hidden="true"></i><a href="mailto:info@eco-idea.vn">info@eco-idea.vn</a></li>';

        $result .= '</ul>';


        return $result;

    }


}