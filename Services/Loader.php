<?php
/**
 * Date: 05.01.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Youshido\ImagesBundle\DTO\PathableDTO;
use Youshido\ImagesBundle\Services\PathGenerator\PathGeneratorInterface;
use Youshido\ImagesBundle\Services\PathResolver\PathResolverInterface;
use Youshido\ImagesBundle\Services\Saver\SaverInterface;
use Youshido\ImagesBundle\ValueObject\LoaderResult;

class Loader
{

    /** @var  SaverInterface */
    private $saver;

    /** @var  PathResolverInterface */
    private $pathResolver;

    /** @var  PathGeneratorInterface */
    private $pathGenerator;

    public function __construct(PathResolverInterface $pathResolver, PathGeneratorInterface $pathGenerator, SaverInterface $saver)
    {
        $this->saver         = $saver;
        $this->pathResolver  = $pathResolver;
        $this->pathGenerator = $pathGenerator;
    }

    public function uploadFromFile(UploadedFile $file) : LoaderResult
    {
        $extension = $file->getClientOriginalExtension() ?: $file->guessExtension();

        return $this->doUpload($extension, $this->fileGetContent($file->getPathname()));
    }

    public function uploadFromUrl($url) : LoaderResult
    {
        $extension = pathinfo($url, PATHINFO_EXTENSION);
        if (strpos($extension, '?') !== false) {
            $extension = substr($extension, 0, strpos($extension, '?'));
        }

        return $this->doUpload($extension, $this->fileGetContent($url));
    }

    private function doUpload($extension, $data) : LoaderResult
    {
        $path         = $this->pathGenerator->generatePath($extension);
        $absolutePath = $this->pathResolver->resolveAbsolutePath(new PathableDTO($path));

        $this->saver->save($absolutePath, $data);

        $size = $this->saver->size($absolutePath);

        return new LoaderResult($path, $size, $extension);
    }

    protected function fileGetContent(string $path)
    {
        $contextOptions = [
            "ssl" => [
                "verify_peer"      => false,
                "verify_peer_name" => false,
            ],
        ];

        return file_get_contents($path, null, stream_context_create($contextOptions));
    }

    public function checkExist($path) : bool
    {
        return $this->saver->has($this->pathResolver->resolveAbsolutePath($path));
    }
}
