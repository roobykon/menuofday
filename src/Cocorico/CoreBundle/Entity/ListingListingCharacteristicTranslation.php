<?php

/*
 * This file is part of the Cocorico package.
 *
 * (c) Cocolabs SAS <contact@cocolabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocorico\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ListingListingCharacteristicTranslation
 *
 * @ORM\Entity
 *
 * @ORM\Table(name="listing_listing_characteristic_translation")
 */
class ListingListingCharacteristicTranslation
{
    use ORMBehaviors\Translatable\Translation;


    /**
     * @Assert\NotBlank(message="assert.not_blank")
     *
     * @ORM\Column(type="string", length=255, name="title", nullable=false)
     *
     * @var string $title
     */
    protected $title;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets title.
     *
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

}
