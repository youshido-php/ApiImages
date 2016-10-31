<?php
/**
 * Date: 21.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Services\Provider;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Youshido\ImagesBundle\Document\Interfaces\ImageInterface;
use Youshido\ImagesBundle\Entity\Image;
use Youshido\ImagesBundle\Services\Loader;
use Youshido\ImagesBundle\ValueObject\LoaderResult;

class ORMProvider extends AbstractProvider
{

    /** @var  EntityManager */
    private $em;

    public function __construct(EntityManager $em, ValidatorInterface $validator, Loader $loader, RequestStack $requestStack)
    {
        parent::__construct($validator, $loader, $requestStack);

        $this->em = $em;
    }

    protected function createImage(LoaderResult $loaderResult, $mimeType) : ImageInterface
    {
        $image = ($image = new Image())
            ->setPath($loaderResult->getPath())
            ->setSize($loaderResult->getSize())
            ->setMimeType($mimeType)
            ->setUploadedAt(new \DateTime());

        $this->em->persist($image);
        $this->em->flush($image);

        return $image;
    }

    public function getOne($id) : ImageInterface
    {
        $image = $this->em->getRepository(Image::class)->find($id);

        if (!$image) {
            throw new \Exception('Image not found', 404);
        }

        return $image;
    }
}