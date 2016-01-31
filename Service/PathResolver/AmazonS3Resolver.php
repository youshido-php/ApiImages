<?php
/**
 * Date: 19.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\Service\PathResolver;

use Gaufrette\Adapter\AwsS3;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Youshido\ApiImagesBundle\Traits\FilesystemTrait;

class AmazonS3Resolver implements PathResolverInterface
{

    use ContainerAwareTrait, FilesystemTrait;

    public function generateUrl($path, $filter)
    {
        /** @var AwsS3 $adapter */
        $adapter = $this->getFilesystem()->getAdapter();

        return $adapter->getUrl(rtrim($filter, '/') . DIRECTORY_SEPARATOR . $path);
    }
}
