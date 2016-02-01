<?php
/**
 * Date: 05.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\GraphQL\Type;


use Youshido\ApiImagesBundle\GraphQL\Enum\ThumbnailModeTypeEnum;
use Youshido\GraphQL\Type\Config\TypeConfigInterface;
use Youshido\GraphQLBundle\Type\AbstractContainerAwareObjectType;

class OriginalImageType extends AbstractContainerAwareObjectType
{

    public function resolve($value = null, $args = [])
    {
        if ($value && method_exists($value, 'getImage')) {
            if($image = $value->getImage()) {
                return $this->container
                    ->get('youshido.image_helper')
                    ->resize($image, $args['width'], $args['height'], $args['mode']);
            }
        }

        return null;
    }

    public function build(TypeConfigInterface $config)
    {
        $config
            ->addField('id', 'id')
            ->addField('url', 'string');
    }

    /**
     * @return String type name
     */
    public function getName()
    {
        return 'ImageType';
    }
}
