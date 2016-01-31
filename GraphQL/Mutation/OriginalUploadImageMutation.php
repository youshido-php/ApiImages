<?php
/**
 * Date: 05.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\GraphQL\Mutation;

use Youshido\ApiImagesBundle\GraphQL\Type\ImageType;
use Youshido\GraphQL\Type\Config\TypeConfigInterface;
use Youshido\GraphQLBundle\Type\AbstractContainerAwareMutationType;

class OriginalUploadImageMutation extends AbstractContainerAwareMutationType
{
    public function resolve($value = null, $args = [])
    {
        $image = $this->container->get('youshido.image_provider')
            ->loadFromRequest($args['field']);


        //todo: here original url
        return $this->container
            ->get('youshido.image_helper')
            ->resize($image, $args['width'], $args['height']);
    }

    public function build(TypeConfigInterface $config)
    {
        $config
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
