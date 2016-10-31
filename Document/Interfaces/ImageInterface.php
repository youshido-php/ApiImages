<?php
/**
 * Date: 21.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Document\Interfaces;


interface ImageInterface extends PathableInterface
{

    public function getId();

    public function getPath();

    public function getMimeType();

    public function getSize();

    public function getUploadedAt();

}