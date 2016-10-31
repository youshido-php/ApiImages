<?php
/**
 * Date: 12.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\ValueObject;


class LoaderResult
{

    /** @var  string */
    private $path;

    /** @var  int */
    private $size;

    /** @var  string */
    private $extension;

    public function __construct($path, $size, $extension)
    {
        $this->path      = $path;
        $this->size      = $size;
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    public function getExtension()
    {
        return $this->extension;
    }
}