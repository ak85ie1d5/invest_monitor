<?php

namespace App\Form;

use App\Entity\ArticleArchive;
use App\Entity\Product;
use App\Entity\Wallet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WalletRowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantityPurchased')
            ->add('purchasePrice')
            ->add('sellingPrice')
            ->add('quantitySold')
            ->add('dateOfPurchase')
            ->add('dateOfSale')
            ->add('Article', EntityType::class, [
                'class' => ArticleArchive::class,
                'choice_label' => 'title',
            ])
            ->add('Product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
            ])
            ->add('submit', SubmitType::class, [])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wallet::class,
        ]);
    }
}
