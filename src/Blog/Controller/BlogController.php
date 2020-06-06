<?php

namespace App\Blog\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    //ToDo: change route to blog.antonloginov.com
    /**
     * @Route(
     *     "/",
     *     name="_blog",
     *     host="blog.antonloginov.local",
     * )
     */
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
}
