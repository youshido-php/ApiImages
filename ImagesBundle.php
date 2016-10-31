<?php

namespace Youshido\ImagesBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Youshido\ImagesBundle\DependencyInjection\CompilerPass\ImageProviderCompilerPass;

class ImagesBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ImageProviderCompilerPass());
    }

}
