<?php
/**
 * Date: 11.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\Service\PathResolver;


interface PathResolverInterface
{

    public function generateUrl($path, $filter);

}