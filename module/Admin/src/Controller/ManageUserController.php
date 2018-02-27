<?php
/**
 * Created by PhpStorm.
 * User: phu.pham
 * Date: 23/2/2018
 * Time: 9:36 AM
 */

namespace Admin\Controller;

use User\Entity\User;
use User\Form\PasswordChangeForm;
use User\Form\UserForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class ManageUserController extends AbstractActionController {

    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * User manager.
     * @var \User\Service\UserManager
     */
    private $userManager;

    /**
     * ManageUserController constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param \User\Service\UserManager $userManager
     */
    public function __construct(\Doctrine\ORM\EntityManager $entityManager, \User\Service\UserManager $userManager) {
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
    }

    //index
    public function indexAction() {

        $users = $this->entityManager->getRepository(User::class)
            ->findBy([], ['id' => 'ASC']);

        return new ViewModel([
            'users' => $users,
            'initPlugins' => [
                'datatables'
            ]
        ]);

    }

    //add
    public function addAction() {

        // Create user form
        $form = new UserForm('create', $this->entityManager);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                // Add user.
                $user = $this->userManager->addUser($data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('admin/manage-user',
                    ['action' => 'view', 'id' => $user->getId()]);
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    //view
    public function viewAction() {

        $id = (int)$this->params()->fromRoute('id', -1);

        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find a user with such ID.
        $user = $this->entityManager->getRepository(User::class)
            ->find($id);

        if ($user == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'user' => $user
        ]);

    }

    //edit
    public function editAction() {

        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $user = $this->entityManager->getRepository(User::class)
            ->find($id);

        if ($user == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Create user form
        $form = new UserForm('update', $this->entityManager, $user);

        //handle request
        $request = $this->getRequest();

        // Check if user has submitted the form
        if ($request->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                // Update the user.
                $this->userManager->updateUser($user, $data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('admin/manage-user',
                    ['action' => 'view', 'id' => $user->getId()]);

            }

        } else {
            $form->setData(array(
                'full_name' => $user->getFullName(),
                'email' => $user->getEmail(),
                'status' => $user->getStatus(),
            ));
        }

        return new ViewModel(array(
            'user' => $user,
            'form' => $form
        ));

    }

    //change-password
    public function changePasswordAction() {


        $id = (int)$this->params()->fromRoute('id', -1);

        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $user = $this->entityManager->getRepository(User::class)
            ->find($id);

        if ($user == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        //handle request
        $request = $this->getRequest();

        // Create "change password" form
        $form = new PasswordChangeForm('change_by_admin');
        $this->flashMessenger()->clearMessages();

        // Check if user has submitted the form
        if ($request->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                // Try to change password.
                if (!$this->userManager->changePasswordByAdmin($user, $data)) {
                    $this->flashMessenger()->addErrorMessage(
                        'Mật khẩu mới không hợp lệ, vui lòng kiểm tra lại !');
                } else {
                    $this->flashMessenger()->addSuccessMessage(
                        'Thay đổi mật khẩu thành công !');
                }

                // Redirect to "view" page
                /*return $this->redirect()->toRoute('users',
                    ['action' => 'view', 'id' => $user->getId()]);*/
            } else {
                $this->flashMessenger()->addErrorMessage(
                    'Thông tin nhập không hợp lệ, vui lòng kiểm tra lại !');
            }

        }

        return new ViewModel([
            'user' => $user,
            'form' => $form
        ]);


    }


    //remove
    public function removeAction() {

        $id = (int)$this->params()->fromRoute('id', -1);

        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find a user with such ID.
        $user = $this->entityManager->getRepository(User::class)
            ->find($id);

        if ($user == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            if ($request->getPost('remove_confirm')) {

                $this->entityManager->remove($user);
                $this->entityManager->flush();

                // Redirect to "main" page
                return $this->redirect()->toRoute('admin/manage-user',
                    ['action' => 'index']);

            }
        }

        return new ViewModel([
            'user' => $user
        ]);

    }

}