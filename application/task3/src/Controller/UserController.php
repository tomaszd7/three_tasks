<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * @Route("/users", methods={"GET"})
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function listAction(EntityManagerInterface $entityManager) {
        $users = $entityManager->getRepository(User::class)->findAll();
        return new JsonResponse($users);
    }

    /**
     * @Route("/users", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addAction(Request $request) {

        try {
            $data = json_decode($request->getContent(), true);
            $userForm = $this->createForm(UserForm::class);
            $userForm->submit($data);
            // todo we have error here when pulling properties form empty user

            if ($userForm->isSubmitted() && $userForm->isValid()) {
                return new JsonResponse('GOOD');
            } else {
//                $errors = array_reduce((array)$userForm->getErrors(), function(FormError $iterable){
//                    return $iterable->getMessage();
//                }, "");
                throw new \Exception(implode(",", $userForm->getErrors()));
            }


        } catch (\Exception $exception) {
            // todo this is not nice as shows too much and should be mapped to error list we want to show
            $errors[get_class($exception)] = $exception->getMessage();
            return new JsonResponse($this->prepareErrorMessage($errors));
        }

        return new JsonResponse($userForm->getData());
    }

    /**
     *
     * @param array $errors
     * @return array
     */
    protected function prepareErrorMessage(array $errors) {
        $message = [];
        $message["code"] = 422;
        $message["message"] = "Validation Failed";
        $message["errors"] = $errors;
        return $message;
    }
}