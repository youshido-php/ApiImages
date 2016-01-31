<?php
/**
 * Date: 05.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\Service\Loader;


use Symfony\Component\HttpFoundation\File\UploadedFile;

interface LoaderInterface
{

    /**
     * @param UploadedFile $file
     *
     * @return string path of image
     */
    public function upload(UploadedFile $file);

    /**
     * @param $url
     *
     * @return string path of image
     */
    public function uploadFromUrl($url);

    public function guessMimeType($extension);

}
