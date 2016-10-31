<?php
/**
 * Date: 12.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\GraphQL\Type;


use Youshido\GraphQL\Type\Enum\AbstractEnumType;
use Youshido\ImagesBundle\ValueObject\ResizeConfig;

class ResizeImageModeType extends AbstractEnumType
{

    /**
     * @return array
     */
    public function getValues()
    {
        return [
            [
                'name'  => 'INSET',
                'value' => ResizeConfig::MODE_INSET
            ],
            [
                'name'  => 'OUTBOUND',
                'value' => ResizeConfig::MODE_OUTBOUND
            ],
        ];
    }
}