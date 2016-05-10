<?php
/**
 * Date: 05.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\GraphQL\Type;


use Youshido\ApiImagesBundle\Entity\BaseImage;
use Youshido\GraphQLBundle\Type\AbstractContainerAwareObjectType;

class ImageType extends AbstractContainerAwareObjectType
{

    public function resolve($value = null, $args = [], $type = null)
    {
        $image = null;
        if ($value) {
            if ($value instanceof BaseImage) {
                $image = $value;
            } elseif (method_exists($value, 'getImage')) {
                $image = $value->getImage();
            }
        }

        if ($image) {
            $loader = $this->container->get('youshido.api_images.loader');

            if (!$loader->checkExist($image->getPath())) {
                return null;
            }

            $originalUr = $this->container->get('youshido.image_helper')->getOriginUrl($image);

            /** @var $image BaseImage */
            return [
                'id'        => $image->getId(),
                'originUrl' => $originalUr,
                'resize'    => $image
            ];
        }

        return null;
    }

    public function build($config)
    {
        $config
            ->addField('id', 'id')
            ->addField('originUrl', 'string')
            ->addField('resize', new ImageResizableType());
    }

    /**
     * @return String type name
     */
    public function getName()
    {
        return 'ImageType';
    }
}
