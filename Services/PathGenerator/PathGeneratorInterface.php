<?php
/**
 * Date: 11.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Services\PathGenerator;


interface PathGeneratorInterface
{

    public function generatePath(string $extension) : string;

}