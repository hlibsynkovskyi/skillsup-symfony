<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 22.08.2017
 * Time: 20:06
 */

namespace AppBundle\Form;

use AppBundle\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{

public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('firstname')
        ->add('lastname')
        ->add('phone')
        ->add('email', EmailType::class)
        ->add('settlment', ChoiceType::class, ['attr'=>['style'=>'width:200px']])
        ->add('warehouse', ChoiceType::class)
        ;


}

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults(array(
           'data_class'=>Order::class,
       ));
    }


}