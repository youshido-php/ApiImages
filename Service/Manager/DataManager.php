<?php
/**
 * Date: 11.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\Service\Manager;


class DataManager extends \Liip\ImagineBundle\Imagine\Data\DataManager
{

    public function getLoader($filter)
    {
        if(preg_match('/^(inset|outbound)_\d+x\d+$/', $filter)) {
            $config = $this->filterConfig->get('dynamic');
        } else {
            $config = $this->filterConfig->get($filter);
        }

        $loaderName = empty($config['data_loader']) ? $this->defaultLoader : $config['data_loader'];

        if (!isset($this->loaders[$loaderName])) {
            throw new \InvalidArgumentException(sprintf(
                'Could not find data loader "%s" for "%s" filter type',
                $loaderName,
                $filter
            ));
        }

        return $this->loaders[$loaderName];
    }

}
