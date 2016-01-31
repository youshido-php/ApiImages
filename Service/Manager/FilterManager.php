<?php
/**
 * Date: 11.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\Service\Manager;


use Liip\ImagineBundle\Binary\BinaryInterface;

class FilterManager extends \Liip\ImagineBundle\Imagine\Filter\FilterManager
{

    public function applyFilter(BinaryInterface $binary, $filter, array $runtimeConfig = [])
    {
        $filterConfig = $this->getFilterConfiguration();

        if (preg_match('/^(inset|outbound)_(\d+)x(\d+)$/', $filter, $matches)) {
            $config = $filterConfig->get('dynamic');

            $config['filters']['thumbnail']['mode']    = $matches[1];
            $config['filters']['thumbnail']['size'][0] = $matches[2];
            $config['filters']['thumbnail']['size'][1] = $matches[3];
        } else {
            $config = $filterConfig->get($filter);
        }

        return $this->apply($binary, $config);
    }

}
