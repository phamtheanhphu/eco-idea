<?php

namespace Application\Service;

use User\Entity\Group;
use User\Entity\User;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager {

    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Auth service.
     * @var \Zend\Authentication\Authentication
     */
    private $authService;

    /**
     * Url view helper.
     * @var \Zend\View\Helper\Url
     */
    private $urlHelper;


    /**
     * Constructs the service.
     */
    public function __construct($entityManager, $authService, $urlHelper) {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
    }

    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMainMenuItems() {

        $url = $this->urlHelper;

        $items = [
            [
                'id' => 'trang-chu',
                'label' => 'Trang chủ',
                'link' => $url('trang-chu'),
                'icon' => 'fa fa-home'
            ],
            [
                'id' => 'gioi-thieu',
                'label' => 'Giới thiệu',
                'link' => $url('gioi-thieu'),
                'icon' => 'fa fa-info'
            ],
            [
                'id' => 'tin-tuc',
                'label' => 'Tin tức',
                'link' => $url('tin-tuc'),
                'icon' => 'fa fa-file-text-o'
            ],
            [
                'id' => 'lien-he',
                'label' => 'Liên hệ',
                'link' => $url('lien-he'),
                'icon' => 'fa fa-envelope'
            ],
        ];

        if ($this->authService->hasIdentity()) {

            $user_menu_items = [];

            $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($this->authService->getIdentity());

            if ($user instanceof User) {

                $group = $user->getFirstGroup();

                if ($group instanceof Group) {

                    if ($group->getIsAdmin()) {
                        $user_menu_items[] = [
                            'id' => 'admin-panel',
                            'label' => 'Trang quản trị (Admin)',
                            'link' => $url('admin', ['action' => 'index'])
                        ];
                    }

                }

                $user_menu_items[] = [
                    'id' => 'manage-own-device',
                    'label' => 'Quản lý thiết bị',
                    'link' => $url('users', ['action' => 'device-list'])
                ];

                $user_menu_items[] = [
                    'id' => 'change-password',
                    'label' => 'Đổi mật khẩu',
                    'link' => $url('users',
                        ['action' => 'change-password'])
                ];

                $user_menu_items[] = [
                    'id' => 'logout',
                    'label' => 'Đăng xuất/thoát',
                    'link' => $url('logout')
                ];


                $items[] = [

                    'id' => 'account',
                    'label' => $this->authService->getIdentity(),
                    'float' => 'right',
                    'dropdown' => $user_menu_items,
                ];

            }


        }

        return $items;

    }


    public function getUserMenuItems() {

        $url = $this->urlHelper;

        $items = [];

        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.
        if (!$this->authService->hasIdentity()) {

            /*$items[] = [
                'id' => 'login',
                'label' => 'Sign in',
                'link' => $url('login'),
                'float' => 'right'
            ];*/

            return null;

        } else {

            $items = [

                'Thoát' => [
                    'id' => 'logout',
                    'label' => 'Thoát',
                    'icon' => 'fa fa-sign-out',
                    'link' => $url('logout'),
                ]

            ];


        }

        return $items;

    }
}


