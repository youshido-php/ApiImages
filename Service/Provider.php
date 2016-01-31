<?php
/**
 * Date: 05.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Youshido\ApiImagesBundle\Entity\BaseImage;
use Youshido\ApiImagesBundle\Service\Loader\LoaderInterface;

class Provider
{

    use ContainerAwareTrait;

    /** @var  LoaderInterface */
    private $loader;

    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function loadFromRequest($field)
    {
        $image = $this->prepareImage($field);

        $file = $image->getUploadedFile();

        $image
            ->setMimeType($file->getMimeType())
            ->setPath($this->loader->upload($file))
            ->setUserId($this->recognizeUserId());

        $em = $this->container->get('doctrine')->getManager();
        $em->persist($image);
        $em->flush();

        return $image;
    }

    public function loadByFile(UploadedFile $file)
    {
        $imageClass = $this->container->getParameter('youshido.images.params.image_model');
        /** @var BaseImage $image */
        $image = new $imageClass;

        $image
            ->setMimeType($file->getMimeType())
            ->setPath($this->loader->upload($file))
            ->setUserId($this->recognizeUserId());

        $em = $this->container->get('doctrine')->getManager();
        $em->persist($image);
        $em->flush();

        return $image;
    }

    public function loadFromUrl($url)
    {
        $extension = pathinfo($url, PATHINFO_EXTENSION);

        if (strpos($extension, '?') !== false) {
            $extension = substr($extension, 0, strpos($extension, '?'));
        }

        $imageClass = $this->container->getParameter('youshido.images.params.image_model');
        /** @var BaseImage $image */
        $image = new $imageClass;

        $image
            ->setMimeType($this->loader->guessMimeType($extension))
            ->setPath($this->loader->uploadFromUrl($url))
            ->setUserId($this->recognizeUserId());

        $em = $this->container->get('doctrine')->getManager();
        $em->persist($image);
        $em->flush();

        return $image;
    }

    private function recognizeUserId()
    {
        /** @var TokenInterface $token */
        $token = $this->container->get('security.token_storage')->getToken();

        if ($token && $token->getUser() && is_object($token->getUser())) {
            return $token->getUser()->getId();
        }

        return null;
    }

    /**
     * @param $field string
     *
     * @return BaseImage
     *
     * @throws \Exception
     */
    private function prepareImage($field)
    {
        /** @var Request $request */
        $request = $this->container->get('request_stack')->getCurrentRequest();

        if ($request->files->has($field)) {
            /** @var UploadedFile $file */
            $file = $request->files->get($field, null);

            $imageClass = $this->container->getParameter('youshido.images.params.image_model');

            /** @var BaseImage $image */
            $image = new $imageClass;
            $image->setUploadedFile($file);

            $validator = $this->container->get('validator');
            $errors    = $validator->validate($image, null, ['verify-upload']);

            if (count($errors) !== 0) {
                throw new \Exception($errors->get(0)->getMessage(), 400);
            }

            return $image;
        } else {
            throw new \Exception(sprintf('Request must contain file field with name "%s"', $field), 400);
        }
    }

}
