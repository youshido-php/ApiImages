<?php
/**
 * Date: 12.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Services\Saver;


interface SaverInterface
{
    /**
     * @param $absolutePath string
     * @param $data         string
     *
     * @return bool
     */
    public function save($absolutePath, $data);

    /**
     * @param $absolutePath
     *
     * @return bool
     */
    public function has($absolutePath);

    /**
     * @param $absolutePath
     *
     * @return int
     */
    public function size($absolutePath);

    /**
     * @param $path
     *
     * @return null
     */
    public function checkPath($path);
}