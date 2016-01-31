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

class ImageType extends AbstractContainerAwareObjectType
{

    public function resolve($value = null, $args = [])
    {
        if ($value && method_exists($value, 'getImage')) {
            return $this->container
                ->get('youshido.image_helper')
                ->resize($value->getImage(), $args['width'], $args['height'], $args['mode']);
        }

        return null;
    }

    public function build(TypeConfigInterface $config)
    {
        $config
            ->addArgument('width', 'int', ['required' => true])
            ->addArgument('height', 'int', ['required' => true])
            ->addArgument('mode', new ThumbnailModeTypeEnum(), ['default' => 'OUTBOUND'])

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
