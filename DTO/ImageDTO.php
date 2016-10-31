<?php
/**
 * Date: 11.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\DTO;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ImageDTO
{

    /**
     * @Assert\NotNull()
     * @Assert\Image(maxSize="5M")
     */
    private $uploadedFile;

    public function __construct(UploadedFile $uploadedFile)
    {
        $this->setUploadedFile($uploadedFile);
    }

    /**
     * @return mixed
     */
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }

    /**
     * @param mixed $uploadedFile
     *
     * @return ImageDTO
     */
    public function setUploadedFile(UploadedFile $uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;

        return $this;
    }


}