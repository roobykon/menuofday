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

use Cocorico\CoreBundle\Model\BaseListingListingCharacteristic;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * ListingListingCharacteristic
 *
 * @ORM\Entity()
 *
 * @ORM\Table(name="listing_listing_characteristic")
 *
 */
class ListingListingCharacteristic extends BaseListingListingCharacteristic
{
    use ORMBehaviors\Translatable\Translatable;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Listing", inversedBy="listingListingCharacteristics")
     * @ORM\JoinColumn(name="listing_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $listing;

    /**
     * @ORM\ManyToOne(targetEntity="Cocorico\CoreBundle\Entity\ListingCharacteristic", inversedBy="listingListingCharacteristics", fetch="EAGER")
     * @ORM\JoinColumn(name="listing_characteristic_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $listingCharacteristic;

    /**
     * @ORM\ManyToOne(targetEntity="Cocorico\CoreBundle\Entity\ListingCharacteristicValue", inversedBy="listingListingCharacteristics", fetch="EAGER")
     * @ORM\JoinColumn(name="listing_characteristic_value_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $listingCharacteristicValue;

    /**
     * @ORM\ManyToOne(targetEntity="Cocorico\CoreBundle\Entity\ListingCharacteristicGroup", inversedBy="listingListingCharacteristics", fetch="EAGER")
     * @Assert\NotBlank(message="assert.not_blank")
     * @ORM\JoinColumn(name="listing_listing_characteristic_group_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $listingCharacteristicGroup;


    /**
     * @var boolean
     *
     * @ORM\Column(name="dish_visibility", type="boolean", nullable=false, options={"default": true})
     */
    private $dish_visibility;
    /**
     * @var string
     * @ORM\Column(name="dish_photo", type="string", nullable=true)
     */
    private $dish_photo;

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
     * Set listing
     *
     * @param  \Cocorico\CoreBundle\Entity\Listing $listing
     * @return ListingListingCharacteristic
     */
    public function setListing(Listing $listing = null)
    {
        $this->listing = $listing;

        return $this;
    }

    /**
     * Get listing
     *
     * @return \Cocorico\CoreBundle\Entity\Listing
     */
    public function getListing()
    {
        return $this->listing;
    }

    /**
     * @return ListingCharacteristic
     */
    public function getListingCharacteristic()
    {
        return $this->listingCharacteristic;
    }

    /**
     * @param ListingCharacteristic $listingCharacteristic
     */
    public function setListingCharacteristic(ListingCharacteristic $listingCharacteristic)
    {
        $this->listingCharacteristic = $listingCharacteristic;
    }

    /**
     * @return ListingCharacteristicValue
     */
    public function getListingCharacteristicValue()
    {
        return $this->listingCharacteristicValue;
    }

    /**
     * @param ListingCharacteristicValue $listingCharacteristicValue
     */
    public function setListingCharacteristicValue(ListingCharacteristicValue $listingCharacteristicValue = null)
    {
        $this->listingCharacteristicValue = $listingCharacteristicValue;
    }

    /**
     * Set ListingCharacteristicGroup
     *
     * @param  \Cocorico\CoreBundle\Entity\ListingCharacteristicGroup $listingCharacteristicGroup
     * @return ListingCharacteristic
     */
    public function setListingCharacteristicGroup(ListingCharacteristicGroup $listingCharacteristicGroup)
    {
        $this->listingCharacteristicGroup = $listingCharacteristicGroup;

        return $this;
    }

    /**
     * Get ListingCharacteristicGroup
     *
     * @return \Cocorico\CoreBundle\Entity\ListingCharacteristicGroup
     */
    public function getListingCharacteristicGroup()
    {
        return $this->listingCharacteristicGroup;
    }

    public function getTitle()
    {
        return $this->translate()->getTitle();
    }

    public function getDishVisibility()
    {
        return $this->dish_visibility;
    }

    public function setDishVisibility($dish_visibility)
    {
        $this->dish_visibility = $dish_visibility;
        return $this;
    }

    public function getDishPhoto()
    {
        return $this->dish_photo ?  $this->dish_photo : '/images/img9.png';
    }
    
    public function setDishPhoto($dish_photo)
    {
        if($dish_photo !== null) $this->dish_photo = $dish_photo;
        return $this;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getListingCharacteristic()->getName();
    }

    public function __clone()
    {
        if ($this->id) {
            $this->id = null;
        }
    }
}
