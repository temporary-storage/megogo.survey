<?php

namespace Megogo\Bundle\SurveyBundle\Controller;

use Megogo\Bundle\SurveyBundle\Form\Type\AdditionalDataType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\AbstractType;
use Megogo\Bundle\SurveyBundle\Form\Type\RegistrationType;
use Megogo\Bundle\PersistenceBundle\Entity\User;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    use Traits\Helper;
    /**
     * @Route("/", name="step1")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $response = new Response();
        // clearing forms binding with entity and client counter
        if ($session->has('id')){
            $session->remove('id');
            $response = new RedirectResponse($this->get('router')->generate('step1'));
            $response->headers->clearCookie('counter');
            $response->headers->clearCookie('counterPause');
            return $response;
        }

        return $this->processForm(
            new RegistrationType(),
            new User(),
            [
                'redirect' => $this->get('router')->generate('step2', [], true),
                'request'  => $request
            ]
        );
    }

    /**
     * @Route("/step2/", name="step2")
     * @Template()
     */
    public function additionalDataAction(Request $request){
        $session = $request->getSession();
        if (!$session->has('id') || $request->cookies->has('counterPause')){
            return $request->isXmlHttpRequest() ?
                new JsonResponse(['status' => 'error', 'errors' => 'you have not passed step 1']):
                new RedirectResponse($this->generateUrl('step1'));
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('MegogoPersistenceBundle:User')->findOneById($session->get('id'));
        if (!$user) {
            return $request->isXmlHttpRequest() ?
                new JsonResponse(['status' => 'error', 'errors' => 'no such user in db']):
                new RedirectResponse($this->generateUrl('step1'));
        }

        return $this->processForm(
            new AdditionalDataType(),
            $user,
            [
                'redirect' => $this->get('router')->generate('step3', [], true),
                'request'  => $request
            ]
        );
    }

    /**
     * @Route("/step3/", name="step3")
     * @Template()
     */
    public function finishAction(Request $request){

        $session = $request->getSession();
        $html = file_get_contents('http://www.gifbin.com/random');
//
        if(!$session->has('id') || !$html || $request->cookies->has('counterPause')){
            return new RedirectResponse($this->get('router')->generate('step1'));
        }

        $src = (new Crawler($html))
                        ->filter('#gif')->attr('src');
        $content = $this->renderView(
            'MegogoSurveyBundle:Main:finish.html.twig',
            ['src' => $src]
        );
        $response = (new Response())->setContent($content);
        // important last arg httponly = false
        $response->headers->setCookie(new Cookie('counterPause',true , 0, '/', null, false, false));
        return $response;
    }


}
