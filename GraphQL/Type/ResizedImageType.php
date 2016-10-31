<?php
/**
 * Date: 12.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\GraphQL\Type;


use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\StringType;

class ResizedImageType extends AbstractObjectType
{

    public function build($config)
    {
        $config->addFields([
            'url' => new StringType()
        ]);
    }
}