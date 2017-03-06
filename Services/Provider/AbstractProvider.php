<?php
/**
 * Date: 21.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Services\Provider;


use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Youshido\ImagesBundle\Document\Interfaces\ImageInterface;
use Youshido\ImagesBundle\DTO\ImageDTO;
use Youshido\ImagesBundle\Services\Loader;
use Youshido\ImagesBundle\ValueObject\LoaderResult;

abstract class AbstractProvider
{

    /** @var  ValidatorInterface */
    private $validator;

    /** @var  Loader */
    private $loader;

    /** @var  RequestStack */
    private $requestStack;

    abstract protected function createImage(LoaderResult $loaderResult, $mimeType) : ImageInterface;

    abstract public function getOne($id) : ImageInterface;

    public function __construct(ValidatorInterface $validator, Loader $loader, RequestStack $requestStack)
    {
        $this->validator    = $validator;
        $this->loader       = $loader;
        $this->requestStack = $requestStack;
    }

    public function createFromRequest($field) : ImageInterface
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request->files->has($field) || !$request->files->get($field)) {
            throw new \InvalidArgumentException(sprintf('Request hasn\'t file with field "%s"', $field));
        }

        return $this->createFromUploadedFile($request->files->get($field));
    }

    public function createFromUploadedFile(UploadedFile $file) : ImageInterface
    {
        $dto = new ImageDTO($file);

        $errors = $this->validator->validate($dto);
        if (0 !== count($errors)) {
            throw new \InvalidArgumentException($errors->get(0)->getMessage());
        }

        $loaderResult = $this->loader->uploadFromFile($file);

        return $this->createImage($loaderResult, $file->getMimeType());
    }

    /**
     * @param string $url
     *
     * @return ImageInterface
     */
    public function createFromUrl(string $url) : ImageInterface
    {
        $loaderResult = $this->loader->uploadFromUrl($url);

        return $this->createImage($loaderResult, $this->guessMimeType($loaderResult->getExtension()));
    }


    private function guessMimeType($extension)
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

        if (!array_key_exists($extension, $mimeTypes)) {
            return 'image/jpeg';
        }

        return $mimeTypes[$extension];
    }

}
