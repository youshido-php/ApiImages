<?php

namespace Youshido\ImagesBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Youshido\ImagesBundle\Document\Interfaces\ImageInterface;

/**
 * @MongoDB\Document(collection="images")
 */
class Image implements ImageInterface
{

    /** @MongoDB\Id() */
    private $id;

    /** @MongoDB\Field(type="string") */
    private $path;

    /** @MongoDB\Field(type="string") */
    private $mimeType;

    /** @MongoDB\Field(type="integer") */
    private $size;

    /** @MongoDB\Field(type="date") */
    private $uploadedAt;

    /**
     * Get id
     *
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string $path
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
     * @return $this
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string $mimeType
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer $size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set uploadedAt
     *
     * @param \DateTime $uploadedAt
     *
     * @return $this
     */
    public function setUploadedAt($uploadedAt)
    {
        $this->uploadedAt = $uploadedAt;

        return $this;
    }

    /**
     * Get uploadedAt
     *
     * @return \DateTime $uploadedAt
     */
    public function getUploadedAt()
    {
        return $this->uploadedAt;
    }
}
