# API Images Bundle

### Bundle have dependencies to [knplabs/knp-gaufrette-bundle](https://github.com/KnpLabs/KnpGaufretteBundle) and [liip/imagine-bundle](https://github.com/liip/LiipImagineBundle)

### Install via Composer:
> composer require youshido/api-images

### Enable in your AppKernel.php:

``` php
new Liip\ImagineBundle\LiipImagineBundle(),
new Youshido\ApiImagesBundle\ApiImagesBundle(),
new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
```

### Create your image class:
``` php
<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Youshido\ApiImagesBundle\Entity\BaseImage;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Image extends BaseImage
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    //other properties
}
```

### Configure bundle:
``` yaml
api_images:
    image_model: CoreBundle\Entity\Image
```

### Configure Gaufrette bundle
``` yaml
knp_gaufrette:
    stream_wrapper: ~
    adapters:
        images:
            local:
                directory: %kernel.root_dir%/../web/uploads/images
    filesystems:
        images:
            adapter: images

```

#### Configure Imagine bundle:
``` yaml
liip_imagine:
    loaders:
        stream.project_images:
            stream:
                wrapper: gaufrette://images

    data_loader: stream.project_images
    cache: youshido.images.resolver

    resolvers:
       default:
          web_path: ~

    filter_sets:
        dynamic:    #required filter
            quality: 100
            filters:
                thumbnail: { size: [100, 100], mode: outbound } #default size
```

### Override imagine config with our:
``` yaml
parameters:
    liip_imagine.cache.manager.class: Youshido\ApiImagesBundle\Service\Manager\CacheManager
    liip_imagine.data.manager.class: Youshido\ApiImagesBundle\Service\Manager\DataManager
    liip_imagine.filter.manager.class: Youshido\ApiImagesBundle\Service\Manager\FilterManager
```

### Usage
``` php
/** @var $container ContainerInterface */

$imageProvider = $container->get('youshido.image_provider');

//uploading via request
$image = $imageProvider->loadFromRequest($field); //field - name of file in request

//uploading via file
$image = $imageProvider->loadByFile($file); //file - instance of Symfony\Component\HttpFoundation\File\UploadedFile


//uploading via url
$image = $imageProvider->loadFromUrl($url);


$imageHelper = $container->get('youshido.image_helper');

//resizing
$image = $imageHelper->resize($image, $width, $height, $mode);  //mode cat be "INSET" or "OUTBOUND" (see imagine documentation)
echo $image['url'];


``` 

#### Set resolver if you using AmazonS3 storage in Gaufrette:
``` yaml
youshido.images.path_resolver.default_class: Youshido\ApiImagesBundle\Service\PathResolver\AmazonS3Resolver
```    
