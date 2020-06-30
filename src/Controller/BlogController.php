<?php

    namespace App\Controller;

    use App\Entity\Article;
    use Doctrine\ORM\EntityManager;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Contracts\Translation\TranslatorInterface;

    class BlogController extends AbstractController
    {
        //ToDo: change route to blog.antonloginov.com
        /**
         * @Route(
         *     "/",
         *     name="blog_index",
         *     host="blog.antonloginov.local",
         * )
         * @param Request             $request
         * @param TranslatorInterface $translator
         * @param EntityManagerInterface       $entityManager
         *
         * @return Response
         */
        public function index(Request $request, TranslatorInterface $translator, EntityManagerInterface $entityManager): Response
        {
            $articles = $entityManager->getRepository(Article::class)->findBy([], null, 10, 0);
            return $this->render(
                'blog/index.html.twig',
                [
                    'articles' => $articles,
                    'controller_name' => 'BlogController',
                ]
            );
        }


    }
