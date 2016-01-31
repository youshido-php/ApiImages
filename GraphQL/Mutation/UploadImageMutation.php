<?php
/**
 * Date: 05.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\GraphQL\Mutation;

use Youshido\ApiImagesBundle\GraphQL\Enum\ThumbnailModeTypeEnum;
use Youshido\ApiImagesBundle\GraphQL\Type\ImageType;
use Youshido\GraphQL\Type\Config\TypeConfigInterface;
use Youshido\GraphQLBundle\Type\AbstractContainerAwareMutationType;

class UploadImageMutation extends AbstractContainerAwareMutationType
{
    public function resolve($value = null, $args = [])
    {
        $image = $this->container->get('youshido.image_provider')
            ->loadFromRequest($args['field']);

        return $this->container
            ->get('youshido.image_helper')
            ->resize($image, $args['width'], $args['height'], $args['mode']);
    }

    public function build(TypeConfigInterface $config)
    {
        $config
            ->addArgument('width', 'int', ['required' => true])
            ->addArgument('height', 'int', ['required' => true])
            ->addArgument('mode', new ThumbnailModeTypeEnum(), ['default' => 'OUTBOUND'])
            ->addArgument('field', 'string', ['default' => 'image']);
    }

    public function getOutputType()
    {
        return new ImageType();
    }

    /**
     * @return String type name
     */
    public function getName()
    {
        return 'UploadImageMutation';
    }
}
