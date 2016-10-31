<?php
/**
 * Date: 11.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Services\PathResolver;


use Youshido\ImagesBundle\Document\Interfaces\PathableInterface;
use Youshido\ImagesBundle\ValueObject\ResizeConfig;

interface PathResolverInterface
{
    //just image
    public function resolveWebPath(PathableInterface $pathable) : string;

    public function resolveRelativePath(PathableInterface $pathable) : string;

    public function resolveAbsolutePath(PathableInterface $pathable) : string;


    //resizable
    public function resolveWebResizablePath(ResizeConfig $configData, PathableInterface $pathable): string;

    public function resolveRelativeResizablePath(ResizeConfig $configData, PathableInterface $pathable) : string;

    public function resolveAbsoluteResizablePath(ResizeConfig $configData, PathableInterface $pathable) : string;
}