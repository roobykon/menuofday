<?php
/**
 * Created by IntelliJ IDEA.
 * User: tema_on
 * Date: 24.07.17
 * Time: 18:36
 */

namespace Cocorico\CoreBundle\Listener;

use Cocorico\CoreBundle\Model\Manager\CharacteristicImageManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Cocorico\CoreBundle\Entity\ListingListingCharacteristic;


class CharacteristicImageUploadListener
{
    private $uploader;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(CharacteristicImageManager $uploader)
    {
        $this->uploader = $uploader;
//        $this->em = $em;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->em = $args->getEntityManager();
        $this->uploadFile($entity);

    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->em = $args->getEntityManager();
        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof ListingListingCharacteristic) {
            return;
        }

        $file = $entity->getDishPhoto();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setDishPhoto($fileName);
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof ListingListingCharacteristic) {
            return;
        }

        if ($fileName = $entity->getDishPhoto()) {
            $entity->setDishPhoto(new File($this->uploader->getTargetDir().'/'.$fileName));
        }
    }

}