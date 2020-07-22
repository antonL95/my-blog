<?php

    namespace App\Controller;

    use App\Entity\Article;
    use Doctrine\ORM\EntityManagerInterface;
    use Knp\Component\Pager\PaginatorInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Contracts\Translation\TranslatorInterface;

    class BlogController extends AbstractController
    {
        const LIMIT = 10;

        /**
         * @Route("/{_locale}/blog/", name="blog_index_localized")
         * @Route("/blog/", name="blog_index")
         * @param Request                $request
         * @param TranslatorInterface    $translator
         * @param EntityManagerInterface $entityManager
         *
         * @return Response
         */
        public function index(Request $request, TranslatorInterface $translator, EntityManagerInterface $entityManager): Response
        {
            $pages = [
                ['path' => $this->generateUrl('home_localized').'#ref', 'title' => $translator->trans('References')],
                ['path' => $this->generateUrl('home_localized').'#con', 'title' => $translator->trans('Contact')],
                ['path' => $this->generateUrl('blog_index_localized'), 'title' => $translator->trans('Blog')],
            ];
            $articles = $entityManager->getRepository(Article::class)->findBy(['active' => 1], ['date_add' => 'asc'], 10, 0);
            $meta = [
                'title' => 'Anton Loginov Blog - web developer',
                'description' => 'I believe that everyone deserves a chance to start their own business and I want to help you to achieve that goal by creating 
                a beautiful, fast and most importantly reliable web application specifically designed for your business idea. Write me a message and let\'s get it going.',
                'hostname' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'],
            ];

            return $this->render(
                'blog/index.html.twig',
                [
                    'articles' => $articles,
                    'controller_name' => 'BlogController',
                    'meta' => $meta,
                    'articlesCount' => $entityManager->getRepository(Article::class)->getCountAllActive(),
                    'pages' => $pages,
                ]
            );
        }

        /**
         * @Route("/{_locale}/blog/article/{id}", name="article_page_localized")
         * @Route("/blog/article/{id}", name="article_page")
         * @param int                    $id
         * @param Request                $request
         * @param TranslatorInterface    $translator
         * @param EntityManagerInterface $entityManager
         *
         * @return Response
         */
        public function articleAction(int $id, Request $request, TranslatorInterface $translator, EntityManagerInterface $entityManager): Response
        {
            $pages = [
                ['path' => $this->generateUrl('home_localized').'#ref', 'title' => $translator->trans('References')],
                ['path' => $this->generateUrl('home_localized').'#con', 'title' => $translator->trans('Contact')],
                ['path' => $this->generateUrl('blog_index_localized'), 'title' => $translator->trans('Blog')],
            ];
            $article = $entityManager->getRepository(Article::class)->findOneBy(['id' => $id, 'active' => 1]);

            $meta = [];
            if(isset($article) && $article !== null) {
                $meta = [
                    'title' => $article->getTitle() . ' - ' .'Anton Loginov Blog - web developer',
                    'description' => substr(str_replace('&nbsp;', ' ', strip_tags($article->getArticleText())), 0, 250),
                    'hostname' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'],
                ];
            }

            return $this->render(
                'blog/article.html.twig',
                [
                    'article' => $article,
                    'controller_name' => 'BlogController',
                    'meta' => $meta,
                    'pages' => $pages,
                ]
            );
        }

        /**
         * @Route("/{_locale}/blog/articles/", name="blog_articles_localized")
         * @Route("/blog/articles/", name="blog_articles")
         * @param Request                $request
         * @param TranslatorInterface    $translator
         * @param EntityManagerInterface $entityManager
         * @param PaginatorInterface     $paginator
         *
         * @return Response
         */
        public function listAction(
            Request $request,
            TranslatorInterface $translator,
            EntityManagerInterface $entityManager,
            PaginatorInterface $paginator
        ): Response {
            $pages = [
                ['path' => $this->generateUrl('home_localized').'#ref', 'title' => $translator->trans('References')],
                ['path' => $this->generateUrl('home_localized').'#con', 'title' => $translator->trans('Contact')],
                ['path' => $this->generateUrl('blog_index_localized'), 'title' => $translator->trans('Blog')],
            ];
            $articles = $entityManager->getRepository(Article::class)->getQueryAllActive();
            $pagination = $paginator->paginate($articles, $request->get('page', 1), self::LIMIT);
            $meta = [
                'title' => 'Anton Loginov Blog - web developer',
                'description' => 'I believe that everyone deserves a chance to start their own business and I want to help you to achieve that goal by creating 
                a beautiful, fast and most importantly reliable web application specifically designed for your business idea. Write me a message and let\'s get it going.',
                'hostname' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'],
            ];

            return $this->render(
                'blog/articles.html.twig',
                [
                    'pagination' => $pagination,
                    'controller_name' => 'BlogController',
                    'meta' => $meta,
                    'pages' => $pages,
                ]
            );
        }
    }
