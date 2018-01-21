<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class UserinfoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('genre', ChoiceType::class,[
            'choices'  => array(
                'Male' => 'Male',
                'Female' => 'Female',
                'Not Specified' => 'Not Specified',
            ),'translation_domain'=> false])
                ->add('cin', TextType::class)
                ->add('birthday', BirthdayType::class,['widget' => 'choice','format' => 'yyyy-MMMM-dd'])
                ->add('phone',TextType::class,['label'=>'Phone','translation_domain'=> false,'attr' =>['placeholder' => 'Phone number']])
                 // ->add('city',TextType::class,['label'=>'City','translation_domain'=> false,'attr' =>['placeholder' => 'City Currently live in']])
                 // ->add('adresse',TextareaType::class,['label'=>'Address','translation_domain'=> false,'attr' =>['placeholder' => 'Correct Address','class'=>'sizeNone','rows' => 5]])
                ->add('file',FileType::class,['label'=>'Profile Picture','data_class' => null]);
                // ->add('lat',NumberType::class,['label'=>'Latitude','translation_domain'=> false,'attr' =>['placeholder' => 'Latitude']])
                // ->add('lang',NumberType::class,['label'=>'Longitude','translation_domain'=> false,'attr' =>['placeholder' => 'Longitude']]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Userinfo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_userinfo';
    }


}
