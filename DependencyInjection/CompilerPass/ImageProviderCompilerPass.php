<?php
/**
 * Date: 21.10.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\ImagesBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Youshido\ImagesBundle\Services\Provider\ODMProvider;
use Youshido\ImagesBundle\Services\Provider\ORMProvider;

class ImageProviderCompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definition = new Definition();
        $db         = $container->getParameter('api_images.config.platform');

        switch ($db) {
            case 'orm':
                $definition->setClass(ORMProvider::class);
                $definition->addArgument(new Reference('doctrine.orm.entity_manager'));
                break;

            case 'odm':
                $definition->setClass(ODMProvider::class);
                $definition->addArgument(new Reference('doctrine_mongodb.odm.document_manager'));
                break;
        }

        $definition->addArgument(new Reference('validator'));
        $definition->addArgument(new Reference('api_images.loader'));
        $definition->addArgument(new Reference('request_stack'));

        $container->setDefinition('api_images.provider', $definition);
    }
}
