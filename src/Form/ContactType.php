<?php

    namespace App\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\EmailType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class ContactType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
                ->add('name', TextType::class, ['label' => 'Your Name'])
                ->add('email', EmailType::class, ['label' => 'Your Email'])
                ->add('subject', TextType::class, ['label' => 'Subject'])
                ->add('message', TextareaType::class, ['label' => 'Your Message']);
        }

        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                // Configure your form options here
            ]);
        }
    }
