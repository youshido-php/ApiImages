<?php
/**
 * Date: 12.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Services\Saver;


class LocalFilesystemSaver implements SaverInterface
{

    public function save($absolutePath, $data)
    {
        $this->checkPath($absolutePath);

        return file_put_contents($absolutePath, $data, FILE_APPEND);
    }

    public function has($absolutePath)
    {
        return file_exists($absolutePath);
    }

    public function size($absolutePath)
    {
        return filesize($absolutePath);
    }

    public function checkPath($path)
    {
        $directory = dirname($path);

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
    }
}