<?php
/**
 * Date: 11.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\Service\Manager;


class CacheManager extends \Liip\ImagineBundle\Imagine\Cache\CacheManager
{

    protected function getResolver($filter, $resolver)
    {
        // BC
        if (false == $resolver) {
            if(preg_match('/^(inset|outbound)_\d+x\d+$/', $filter)) {
                $config = $this->filterConfig->get('dynamic');
            } else {
                $config = $this->filterConfig->get($filter);
            }

            $resolverName = empty($config['cache']) ? $this->defaultResolver : $config['cache'];
        } else {
            $resolverName = $resolver;
        }

        if (!isset($this->resolvers[$resolverName])) {
            throw new \OutOfBoundsException(sprintf(
                'Could not find resolver "%s" for "%s" filter type',
                $resolverName,
                $filter
            ));
        }

        return $this->resolvers[$resolverName];
    }

}
