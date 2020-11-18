<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        $data = ['name' => 'Floran', 'school' => 'Ynov'];
        return $this->render('product/index.html.twig', [
            'data' => $data
        ]);
    }

    /**
     * @Route("/product/{id}", name="product_id")
     * @param $id
     * @return Response
     */
    public function id($id): Response {
        //on récupère l'id en paramètre de notre méthode grâce à l'autowiring
        return $this->render('product/detail.html.twig', ['id' => $id]);
    }

    /**
     * @Route("/redirect", name="redirect_route")
     * @return RedirectResponse
     */
    public function generateRoute() {
        return $this->redirectToRoute('product_id', ['id' => 10]);
    }

    /**
     * @Route("/autowiring", name="autowiring")
     * @param LoggerInterface $logger
     * @return Response
     */
    public function autowiring(LoggerInterface $logger) :Response {
        $logger->info('Logging some stuff');
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/error", name="error")
     */
    public function errorController() {
        throw $this->createNotFoundException('Product not found');
    }

    /**
     * @Route("/params", name="params")
     * @param Request $request
     * @param SessionInterface $session
     * @return Response
     */
    public function parameters(Request $request, SessionInterface $session) {
        //GET Variables
        //$param = $request->query->get('page');
        //Post Variables
        //$param = $request->request->get('page');
        //var_dump($param);

        //Get the raw body
        //$body = json_decode($request->getContent());
        //var_dump($body->page);

        //Get a file
        $file = $request->files->get('file');
        var_dump($file);

        //get Headers
        //$host = $request->headers->get('host');
        //var_dump($host);

        //get cookie
        //$request->cookies->get('test');

        //get session variable
        //$session->get('test');

        //set session variable
        //$session->set('test', 'test');

        return $this->render('base.html.twig');
    }


    /**
     * @Route("/response", name="response")
     * @return Response
     */
    public function response() {
        $response = new Response('<p>Hello</p>');
        $response->headers->set('Content-type', 'text/html');
        return $response;
    }

    /**
     * @Route("/flash", name="flash")
     */
    public function flash() {
        $this->addFlash(
            'notice',
            'Your changes were saved!'
        );

        return $this->render('base.html.twig');
    }

    /**
     * @Route("/twig", name="twig")
     * @return Response
     */
    public function twig() {
        return $this->render('product/learntwig.html.twig');
    }

    /**
     * @Route("/twig/test", name="twig_test")
     * @return Response
     */
    public function testTwig() {
        return $this->render('product/test.html.twig');
    }
}
