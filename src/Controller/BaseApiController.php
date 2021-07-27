<?php
namespace App\Controller;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class BaseApiController extends AbstractFOSRestController
{
    /**
     * @param $element
     * @param $id
     * @param $elementClass
     * @param $errors
     * @return mixed
     */
    protected function saveElement($element, $id, $elementClass, &$errors)
    {
        if ($id && $this->elementExist($id, $elementClass)) {
            $errors[] = 'Exception saving element of class ' . $elementClass . '. Element with id: '. $id . ' already exists in DB';
            return $this->getDoctrine()->getRepository($elementClass)->find($id);
        }

        try {
            $this->getDoctrine()->getManager()->persist($element);
            $this->getDoctrine()->getManager()->flush();
        } catch (\Exception $exception) {
            $this->getDoctrine()->resetManager();
            $errors[] = 'Exception saving element of class ' . $elementClass . '. Error message: '. $exception->getMessage();
        }
        return $element;
    }

    /**
     * @param $id
     * @param $elementClass
     * @return mixed
     */
    protected function elementExist($id, $elementClass)
    {
        return !empty($this->getDoctrine()->getRepository($elementClass)->find($id));
    }
}