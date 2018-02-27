<?php
/**
 * Created by PhpStorm.
 * User: phu.pham
 * Date: 23/2/2018
 * Time: 2:44 PM
 */

namespace Admin\Controller;

use Device\Entity\Device;
use Device\Form\DeviceForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ManageDeviceController extends AbstractActionController {

    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * User manager.
     * @var \Device\Service\DeviceManager
     */
    private $deviceManager;

    /**
     * ManageDeviceController constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param \Device\Service\DeviceManager $deviceManager
     */
    public function __construct(\Doctrine\ORM\EntityManager $entityManager, \Device\Service\DeviceManager $deviceManager) {
        $this->entityManager = $entityManager;
        $this->deviceManager = $deviceManager;
    }

    public function indexAction() {

        $devices = $this->entityManager->getRepository(Device::class)
            ->findBy([], ['id' => 'ASC']);

        return new ViewModel([
            'devices' => $devices,
            'initPlugins' => [
                'datatables'
            ]
        ]);
    }

    //add
    public function addAction() {

        // Create device form
        $form = new DeviceForm('create', $this->entityManager);

        $request = $this->getRequest();

        // Check if device has submitted the form
        if ($request->isPost()) {

            // Fill in the form with POST data
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $form->setData($data);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                // Add device.
                $device = $this->deviceManager->addDevice($data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('admin/manage-device',
                    ['action' => 'view', 'id' => $device->getId()]);

            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    //edit
    public function editAction() {

        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }


        $device = $this->entityManager->getRepository(Device::class)
            ->find($id);

        if ($device == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Create device form
        $form = new DeviceForm('update', $this->entityManager, $device);

        //handle request
        $request = $this->getRequest();

        // Check if device has submitted the form
        if ($request->isPost()) {

            // Fill in the form with POST data
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $form->setData($data);

            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                // Update the device.
                $this->deviceManager->updateDevice($device, $data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('admin/manage-device',
                    ['action' => 'view', 'id' => $device->getId()]);

            }

        } else {
            $form->setData(array(
                'user_id' => ($device->getUser()) ? $device->getUser()->getId() : 0,
                'device_unique_id' => $device->getDeviceUniqueId(),
                'device_type_id' => $device->getType()->getId(),
                'status' => $device->getStatus(),
                'description' => $device->getDescription(),
            ));
        }

        return new ViewModel(array(
            'device' => $device,
            'form' => $form
        ));

    }

    //view
    public function viewAction() {

        $id = (int)$this->params()->fromRoute('id', -1);

        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find a device with such ID.
        $device = $this->entityManager->getRepository(Device::class)
            ->find($id);

        if ($device == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'device' => $device
        ]);

    }

    //remove
    public function removeAction() {

        $id = (int)$this->params()->fromRoute('id', -1);

        if ($id < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find a device with such ID.
        $device = $this->entityManager->getRepository(Device::class)
            ->find($id);

        if ($device == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            if ($request->getPost('remove_confirm')) {

                $this->entityManager->remove($device);
                $this->entityManager->flush();

                // Redirect to "main" page
                return $this->redirect()->toRoute('admin/manage-device',
                    ['action' => 'index']);

            }
        }

        return new ViewModel([
            'device' => $device
        ]);

    }

}