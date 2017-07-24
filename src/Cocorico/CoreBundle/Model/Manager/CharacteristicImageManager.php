<?php
/**
 * Created by IntelliJ IDEA.
 * User: tema_on
 * Date: 24.07.17
 * Time: 18:21
 */

namespace Cocorico\CoreBundle\Model\Manager;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CharacteristicImageManager
{
    
    private $targetDir;

    private $container;

    public function __construct($targetDir, $container)
    {
        $this->targetDir = $targetDir;
        $this->container = $container;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */

    public function upload(UploadedFile $file)
    {
        $webPath = $this->getContainer()->getParameter('characteristic_image_webpath');
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        // Move the file to the directory where brochures are stored
        $file->move(
            $this->targetDir,
            $fileName
        );

        return $webPath . $fileName;
    }

    /**
     * @return string
     */
    public function getTargetDir()
    {
        return $this->targetDir;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }
}