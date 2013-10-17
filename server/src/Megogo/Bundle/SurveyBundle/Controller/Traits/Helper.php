<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ghost_cfg
 * Date: 10/17/13
 * Time: 12:23 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Megogo\Bundle\SurveyBundle\Controller\Traits;


use Megogo\Bundle\PersistenceBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\JsonResponse;

trait Helper {
    protected function processForm(AbstractType $formType, User $user, array $options = null ){
        $form = $this->createForm($formType,$user);

        $request = $options['request'];
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest()){
            //var_dump ($form->getData());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($user);
                $em->flush();
                //var_dump($request->getSession());
                $request->getSession()->set('id',$user->getId());

                return JsonResponse::create([
                    'status' => 'ok',
                    'redirect' => $options['redirect']
                ]);
            }

            return JsonResponse::create([
                'status' => 'error',
                'errors' => $this->getPlainErrors($form)
            ]);
        }

        return ['form' => $form->createView()];
    }
    //Symfony\Component\Form\FormInterface
    protected function getPlainErrors( $form){
        $list = [];
        foreach($form->getErrors() as $error){
            $list [] = $error->getMessage();
        }
        return $list;
    }

}