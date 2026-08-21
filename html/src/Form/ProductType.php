<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('productType')
            ->add('productDirection')
            ->add('Isin')
            ->add('StopLossLevel')
            ->add('stopLossCurrency')
            ->add('endDate')
            ->add('leverage')
            ->add('underlyingName')
            ->add('underlyingIsin')
            ->add('submit', SubmitType::class)
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['form_title'] = $options['form_title'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'form_title' => 'Add new product',
        ]);
        $resolver->setAllowedTypes('form_title', ['string', 'null']);
    }
}
