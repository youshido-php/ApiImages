<?php
/**
 * Date: 12.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\GraphQL\Field\Query;


use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Type\AbstractType;
use Youshido\GraphQL\Type\Object\AbstractObjectType;
use Youshido\ImagesBundle\Document\EmbeddedImage;
use Youshido\ImagesBundle\Document\Interfaces\ImageableInterface as ODMImageableInterface;
use Youshido\ImagesBundle\Entity\Interfaces\ImageableInterface as ORMImageableInterface;
use Youshido\ImagesBundle\GraphQL\Type\ImageType;

class ImageField extends AbstractField
{

    public function resolve($value, array $args, ResolveInfo $info)
    {
        if ($value) {
            if ($value instanceof ODMImageableInterface || $value instanceof ORMImageableInterface || method_exists('getImage', $value)) {
                if ($image = $value->getImage()) {
                    return [
                        'id'    => $image instanceof EmbeddedImage ? $image->getReferenceId() : $image->getId(),
                        'url'   => $info->getContainer()->get('api_images.path_resolver')->resolveWebPath($image),
                        'image' => $image
                    ];
                }
            }
        }

        return null;
    }

    /**
     * @return AbstractObjectType|AbstractType
     */
    public function getType()
    {
        return new ImageType();
    }
}