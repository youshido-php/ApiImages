<?php
/**
 * Date: 12.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Youshido\ImagesBundle\Document\Interfaces\PathableInterface;

/**
 * @MongoDB\EmbeddedDocument()
 */
class EmbeddedImage implements PathableInterface
{

    /** @MongoDB\Id() */
    private $id;

    /** @MongoDB\Field(type="string") */
    private $referenceId;

    /** @MongoDB\Field(type="string") */
    private $path;

    /** @MongoDB\Field(type="string") */
    private $mimeType;

    /** @MongoDB\Field(type="integer") */
    private $size;

    public function __construct(Image $image)
    {
        $this
            ->setMimeType($image->getMimeType())
            ->setReferenceId($image->getId())
            ->setPath($image->getPath())
            ->setSize($image->getSize());
    }

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
     * Set referenceId
     *
     * @param string $referenceId
     *
     * @return $this
     */
    public function setReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;

        return $this;
    }

    /**
     * Get referenceId
     *
     * @return string $referenceId
     */
    public function getReferenceId()
    {
        return $this->referenceId;
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
}
