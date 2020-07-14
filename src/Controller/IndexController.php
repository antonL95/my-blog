<?php

    namespace App\Controller;

    use App\Form\ContactType;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
    use Symfony\Component\Mailer\MailerInterface;
    use Symfony\Component\Mime\Email;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Mime\Address;
    use Symfony\Contracts\Translation\TranslatorInterface;

    class IndexController extends AbstractController
    {
        /**
         * @Route("/",name="home")
         * @Route("/{_locale}/",name="home_localized")
         * @param Request         $request
         * @param MailerInterface $mailer
         *
         * @return Response
         */
        public function showIndex(Request $request, MailerInterface $mailer, TranslatorInterface $translator): Response
        {
            $meta = [
                'title' => 'Anton Loginov - web developer',
                'description' => 'I believe that everyone deserves a chance to start their own business and I want to help you to achieve that goal by creating 
                a beautiful, fast and most importantly reliable web application specifically designed for your business idea. Write me a message and let\'s get it going.',
                'hostname' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'],
            ];
            $works = [
                [
                    'title' => 'Artist\'s Hero',
                    'img' => 'artistshero.png',
                    'description' => substr($translator->trans('Unique art for unique businesses.', [], 'messages'), 0, 50)
                ],
                [
                    'title' => 'Effectively.cz',
                    'img' => 'effectively.png',
                    'description' => substr($translator->trans('Productivity analysis app.', [], 'messages'), 0, 50)
                ],
            ];
            $form = $this->createForm(ContactType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $message = (new Email())
                    ->from(new Address('anton@antonloginov.com', 'Anton Loginov'))
                    ->to(['anton@antonloginov.com'])
                    ->subject($form->getData()['subject'])
                    ->text($form->getData()['message'] . PHP_EOL . 'Reply-email: ' . $form->getData()['email'])
                    ->replyTo($form->getData()['email']);

                try {
                    if ($mailer->send($message)) {
                        return new JsonResponse(['success' => 1]);
                    }
                } catch (TransportExceptionInterface $e) {
                    return new JsonResponse(['error' => 1]);
                }

                return new JsonResponse(['error' => 1]);
            }

            return $this->render(
                'home/index.html.twig',
                [
                    'our_form' => $form->createView(),
                    'meta' => $meta,
                    'works' => $works,
                ]
            );
        }

        /**
         * @Route("/contact-form", name="contact_form")
         * @Route("/{_locale}/contact-form",name="contact_form_localized")
         * @param Request $request
         *
         * @return JsonResponse
         */
        public function contactForm(Request $request)
        {
            return new JsonResponse(['success' => 1]);
        }
    }
