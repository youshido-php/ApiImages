<?php
/**
 * Date: 12.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Document\Interfaces;

use Youshido\ImagesBundle\Document\EmbeddedImage;

interface ImageableInterface
{

    /**
     * @return EmbeddedImage
     */
    public function getImage();

    /**
     * @param EmbeddedImage|null $image
     *
     * @return ImageableInterface
     */
    public function setImage(EmbeddedImage $image = null);
}