# API Images Bundle

Symfony bundle easy implement images to your GraphQL API ( bundle for GraphQL implementation and its documentation is [here](https://github.com/Youshido/GraphQLBundle) ). It provides `UploadImageMutation`:
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
Also bundle provides 'ImageField' to use in your API like this:
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

## How to use
* [Installation](#installation)
* [Configuration](#configuration)
* [Entity set-up](#)
  * [ORM way](#)
  * [ODM way](#)
* [GraphQL schema set-up](#)
  * [Mutation type](#)
  * [Custom type](#)
  * [Resolver](#)

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

### 3.Set-up your entities
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

    /**
     * @param ObjectTypeConfig $config
     *
     * @return mixed
     */
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
