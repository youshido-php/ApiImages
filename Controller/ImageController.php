<?php

namespace Youshido\ImagesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Youshido\ImagesBundle\DTO\PathableDTO;
use Youshido\ImagesBundle\ValueObject\ResizeConfig;

class ImageController extends Controller
{

    /**
     * @Route("/media/cache/{mode}/{width}x{height}/{path}", name="images.resize", requirements={"path"=".+"})
     *
     * @param $mode
     * @param $width
     * @param $height
     * @param $path
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function resizeAction($mode, $width, $height, $path) : Response
    {
        try {
            $resizer = $this->get('api_images.resizer');

            $pathable = new PathableDTO($path);
            $config   = new ResizeConfig($width, $height, $mode);

            $resizer->resize($pathable, $config);

            return new RedirectResponse($resizer->getPathResolver()->resolveWebResizablePath($config, $pathable), 301);
        } catch (\Exception $e) {
            throw $this->createNotFoundException();
        }
    }
}
