<?php
namespace User\Controller;

use Device\Entity\Device;
use Device\Form\DeviceSetConfigForm;
use Device\Form\DeviceSetupConfigForm;
use User\Entity\User;
use User\Form\PasswordChangeForm;
use User\Form\PasswordResetForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * This controller is responsible for user management (adding, editing,
 * viewing users and changing user's password).
 */
class UserController extends AbstractActionController {

    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Authentication service.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    /**
     * User manager.
     * @var \User\Service\UserManager
     */
    private $userManager;

    /**
     * User manager.
     * @var \Device\Service\DeviceManager
     */
    private $deviceManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager, $authService, $userManager, $deviceManager) {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
        $this->userManager = $userManager;
        $this->deviceManager = $deviceManager;
    }

    public function indexAction() {

        if ($this->authService->hasIdentity()) {

            $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($this->authService->getIdentity());

            if ($user != null && $user instanceof User) {

                return new ViewModel([
                    'user' => $user,
                ]);

            }

        }

        $this->getResponse()->setStatusCode(404);
        return;

    }


    //device-list
    public function deviceListAction() {

        if ($this->authService->hasIdentity()) {

            $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($this->authService->getIdentity());

            if ($user != null && $user instanceof User) {

                $devices = $user->getDevices();

                return new ViewModel([
                    'devices' => $devices,
                    'user' => $user,
                    'initPlugins' => [
                        'datatables'
                    ]
                ]);

            }

        }

        $this->getResponse()->setStatusCode(404);
        return;

    }

    //device-detail
    public function deviceDetailAction() {

        if ($this->authService->hasIdentity()) {

            $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($this->authService->getIdentity());

            if ($user != null && $user instanceof User) {

                $id = (int)$this->params()->fromRoute('id', -1);

                if ($id > 0) {

                    // Find a device with such ID.
                    $device = $this->entityManager->getRepository(Device::class)
                        ->find($id);

                    if ($device != null && $device instanceof $device) {

                        if (in_array($device, $user->getDevices()->toArray())) {

                            return new ViewModel([
                                'device' => $device
                            ]);

                        }

                    }


                }


            }
        }

        $this->getResponse()->setStatusCode(404);
        return;


    }


    //device-setup-config
    public function deviceSetupConfigAction() {

        if ($this->authService->hasIdentity()) {

            $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($this->authService->getIdentity());

            if ($user != null && $user instanceof User) {

                $id = (int)$this->params()->fromRoute('id', -1);

                if ($id > 0) {

                    // Find a device with such ID.
                    $device = $this->entityManager->getRepository(Device::class)
                        ->find($id);

                    if ($device != null && $device instanceof Device) {

                        if (in_array($device, $user->getDevices()->toArray())) {

                            //setup the form
                            $deviceSetupConfigForm = new DeviceSetupConfigForm('smart_farm_device', null, $device);

                            //handle request
                            $request = $this->getRequest();

                            if ($request->isPost()) {

                                // Fill in the form with POST data
                                $data = $this->params()->fromPost();

                                $deviceSetupConfigForm->setData($data);

                                // Validate form
                                if ($deviceSetupConfigForm->isValid()) {

                                    // Get filtered and validated data
                                    $data = $deviceSetupConfigForm->getData();
                                    $this->deviceManager->updateDeviceConfigs('smart_farm_device', $device, $data);

                                }

                            }

                            return new ViewModel([
                                'device' => $device,
                                'form' => $deviceSetupConfigForm,
                                'initPlugins' => [
                                    'bootstrap-switch',
                                    'select2',
                                ]
                            ]);

                        }
                    }

                }
            }
        }

        $this->getResponse()->setStatusCode(404);
        return;

    }

    //device-view-data-record
    public function deviceViewDataRecordAction() {

        if ($this->authService->hasIdentity()) {

            $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($this->authService->getIdentity());

            if ($user != null && $user instanceof User) {

                $id = (int)$this->params()->fromRoute('id', -1);

                if ($id > 0) {

                    // Find a device with such ID.
                    $device = $this->entityManager->getRepository(Device::class)
                        ->find($id);

                    if ($device != null && $device instanceof Device) {

                        if (in_array($device, $user->getDevices()->toArray())) {

                            $receive_records = $device->getReceiveRecords();

                            return new ViewModel([
                                'device' => $device,
                                'receive_records' => $receive_records,
                                'initPlugins' => [
                                    'bootstrap-switch',
                                    'select2',
                                    'datatables'
                                ]
                            ]);

                        }
                    }

                }
            }
        }

        $this->getResponse()->setStatusCode(404);
        return;

    }

    //change-password
    public function changePasswordAction() {


        if ($this->authService->hasIdentity()) {

            $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($this->authService->getIdentity());

            if ($user != null && $user instanceof User) {

                // Create "change password" form
                $form = new PasswordChangeForm('change');

                // Check if user has submitted the form
                if ($this->getRequest()->isPost()) {

                    // Fill in the form with POST data
                    $data = $this->params()->fromPost();

                    $form->setData($data);

                    // Validate form
                    if ($form->isValid()) {

                        // Get filtered and validated data
                        $data = $form->getData();

                        // Try to change password.
                        if (!$this->userManager->changePassword($user, $data)) {
                            $this->flashMessenger()->addErrorMessage(
                                'Sorry, the old password is incorrect. Could not set the new password.');
                        } else {
                            $this->flashMessenger()->addSuccessMessage(
                                'Changed the password successfully.');
                        }

                        // Redirect to "view" page
                        /*return $this->redirect()->toRoute('users',
                            ['action' => 'view', 'id' => $user->getId()]);*/
                    }
                }

                return new ViewModel([
                    'user' => $user,
                    'form' => $form
                ]);

            }


        }

        $this->getResponse()->setStatusCode(404);
        return;


    }

    /**
     * This action displays the "Reset Password" page.
     */
    public function resetPasswordAction() {
        // Create form
        $form = new PasswordResetForm();

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if ($form->isValid()) {

                // Look for the user with such email.
                $user = $this->entityManager->getRepository(User::class)
                    ->findOneByEmail($data['email']);
                if ($user != null) {
                    // Generate a new password for user and send an E-mail 
                    // notification about that.
                    $this->userManager->generatePasswordResetToken($user);

                    // Redirect to "message" page
                    return $this->redirect()->toRoute('users',
                        ['action' => 'message', 'id' => 'sent']);
                } else {
                    return $this->redirect()->toRoute('users',
                        ['action' => 'message', 'id' => 'invalid-email']);
                }
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * This action displays an informational message page.
     * For example "Your password has been resetted" and so on.
     */
    public function messageAction() {

        // Get message ID from route.
        $id = (string)$this->params()->fromRoute('id');

        // Validate input argument.
        if ($id != 'invalid-email' && $id != 'sent' && $id != 'set' && $id != 'failed') {
            throw new \Exception('Invalid message ID specified');
        }

        return new ViewModel([
            'id' => $id
        ]);

    }

    /**
     * This action displays the "Reset Password" page.
     */
    public function setPasswordAction() {

        $token = $this->params()->fromQuery('token', null);

        // Validate token length
        if ($token != null && (!is_string($token) || strlen($token) != 32)) {
            throw new \Exception('Invalid token type or length');
        }

        if ($token === null ||
            !$this->userManager->validatePasswordResetToken($token)
        ) {
            return $this->redirect()->toRoute('users',
                ['action' => 'message', 'id' => 'failed']);
        }

        // Create form
        $form = new PasswordChangeForm('reset');

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if ($form->isValid()) {

                $data = $form->getData();

                // Set new password for the user.
                if ($this->userManager->setNewPasswordByToken($token, $data['new_password'])) {

                    // Redirect to "message" page
                    return $this->redirect()->toRoute('users',
                        ['action' => 'message', 'id' => 'set']);
                } else {
                    // Redirect to "message" page
                    return $this->redirect()->toRoute('users',
                        ['action' => 'message', 'id' => 'failed']);
                }
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }
}


