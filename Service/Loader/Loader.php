<?php
/**
 * Date: 05.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\Service\Loader;

use Gaufrette\Adapter;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Youshido\ApiImagesBundle\Traits\FilesystemTrait;

class Loader implements LoaderInterface
{

    use ContainerAwareTrait, FilesystemTrait;

    /** @var  int */
    private $subFolders;

    public function __construct($subFolders = 2)
    {
        $this->subFolders = intval($subFolders);
    }

    /**
     * @param UploadedFile $file
     *
     * @return string path of image
     */
    public function upload(UploadedFile $file)
    {
        $filename = $this->generateFilePath($file->getClientOriginalExtension());

        $this->getFilesystem()->write($filename, $this->getContent($file->getPathname()));

        return $filename;
    }

    protected function getContent($path)
    {
        $contextOptions = [
            "ssl" => [
                "verify_peer"      => false,
                "verify_peer_name" => false,
            ],
        ];

        return file_get_contents($path, null, stream_context_create($contextOptions));
    }

    public function checkExist($filename)
    {
        try {
            return $this->getFilesystem()->has($filename);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function uploadFromUrl($url)
    {
        $extension = pathinfo($url, PATHINFO_EXTENSION);
        if (strpos($extension, '?') !== false) {
            $extension = substr($extension, 0, strpos($extension, '?'));
        }

        $filename = $this->generateFilePath($extension);

        $this->getFilesystem()->write($filename, $this->getContent($url));

        return $filename;
    }

    public function generateFilePath($extension)
    {
        return sprintf('%s/%s/%s/%s.%s', date('Y'), date('m'), date('d'), uniqid(), $extension);
    }

    public function guessMimeType($extension)
    {
        $mimeTypes = [
            'png'  => 'image/png',
            'jpe'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg'  => 'image/jpeg',
            'gif'  => 'image/gif',
            'bmp'  => 'image/bmp',
            'ico'  => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif'  => 'image/tiff',
            'svg'  => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
        ];

        return array_key_exists($extension, $mimeTypes) ? $mimeTypes[$extension] : 'application/octet-stream';
    }

    public function guessExtension($mimeType)
    {
        $extensions = [
            'image/png'                => 'png',
            'image/jpeg'               => 'jpeg',
            'image/gif'                => 'gif',
            'image/bmp'                => 'bmp',
            'image/vnd.microsoft.icon' => 'ico',
            'image/tiff'               => 'tiff',
            'image/svg+xml'            => 'svg',
        ];

        return array_key_exists($mimeType, $extensions) ? $extensions[$mimeType] : 'application/octet-stream';
    }
}
