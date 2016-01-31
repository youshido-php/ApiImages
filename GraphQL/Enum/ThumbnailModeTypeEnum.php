<?php
/**
 * Date: 1/31/16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\GraphQL\Enum;


use Youshido\GraphQL\Type\Object\AbstractEnumType;

class ThumbnailModeTypeEnum extends AbstractEnumType
{

    const MODE_INSET = 'inset';
    const MODE_OUTBOUND = 'outbound';

    public function getValues()
    {
        return [
            [
                'name'  => 'INSET',
                'value' => self::MODE_INSET
            ],
            [
                'name'  => 'OUTBOUND',
                'value' => self::MODE_OUTBOUND
            ]
        ];
    }

    /**
     * @return String type name
     */
    public function getName()
    {
        return 'ThumbnailModeTypeEnum';
    }
}
