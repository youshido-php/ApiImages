<?php
/**
 * Date: 05.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\GraphQL\Mutation;

use Youshido\ApiImagesBundle\Entity\BaseImage;
use Youshido\ApiImagesBundle\GraphQL\Type\ImageType;
use Youshido\GraphQL\Type\Config\TypeConfigInterface;
use Youshido\GraphQLBundle\Type\AbstractContainerAwareMutationType;

class UploadImageMutation extends AbstractContainerAwareMutationType
{
    public function resolve($value = null, $args = [])
    {
        /** @var $image BaseImage */
        $image = $this->container->get('youshido.image_provider')
            ->loadFromRequest($args['field']);

        $originalUr = $this->container->get('youshido.image_helper')->getOriginUrl($image);

        return [
            'id'        => $image->getId(),
            'originUrl' => $originalUr,
            'resize'    => $image
        ];
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
