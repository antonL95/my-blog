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
        public function showIndex(Request $request, MailerInterface $mailer): Response
        {
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
                    'our_form' => $form->createView()
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
