<?php
namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Entity\AddressBook;
use AppBundle\Service\FileUploader;

class PictureUploadListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof AddressBook) {
            return;
        }

        $fileName = $entity->getPicture();

        if (!empty($fileName)) {
            $entity->setPicture(new File($this->uploader->getTargetDirectory() . '/' . $fileName, false));
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof AddressBook) {
            return;
        }

        $fileName = $entity->getPicture();

        if (!empty($fileName)) {
            if (file_exists($fileName)) {
                unlink($fileName);
            }
        }
    }

    private function uploadFile($entity)
    {
    
        if (!$entity instanceof AddressBook) {
            return;
        }

        $file = $entity->getPicture();

        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setPicture($fileName);
        } elseif ($file instanceof File) {
            $entity->setPicture($file->getFilename());
        }
    }
}