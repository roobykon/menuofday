<?php

/*
 * This file is part of the Cocorico package.
 *
 * (c) Cocolabs SAS <contact@cocolabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocorico\CoreBundle\Form\Type\Dashboard;

use Cocorico\CoreBundle\Entity\Listing;
use Cocorico\CoreBundle\Form\Type\ListingListingCharacteristicType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * ListingEditCharacteristicType
 */
class ListingEditCharacteristicType extends ListingEditType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'listingListingCharacteristicsOrderedByGroup',
                'collection',
                array(
                    'type' => new ListingListingCharacteristicType($this->locale, $this->locales, $this->em),
                    /** @Ignore */
                    'label' => false,
                    'prototype' => true,
                    'by_reference' => false,
                    'allow_delete' => true,
                    'allow_add' => true,
                    'cascade_validation' => true,
                    'allow_extra_fields' => true,
                    'mapped' => true,
                    'max_length' =>  10
                )
            );



        //Add new ListingCharacteristics eventually not already attached to listing
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var Listing $listing */
                $listing = $event->getData();
                $form = $event->getForm();
                $listing = $this->lem->refreshListingListingCharacteristics($listing);
                $event->setData($listing);
            }
        );
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(
            array(
                'data_class' => 'Cocorico\CoreBundle\Entity\Listing',
                'translation_domain' => 'cocorico_listing',
                'cascade_validation' => true,//To have error on collection item field
            )
        );
    }

    /**
     * BC
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'listing_edit_characteristic';
    }
}
