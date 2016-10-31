<?php
/**
 * Date: 21.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Entity\Interfaces;


use Youshido\ImagesBundle\Entity\Image;

interface ImageableInterface
{
    /**
     * @return Image
     */
    public function getImage();

    /**
     * @param Image $image
     *
     * @return $this
     */
    public function setImage(Image $image = null);
}