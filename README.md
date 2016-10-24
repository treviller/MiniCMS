MiniCMSBundle
=============

The MiniCMSBundle provide some basic files to implement a CMS quickly. 

Features include:

- Backend functionalities
- Secure access to the backend via logging
- TinyMCE implementation for creating pages


Requirements
============

- Symfony 3.x
- [FOSUserBundle](https://packagist.org/packages/friendsofsymfony/user-bundle) 2.0.x-dev
- [Doctrine-extensions-bundle](https://packagist.org/packages/stof/doctrine-extensions-bundle) 1.2.x

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require treviller/mini-cms-bundle "~1"
```

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new treviller\MiniCMSBundle\MiniCMSBundle(),
        );

        // ...
    }

    // ...
}
```

Step 3: Install Required Bundles
--------------------------------

First, you need to add these bundles to the list of registered bundles in 'AppKernel.php' in your project :

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

         new StofDoctrineExtensionsBundle(),
        	new FOS\UserBundle\FOSUserBundle(),
        );

        // ...
    }

    // ...
}
```

Then, you need to configure them. For this, you just have to add at least 
these lines at the end of the file "app/config/config.yml" in your project :

```yaml

fos_user:
    db_driver: orm
    firewall_name: main
    user_class: MiniCMSBundle\Entity\User
    
stof_doctrine_extensions:
    orm:
        default:
            sluggable: true

```

Step 4: Configure database
--------------------------
Create a database and edit "database_name" in the file "app/config/parameters.yml"

Use this command to create tables in this base : 

```console
$ php bin/console doctrine:schema:update --force
```
The MiniCMSBundle is now ready to use ! 

License
=======

This bundle is under the MIT license. See the complete license in the bundle.

About
=====

MiniCMSBundle is an initiative as part of [OpenClassroom](https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony) course.
