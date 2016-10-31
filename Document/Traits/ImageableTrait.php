<?php
/**
 * Date: 12.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Document\Traits;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Youshido\ImagesBundle\Document\EmbeddedImage;

trait ImageableTrait
{

    /**
     * @var EmbeddedImage
     *
     * @MongoDB\EmbedOne(targetDocument="Youshido\ImagesBundle\Document\EmbeddedImage")
     */
    private $image;

    /** @return EmbeddedImage */
    public function getImage()
    {
        return $this->image;
    }

    public function setImage(EmbeddedImage $image = null)
    {
        $this->image = $image;

        return $this;
    }
}