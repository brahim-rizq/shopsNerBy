<?php 
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use AppBundle\Form\UserinfoType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProfileType extends AbstractType
{

 
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Userinfo' , UserinfoType::class,['label' => false,'translation_domain'=> false])
                ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    // public function setDefaultOptions(OptionsResolverInterface $resolver)
    // {
    //     $resolver->setDefaults(array(
    //         'data_class' => 'AppBundle\Entity\User_info',
    //         'cascade_validation' => true
    //     ));
    // }

    public function getBlockPrefix()
    {
        return 'app_user_profile_edit';
    }



}