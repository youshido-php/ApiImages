<?php
/**
 * Date: 21.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Services\Provider;


use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Youshido\ImagesBundle\Document\Image;
use Youshido\ImagesBundle\Document\Interfaces\ImageInterface;
use Youshido\ImagesBundle\Services\Loader;
use Youshido\ImagesBundle\ValueObject\LoaderResult;

class ODMProvider extends AbstractProvider
{

    /** @var  DocumentManager */
    private $dm;

    public function __construct(DocumentManager $dm, ValidatorInterface $validator, Loader $loader, RequestStack $requestStack)
    {
        parent::__construct($validator, $loader, $requestStack);

        $this->dm = $dm;
    }

    protected function createImage(LoaderResult $loaderResult, $mimeType) : ImageInterface
    {
        $image = ($image = new Image())
            ->setPath($loaderResult->getPath())
            ->setSize($loaderResult->getSize())
            ->setMimeType($mimeType)
            ->setUploadedAt(new \DateTime());

        $this->dm->persist($image);
        $this->dm->flush($image);

        return $image;
    }

    public function getOne($id) : ImageInterface
    {
        $image = $this->dm->getRepository(Image::class)->find($id);

        if(!$image) {
            throw new \Exception('Image not found', 404);
        }

        return $image;
    }
}