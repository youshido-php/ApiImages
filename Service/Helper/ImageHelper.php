<?php
/**
 * Date: 1/11/16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\Service\Helper;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Filter\FilterConfiguration;
use Youshido\ApiImagesBundle\Entity\BaseImage;
use Youshido\ApiImagesBundle\GraphQL\Enum\ThumbnailModeTypeEnum;
use Youshido\ApiImagesBundle\Service\PathResolver\PathResolverInterface;

class ImageHelper
{

    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var FilterConfiguration
     */
    private $filterConfiguration;

    /**
     * @var PathResolverInterface
     */
    private $pathResolver;

    /**
     * ImageHelper constructor.
     *
     * @param CacheManager          $cacheManager
     * @param FilterConfiguration   $filterConfiguration
     * @param PathResolverInterface $pathResolver
     */
    public function __construct(CacheManager $cacheManager, FilterConfiguration $filterConfiguration, PathResolverInterface $pathResolver)
    {
        $this->cacheManager        = $cacheManager;
        $this->filterConfiguration = $filterConfiguration;
        $this->pathResolver        = $pathResolver;
    }

    public function resize(BaseImage $image, $width, $height, $mode = ThumbnailModeTypeEnum::MODE_OUTBOUND)
    {
        return $this->prepareUrlForSize($image, $width, $height, $mode);
    }

    public function getOriginUrl(BaseImage $image)
    {
        return $this->pathResolver->generateOriginUrl($image->getPath());
    }

    private function prepareUrlForSize(BaseImage $image, $width, $height, $mode)
    {
        $configuration = $this->filterConfiguration->get('dynamic');
        if (!$configuration || !isset($configuration['filters']['thumbnail']['size'])) {
            throw new \Exception('Must be enabled "dymanic" filter set with "thumbnail" filter');
        }

        $configuration['filters']['thumbnail']['size'][0] = $width;
        $configuration['filters']['thumbnail']['size'][1] = $height;
        $configuration['filters']['thumbnail']['mode']    = $mode;

        $filterName = sprintf('%s_%sx%s', $mode, $width, $height);
        $this->filterConfiguration->set($filterName, $configuration);

        return $this->cacheManager->getBrowserPath($image->getPath(), $filterName);
    }

}
