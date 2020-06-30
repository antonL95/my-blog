<?php

    namespace App\Controller;

    use App\Entity\Article;
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
         *     "/{_locale}/",
         *     name="blog_index",
         *     host="blog.antonloginov.local",
         * )
         * @Route(
         *     "/",
         *     name="blog_index2",
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
            $articles = $entityManager->getRepository(Article::class)->findBy([], ['date_add'=>'asc'], 10, 0);
            return $this->render(
                'blog/index.html.twig',
                [
                    'articles' => $articles,
                    'controller_name' => 'BlogController',
                ]
            );
        }

        /**
         * @Route(
         *     "/{_locale}/article/{id}",
         *     name="article_page",
         *     host="blog.antonloginov.local",
         * )
         * @Route(
         *     "/article/{id}",
         *     name="article_page2",
         *     host="blog.antonloginov.local",
         * )
         * @param int                    $id
         * @param Request                $request
         * @param TranslatorInterface    $translator
         * @param EntityManagerInterface $entityManager
         *
         * @return Response
         */
        public function articleAction(int $id, Request $request, TranslatorInterface $translator, EntityManagerInterface $entityManager): Response
        {
            $article = $entityManager->getRepository(Article::class)->findOneBy(['id'=>$id], null, 10, 0);
            return $this->render(
                'blog/article.html.twig',
                [
                    'article' => $article,
                    'controller_name' => 'BlogController',
                ]
            );
        }
    }
