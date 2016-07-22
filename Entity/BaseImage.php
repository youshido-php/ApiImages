<?php

namespace Youshido\ApiImagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Youshido\DoctrineExtensionBundle\Traits\TimetrackableTrait;

/**
 * BaseImage
 *
 * @ORM\MappedSuperclass(repositoryClass="Youshido\ApiImagesBundle\Entity\Repository\BaseImageRepository")
 * @property mixed $id
 * @method integer getId()
 */
class BaseImage
{

    use TimetrackableTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="mimeType", type="string", length=255)
     */
    private $mimeType;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $size;

    /**
     * @var UploadedFile
     *
     * @Assert\NotNull(
     *     groups={"verify-upload"},
     * )
     * @Assert\Image(
     *     maxSize="5M",
     *     groups={"verify-upload"},
     * )
     */
    private $uploadedFile;

    /**
     * Set path
     *
     * @param string $path
     *
     * @return BaseImage
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     *
     * @return BaseImage
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @return UploadedFile
     */
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }

    /**
     * @param UploadedFile $uploadedFile
     *
     * @return BaseImage
     */
    public function setUploadedFile($uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int|null $userId
     *
     * @return BaseImage
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     *
     * @return BaseImage
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }
}
