<?php
/**
 * Date: 12.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Services\Factory;


use Imagine\Gd\Imagine as GDImagine;
use Imagine\Gmagick\Imagine as GmagickImagine;
use Imagine\Image\AbstractImagine;
use Imagine\Imagick\Imagine as ImagickImagine;

class ImagineFactory
{

    const DRIVER_GD      = 'gd';
    const DRIVER_IMAGICK = 'imagick';
    const DRIVER_GMAGICK = 'gmagick';

    public static function createImagine($driver = self::DRIVER_GD) : AbstractImagine
    {
        switch ($driver) {
            case self::DRIVER_GD:
                return new GDImagine();

            case self::DRIVER_IMAGICK:
                return new ImagickImagine();

            case self::DRIVER_GMAGICK:
                return new GmagickImagine();

            default:
                throw new \InvalidArgumentException(sprintf('Driver "%s" not supported', $driver));
        }
    }

}