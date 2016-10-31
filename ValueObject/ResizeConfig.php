<?php
/**
 * Date: 12.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\ValueObject;


class ResizeConfig
{

    const MODE_INSET    = 'inset';
    const MODE_OUTBOUND = 'outbound';

    private $mode;

    private $width;

    private $height;

    public function __construct($width, $height, $mode = self::MODE_OUTBOUND)
    {
        $this->height = $height;
        $this->width  = $width;
        $this->mode   = $mode;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }
}