<?php

namespace AppBundle\Form;

use AppBundle\Entity\AddressBook;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AddressBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Firstname',         null ,  [ 'attr' => array( 'class' => 'form-control') ])
            ->add('Lastname',          null ,  [ 'attr' => array( 'class' => 'form-control') ])
            ->add('Street_and_number', null ,  [ 'attr' => array( 'class' => 'form-control') ])
            ->add('Zip',               null ,  [ 'attr' => array( 'class' => 'form-control') ])
            ->add('City',              null ,  [ 'attr' => array( 'class' => 'form-control') ])
            ->add('Country',           null ,  [ 'attr' => array( 'class' => 'form-control') ])
            ->add('Phonenumber',       null ,  [ 'attr' => array( 'class' => 'form-control') ])
            ->add('Birthday', DateType::class, [ 'widget' => 'single_text', 'attr' => array( 'class' => 'form-control') ])
            ->add('Email_address',     null ,  [ 'attr' => array( 'class' => 'form-control') ])
            ->add('Picture', FileType::class,  [ 'data_class' => null, 'required' => false, 'label' => 'Profile img (jpg, png, gif file)' ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AddressBook::class,
            'attr' => array(
                'class' => 'form-group'
            ),
        ]);
    }
}