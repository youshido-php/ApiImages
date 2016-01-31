<?php
/**
 * Date: 1/31/16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\Traits;

use Gaufrette\Filesystem;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class FilesystemTrait
 *
 * @property-read ContainerInterface $container
 */
trait FilesystemTrait
{

    /** @var  Filesystem */
    private $filesystem;

    /**
     * @return Filesystem
     */
    public function getFilesystem()
    {
        if (!$this->filesystem) {
            $serviceAlias = $this->container->getParameter('youshido.images.path_resolver.amazons3.filesystem_service');

            $this->filesystem = $this->container->get($serviceAlias);
        }

        return $this->filesystem;
    }

}
