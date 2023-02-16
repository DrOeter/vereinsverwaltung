<?php

namespace App\Form;

use App\Entity\Sepa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SepaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('iban')
            ->add('bic')
            ->add('beneficiaryName')
            ->add('purposeOfThePayment')
            ->add('amount')
            ->add('currency')
            ->add('orderDate')
            ->add('mandateReference')
            ->add('creditorId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sepa::class,
        ]);
    }
}
