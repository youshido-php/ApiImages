<?php
/**
 * Date: 12.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Services;


use Imagine\Image\Box;
use Youshido\ImagesBundle\Document\Interfaces\PathableInterface;
use Youshido\ImagesBundle\Services\Factory\ImagineFactory;
use Youshido\ImagesBundle\Services\PathResolver\PathResolverInterface;
use Youshido\ImagesBundle\Services\Saver\SaverInterface;
use Youshido\ImagesBundle\ValueObject\ResizeConfig;

class Resizer
{
    /** @var PathResolverInterface */
    private $pathResolver;

    /** @var  SaverInterface */
    private $saver;

    private $driver = ImagineFactory::DRIVER_GD;

    public function __construct(SaverInterface $saver, PathResolverInterface $pathResolver, $driver)
    {
        $this->saver        = $saver;
        $this->pathResolver = $pathResolver;
        $this->driver       = $driver;
    }

    public function resize(PathableInterface $pathable, ResizeConfig $config)
    {
        $absoluteTargetPath = $this->pathResolver->resolveAbsoluteResizablePath($config, $pathable);

        if ($this->saver->has($absoluteTargetPath)) {
            return;
        }

        $imagine = ImagineFactory::createImagine($this->driver);

        $this->saver->checkPath($absoluteTargetPath);

        $imagine
            ->open($this->pathResolver->resolveAbsolutePath($pathable))
            ->thumbnail(new Box($config->getWidth(), $config->getHeight()), $config->getMode())
            ->save($absoluteTargetPath);
    }

    public function getPathResolver() : PathResolverInterface
    {
        return $this->pathResolver;
    }
}