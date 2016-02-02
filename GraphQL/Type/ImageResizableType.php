<?php
/**
 * Date: 02.02.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\GraphQL\Type;


use Youshido\ApiImagesBundle\GraphQL\Enum\ThumbnailModeTypeEnum;
use Youshido\GraphQL\Type\Config\TypeConfigInterface;
use Youshido\GraphQLBundle\Type\AbstractContainerAwareObjectType;

class ImageResizableType extends AbstractContainerAwareObjectType
{

    public function resolve($value = null, $args = [])
    {
        if ($value && is_array($value) && array_key_exists('resize', $value)) {
            $url = $this->container
                ->get('youshido.image_helper')
                ->resize($value['resize'], $args['width'], $args['height'], $args['mode']);

            return ['url' => $url];
        }

        return null;
    }

    public function build(TypeConfigInterface $config)
    {
        $config
            ->addArgument('width', 'int', ['required' => true])
            ->addArgument('height', 'int', ['required' => true])
            ->addArgument('mode', new ThumbnailModeTypeEnum(), ['default' => 'OUTBOUND'])
            ->addField('url', 'string');
    }

    /**
     * @return String type name
     */
    public function getName()
    {
        return 'ImageResizableType';
    }
}