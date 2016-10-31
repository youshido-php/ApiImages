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
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\GraphQL\Type\Scalar\StringType;
use Youshido\ImagesBundle\GraphQL\Type\ImageType;

class UploadImageField extends AbstractField
{
    public function build(FieldConfig $config)
    {
        $config->addArguments([
            'field' => [
                'type'    => new StringType(),
                'default' => 'image'
            ]
        ]);
    }

    public function resolve($value, array $args, ResolveInfo $info)
    {
        $image = $info->getContainer()->get('api_images.provider')->createFromRequest($args['field']);

        return [
            'id'    => $image->getId(),
            'url'   => $info->getContainer()->get('api_images.path_resolver')->resolveWebPath($image),
            'image' => $image
        ];
    }

    /**
     * @return AbstractObjectType|AbstractType
     */
    public function getType()
    {
        return new ImageType();
    }
}
