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

use Cocorico\CoreBundle\Entity\ListingListingCharacteristic;
use Cocorico\CoreBundle\Repository\ListingCharacteristicValueRepository;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListingListingCharacteristicType extends AbstractType implements TranslationContainerInterface
{
    protected $locale;

    protected $locales;

    /**
     * @param   $locale
     */
    public function __construct($locale, $locales = [])
    {
        $this->locales = $locales;
        $this->locale = $locale;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();

                //Translations fields
                $titles = array();
                foreach ($this->locales as $i => $locale) {
                    $titles[$locale] = array(
                        /** @Ignore */
                        'label' => "listing.form.title.$locale"
                    );
                }

                $form
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

                /** @var ListingListingCharacteristic $llc */
//                $llc = $event->getData();

//                $form->add(
//                    'listingCharacteristicValue',
//                    'entity',
//                    array(
//                        'query_builder' => function (ListingCharacteristicValueRepository $lcvr) use ($llc) {
//                            $lct = $llc->getListingCharacteristic()->getListingCharacteristicType();
//
//                            return $lcvr->getFindAllTranslatedQueryBuilder(
//                                $lct,
//                                $this->locale
//                            );
//                        },
//                        'empty_value' => 'listing.form.characteristic.choose',
//                        'property' => 'translations[' . $this->locale . '].name',
//                        'class' => 'Cocorico\CoreBundle\Entity\ListingCharacteristicValue',
//                    )
//                );
                $form->add('dish_visibility', 'checkbox', array(
                    'required'   => false,
                    'empty_data' => true,
                    'attr' => ['checked' => 'checked']
                ));
                $form->add('dish_photo', 'file', array(
                    'required'   => true,
                    'empty_data' => '',
                ));

            }
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Cocorico\CoreBundle\Entity\ListingListingCharacteristic',
                'translation_domain' => 'cocorico_listing'
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

    /**
     * JMS Translation messages
     *
     * @return array
     */
    public static function getTranslationMessages()
    {
        $messages[] = new Message("listing.form.title.en", 'cocorico_listing');
        $messages[] = new Message("listing.form.title.fr", 'cocorico_listing');
        $messages[] = new Message("listing_translations_en_title_placeholder", 'cocorico_listing');
        $messages[] = new Message("listing_translations_fr_title_placeholder", 'cocorico_listing');
        return $messages;
    }
}
