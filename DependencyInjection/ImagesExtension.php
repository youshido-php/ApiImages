<?php

namespace Youshido\ImagesBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class ImagesExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $this->setContainerParam($container, 'web_root', $config['web_root']);
        $this->setContainerParam($container, 'path_prefix', $config['path_prefix']);
        $this->setContainerParam($container, 'driver', $config['driver']);
        $this->setContainerParam($container, 'platform', $config['platform']);

        $this->setContainerParam($container, 'host', $config['routing']['host']);
        $this->setContainerParam($container, 'scheme', $config['routing']['scheme']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

    private function setContainerParam(ContainerBuilder $container, $parameter, $value)
    {
        $container->setParameter(sprintf('api_images.config.%s', $parameter), $value);
    }
}
