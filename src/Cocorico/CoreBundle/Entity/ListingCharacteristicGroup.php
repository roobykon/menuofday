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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ListingCharacteristicGroup
 *
 * @ORM\Entity()
 * @UniqueEntity("position", message="assert.unique")
 * @ORM\Table(name="listing_characteristic_group", indexes={
 *    @ORM\Index(name="position_lcg_idx", columns={"position"})
 *  })
 *
 */
class ListingCharacteristicGroup
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
     * @var int
     *
     * @Assert\NotBlank(message="assert.not_blank")
     *
     * @ORM\Column(name="position", type="smallint", nullable=false, unique=true)
     */
    private $position;

    /**
     *
     * @ORM\OneToMany(targetEntity="ListingCharacteristic", mappedBy="listingCharacteristicGroup", cascade={"persist", "remove"})
     * @ORM\OrderBy({"position" = "asc"})
     */
    private $listingCharacteristics;

    /**
     *
     * @ORM\OneToMany(targetEntity="ListingListingCharacteristic", mappedBy="listingCharacteristicGroup", cascade={"persist", "remove"})
     * @ORM\OrderBy({"position" = "asc"})
     */
    private $listingListingCharacteristics;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->listingListingCharacteristics = new ArrayCollection();
    }

    /**
     * Translation proxy
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

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
     * Set position
     *
     * @param  boolean $position
     * @return ListingImage
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return boolean
     */
    public function getPosition()
    {
        return $this->position;
    }


    /**
     * Add listingListingCharacteristics
     *
     * @param  \Cocorico\CoreBundle\Entity\ListingListingCharacteristic $listingListingCharacteristics
     * @return ListingCharacteristicGroup
     */
    public function addListingListingCharacteristic(ListingListingCharacteristic $listingListingCharacteristics)
    {
        $this->listingListingCharacteristics[] = $listingListingCharacteristics;

        return $this;
    }

    /**
     * Remove listingListingCharacteristics
     *
     * @param \Cocorico\CoreBundle\Entity\ListingListingCharacteristic $listingListingCharacteristics
     */
    public function removeListingListingCharacteristic(ListingListingCharacteristic $listingListingCharacteristics)
    {
        $this->listingListingCharacteristics->removeElement($listingListingCharacteristics);
    }

    /**
     * Get listingListingCharacteristics
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListingListingCharacteristics()
    {
        return $this->listingListingCharacteristics;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->translate()->getName();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->translate()->getName();
    }
}
