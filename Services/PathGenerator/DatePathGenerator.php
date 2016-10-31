<?php
/**
 * Date: 11.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Services\PathGenerator;


class DatePathGenerator implements PathGeneratorInterface
{

    public function generatePath(string $extension) : string
    {
        $now = new \DateTime();

        return sprintf('%s/%s/%s/%s.%s', $now->format('Y'), $now->format('m'), $now->format('d'), uniqid(), $extension);
    }
}