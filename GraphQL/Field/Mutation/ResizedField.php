<?php
/**
 * Date: 12.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\GraphQL\Field\Mutation;


use Youshido\GraphQL\Config\Field\FieldConfig;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Type\AbstractType;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\IntType;
use Youshido\ImagesBundle\GraphQL\Type\ResizedImageType;
use Youshido\ImagesBundle\GraphQL\Type\ResizeImageModeType;
use Youshido\ImagesBundle\ValueObject\ResizeConfig;

class ResizedField extends AbstractField
{

    public function build(FieldConfig $config)
    {
        $config->addArguments([
            'width'  => new NonNullType(new IntType()),
            'height' => new NonNullType(new IntType()),
            'mode'   => [
                'type'    => new ResizeImageModeType(),
                'default' => 'OUTBOUND'
            ]
        ]);
    }

    public function resolve($value, array $args, ResolveInfo $info)
    {
        return [
            'url' => $info->getContainer()->get('api_images.resizer')->getPathResolver()->resolveWebResizablePath(
                new ResizeConfig($args['width'], $args['height'], $args['mode']),
                $value['image']
            )
        ];
    }

    /**
     * @return AbstractObjectType|AbstractType
     */
    public function getType()
    {
        return new ResizedImageType();
    }
}