<?php
/**
 * Date: 21.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Youshido\ImagesBundle\Document\Interfaces\ImageInterface;

/**
 * @ORM\Table(name="images")
 * @ORM\Entity()
 */
class Image implements ImageInterface
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $mimeType;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $uploadedAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Image
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return Image
     */
    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     *
     * @return Image
     */
    public function setMimeType(string $mimeType)
    {
        $this->mimeType = $mimeType;

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
     * @return Image
     */
    public function setSize(int $size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUploadedAt()
    {
        return $this->uploadedAt;
    }

    /**
     * @param \DateTime $uploadedAt
     *
     * @return Image
     */
    public function setUploadedAt(\DateTime $uploadedAt)
    {
        $this->uploadedAt = $uploadedAt;

        return $this;
    }
}