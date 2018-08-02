<?php
/**
 * Created by PhpStorm.
 * User: KRÓL ŻYCIA
 * Date: 28.07.2018
 * Time: 16:44
 */

namespace App\Form;


use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteShareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', TextType::class, array(
                'attr' => array('maxlength' => 30)
            ))
            ->add('save', ButtonType::class, array(
                'label' => 'Share',
                'attr' => array('class' => 'share-submit')
            ))
        ->add('id', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Note::class,
        ));
    }
}
