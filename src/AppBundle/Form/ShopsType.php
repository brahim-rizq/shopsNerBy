<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;

class ShopsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',TextType::class,['label'=>'Shop Name','translation_domain'=> false,'attr' =>['placeholder' => 'Shop Name']])
                ->add('lat',NumberType::class,['label'=>'Latitude','translation_domain'=> false,'attr' =>['placeholder' => 'Latitude']])
                ->add('lang',NumberType::class,['label'=>'Longitude','translation_domain'=> false,'attr' =>['placeholder' => 'Longitude']])
                ->add('address',TextareaType::class,['label'=>'Address','translation_domain'=> false,'attr' =>['placeholder' => 'Shop Address']])
                ->add('city',TextType::class,['label'=>'Shop City','translation_domain'=> false,'attr' =>['placeholder' => 'Shop City']])
                ->add('status',CheckboxType::class,['label'=>'Active','translation_domain'=> false])
                ->add('imagefile',FileType::class,['label'=>'Shop Photos','translation_domain'=> false,'data_class' => null])
                ->add('category',EntityType::class,['class' => Category::class,'translation_domain'=> false,/*'expanded' => true,'multiple' => true,*/'choice_label' => 'name',
                 'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.createdAt', 'ASC');
                }])
                ->add('description',TextareaType::class,['translation_domain'=> false,'translation_domain'=> false,'attr' =>['placeholder' => 'Descriptions','class' => 'sizeNone','rows'=>5]]);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Shops'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_shops';
    }


}
