<?php
/**
 * Date: 11.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\Service\PathResolver;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LocalFilesystemPathResolver implements PathResolverInterface
{

    use ContainerAwareTrait;

    public function generateUrl($path, $filter)
    {
        return $this->prepareUrl($path, $filter);
    }

    public function generateOriginUrl($path)
    {
        return $this->prepareUrl($path);
    }

    private function prepareUrl($path, $filter = '')
    {
        $router = $this->container->get('router');

        $prefix = $this->container->getParameter('youshido.images.path_resolver.local.path_prefix');
        $prefix = rtrim($prefix, '/') . '/';

        $host = sprintf('%s://%s/',
            $router->getContext()->getScheme(),
            $router->getContext()->getHost()
        );

        $filter = $filter ? $filter . '/' : '';

        return $host . $prefix . $filter . $path;
    }

}
