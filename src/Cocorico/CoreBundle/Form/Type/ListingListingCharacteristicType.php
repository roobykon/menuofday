<?php

/*
 * This file is part of the Cocorico package.
 *
 * (c) Cocolabs SAS <contact@cocolabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocorico\CoreBundle\Form\Type;

use Cocorico\CoreBundle\Repository\ListingCharacteristicGroupRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListingListingCharacteristicType extends AbstractType
{
    protected $locale;

    protected $locales;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param   $locale
     */
    public function __construct($locale, $locales = [], EntityManager $entityManager)
    {
        $this->locales = $locales;
        $this->locale = $locale;
        $this->em = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $titles = array();
        foreach ($this->locales as $i => $locale) {
            $titles[$locale] = array(
                /** @Ignore */
                'label' => "listing.form.title.$locale"
            );
        }

        $builder
            ->add(
                'translations',
                'a2lix_translations',
                array(
                    'required_locales' => array($this->locale),
                    'fields' => array(
                        'title' => array(
                            'field_type' => 'text',
                            'required'   => true,
                            'locale_options' => $titles
                        )
                    ),
                    /** @Ignore */
                    'label' => false
                )
            );

        /** @var ListingCharacteristicGroupRepository $characteristicsGroupRepository */
        $characteristicsGroupRepository = $this->em->getRepository(
            "CocoricoCoreBundle:ListingCharacteristicGroup"
        );

        $builder->add(
            'listingCharacteristicGroup',
            'entity',
            array(
                'required' => false,
                /** @Ignore */
                'choices' => $characteristicsGroupRepository->findAllTranslated($this->locale),
                'class' => 'CocoricoCoreBundle:ListingCharacteristicGroup',
                'cascade_validation' => true
            )
        );


//        $builder->add('dish_photo', 'file',
//            array(
////                'data' => $builder->getData()->getPhotoAsFile(),
//                'required'   => true,
//                "data_class" => null
//            )
//        );

//        Add new ListingCharacteristics eventually not already attached to listing
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var Listing $listing */
                $characteristic = $event->getData();
                $form = $event->getForm();
                $params = array(
                    'required'   => true,
                    "data_class" => null
                );
                if($characteristic){
                    $params = array_merge($params, ['data' => $characteristic->getDishPhoto()]);
                }

                $form->add('dish_visibility', 'checkbox', array(
                    'required'   => false,
                    'attr' => !empty($characteristic) && $characteristic->getDishVisibility() ? ['checked' => 'checked'] : [],
                    'data' => !empty($characteristic) ? $characteristic->getDishVisibility() : false
                ));

                $form->add('dish_photo', 'file', $params);
            }
        );

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(
            array(
                'data_class' => 'Cocorico\CoreBundle\Entity\ListingListingCharacteristic',
                'translation_domain' => 'cocorico_listing',
                'cascade_validation' => true,
                'allow_delete' => true
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
        return 'listing_listing_characteristic';
    }
}
