# API Images Bundle

Symfony bundle for easy implementation images to your GraphQL API ( bundle with GraphQL implementation and its documentation is [here](https://github.com/Youshido/GraphQLBundle) ). Bundle provides `UploadImageMutation`:
``` graphql
mutation {
  uploadImage(field: "image") {
    id
    url
    resized(width: 100, height: 100, mode: INSET) {
      url
    }
  }
}

```

Mutation assumes that request content-type is `multipart/form-data` and include image data in field that is passed as argument `field`.
Also bundle provides `ImageField` to use in your API like this:
``` graphql
{
  me {
    id
    firstName
    lastName
    image { // image field from bundle
      url
      resized(width: 100, height: 100, mode: INSET) {
        url
      }
    }
  }
}
```
or you can add arguments directly to the image field for your convenience.
``` graphql
{
  me {
    id
    firstName
    lastName
    small: image(width: 100, height: 100, mode: INSET) { // resized directly
      url
    }    
    medium: image(width: 500, height: 300, mode: OUTBOUND) { // different mode
      url
    }    
    fullSize: image {
      url
    }
  }
}
```

## How to use
* [Installation](#1-installation)
* [Configuration](#2-configuration)
* [Entity set-up](#3-set-up-your-entities)
  * [ORM way](#31-orm-set-up)
  * [ODM way](#31-odm-set-up)
* [GraphQL schema set-up](#4-set-up-graphql-schema)
  * [Mutation type](#41-add-uploadimagemutation-to-your-mutationtype)
  * [Custom type](#42-add-image-field-to-your-type)
  * [Resolver](#43-setupdate-image-in-your-field-resolver)

### 1. Installation:
> composer require youshido/api-images

### 2. Configuration:
#### 2.1 Enable bundle in your `AppKernel.php`:

``` php
$bundles[] = new Youshido\ImagesBundle\ImagesBundle()
```

#### 2.2. Add new routing in `routing.yml`:
``` yaml
images:
    resource: "@ImagesBundle/Controller/"
    type:     annotation

```

#### 2.3. Configurate bundle in `config.yml`
``` yaml
images:
    web_root: "%kernel.root_dir%/../web" #your app web root
    path_prefix: "uploads/images"        #folder in web root where images will be stored
    platform: orm                        #orm or odm
    driver: gd                           #imagine driver, can be gd, imagick or gmagick

```

### 3 Set-up your entities
#### 3.1 ORM set-up
Add image property and implement `ImageableInterface` to your entity:
```php
<?php

use Youshido\ImagesBundle\Entity\Interfaces\ImageableInterface;

/**
 * @ORM\Entity
 */
class YourEntity implements ImageableInterface
{

    // other your properties

  /**
   * @var Image
   *
   * @ORM\ManyToOne(targetEntity="Youshido\ImagesBundle\Entity\Image")
   */
  private $image;

  /**
   * @return Image
   */
  public function getImage()
  {
      return $this->image;
  }

  /**
   * @param Image $image
   *
   * @return User
   */
  public function setImage(Image $image = null)
  {
      $this->image = $image;

      return $this;
  }
```

#### 3.2 ODM set-up
Use `ImageableTrait` and implement `ImageableInterface` to your entity:
```php
<?php

use Youshido\ImagesBundle\Document\Interfaces\ImageableInterface;
use Youshido\ImagesBundle\Document\Traits\ImageableTrait;

/**
 * @MongoDB\Document()
 */
class Category implements ImageableInterface
{

    use ImageableTrait;

    //other properties
```

### 4. Set-up GraphQL schema:
#### 4.1 Add `UploadImageMutation` to your `MutationType`:
```php
<?php

use Youshido\ImagesBundle\GraphQL\Field\Mutation\UploadImageField;

class MutationType extends AbstractObjectType
{

    public function build($config)
    {

        $config->addFields([
            new UploadImageField(),

            // other mutations
        ]);

    }
}

```

#### 4.2 Add image field to your type:
``` php

use Youshido\ImagesBundle\GraphQL\Field\Query\ImageField;

class CategoryType extends AbstractObjectType
{

    public function build($config)
    {
        $config->addFields([
            // category fields
        
            new ImageField()
        ]);
    }

}
```

#### 4.3 Set/update image in your field resolver:
``` php
//for odm
$image = $dm->getRepository(Image::class)->find($imageId);
$yourEntity->setImage($image ? new EmbeddedImage($image) : null);

//for orm
$image = $em->getRepository(Image::class)->find($imageId);
$yourEntity->setImage($image);
```
