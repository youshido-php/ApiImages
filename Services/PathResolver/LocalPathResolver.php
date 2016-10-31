<?php
/**
 * Date: 11.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Services\PathResolver;


use Symfony\Component\Routing\RouterInterface;
use Youshido\ImagesBundle\Document\Interfaces\PathableInterface;
use Youshido\ImagesBundle\ValueObject\ResizeConfig;

class LocalPathResolver implements PathResolverInterface
{
    /** @var  string */
    private $scheme;

    /** @var  string */
    private $host;

    /** @var  string */
    private $prefix;

    /** @var string */
    private $webRoot;

    public function __construct(RouterInterface $router, $webRoot, $prefix, $host = null, $scheme = null)
    {
        $this->prefix  = $prefix;
        $this->webRoot = $webRoot;

        $this->host   = $host;
        $this->scheme = $scheme;

        if (!$host) {
            $this->host = $router->getContext()->getHost();
        }

        if (!$scheme) {
            $this->scheme = $router->getContext()->getScheme();
        }
    }

    public function resolveWebPath(PathableInterface $pathable) : string
    {
        return sprintf('%s://%s%s', $this->scheme, $this->host, $this->resolveRelativePath($pathable));
    }

    public function resolveRelativePath(PathableInterface $pathable) : string
    {
        return sprintf('/%s/%s', $this->prefix, $pathable->getPath());
    }

    public function resolveAbsolutePath(PathableInterface $pathable) : string
    {
        return sprintf('%s%s', $this->webRoot, $this->resolveRelativePath($pathable));
    }

    public function resolveWebResizablePath(ResizeConfig $configData, PathableInterface $pathable): string
    {
        return sprintf('%s://%s%s', $this->scheme, $this->host, $this->resolveRelativeResizablePath($configData, $pathable));
    }

    public function resolveRelativeResizablePath(ResizeConfig $configData, PathableInterface $pathable) : string
    {
        return sprintf('/media/cache/%s/%sx%s/%s', $configData->getMode(), $configData->getWidth(), $configData->getHeight(), $pathable->getPath());
    }

    public function resolveAbsoluteResizablePath(ResizeConfig $config, PathableInterface $pathable) : string
    {
        return sprintf('%s/%s', $this->webRoot, ltrim($this->resolveRelativeResizablePath($config, $pathable), '/'));
    }

}