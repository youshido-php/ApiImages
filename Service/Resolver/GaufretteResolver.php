<?php
/**
 * Date: 1/11/16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ApiImagesBundle\Service\Resolver;

use Liip\ImagineBundle\Binary\BinaryInterface;
use Liip\ImagineBundle\Imagine\Cache\Resolver\ResolverInterface;
use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Youshido\ApiImagesBundle\Service\PathResolver\PathResolverInterface;
use Youshido\ApiImagesBundle\Traits\FilesystemTrait;

class GaufretteResolver implements ResolverInterface
{

    use ContainerAwareTrait, FilesystemTrait;

    /** @var DataManager */
    protected $dataManager;

    /** @var PathResolverInterface */
    protected $pathResolver;

    public function __construct(
        DataManager $dataManager,
        FilterManager $filterManager,
        PathResolverInterface $pathResolver
    )
    {
        $this->dataManager   = $dataManager;
        $this->filterManager = $filterManager;
        $this->pathResolver  = $pathResolver;
    }

    /**
     * @inheritdoc
     */
    public function isStored($path, $filter)
    {
        $inCache = $this->getFilesystem()->has($this->resolvePath($path, $filter));

        if (!$inCache) {
            $this->store(
                $this->filterManager->applyFilter($this->dataManager->find($filter, $path), $filter),
                $path,
                $filter
            );
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function resolve($path, $filter)
    {
        return $this->pathResolver->generateUrl($path, $filter);
    }

    /**
     * @inheritdoc
     */
    public function store(BinaryInterface $binary, $path, $filter)
    {
        $this->getFilesystem()->write($this->resolvePath($path, $filter), $binary->getContent());
    }

    /**
     * @inheritdoc
     */
    public function remove(array $paths, array $filters)
    {
        if (empty($paths) && empty($filters)) {
            return;
        }

        foreach ($paths as $path) {
            foreach ($filters as $filter) {
                $this->getFilesystem()->delete($this->resolvePath($path, $filter));
            }
        }
    }

    private function resolvePath($path, $filter)
    {
        return rtrim($filter, '/') . DIRECTORY_SEPARATOR . $path;
    }
}
