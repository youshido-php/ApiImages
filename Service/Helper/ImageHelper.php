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
     * ImageHelper constructor.
     *
     * @param CacheManager        $cacheManager
     * @param FilterConfiguration $filterConfiguration
     */
    public function __construct(CacheManager $cacheManager, FilterConfiguration $filterConfiguration)
    {
        $this->cacheManager        = $cacheManager;
        $this->filterConfiguration = $filterConfiguration;
    }

    public function resize(BaseImage $image, $width, $height, $mode = ThumbnailModeTypeEnum::MODE_OUTBOUND)
    {
        return [
            'id'  => $image->getId(),
            'url' => $this->prepareUrlForSize($image, $width, $height, $mode)
        ];
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
