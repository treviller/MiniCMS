MiniCMSBundle
=============

The MiniCMSBundle provide some basic files to implement a CMS quickly. 

Features include:

- Backend functionalities
- Secure access to the backend via logging
- TinyMCE implementation for page creation
- Page versioning
- Customizable access levels on different pages

Requirements
============

- Symfony 3.x
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

Then, you needs to copy assets into your web folder:
```console
$ php bin/console assets:install
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

Step 3: Install StofDoctrineExtensionsBundle
--------------------------------------------

First, you need to add this bundle to the list of registered bundles in 'AppKernel.php' in your project :

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

         new StofDoctrineExtensionsBundle(),
        );

        // ...
    }

    // ...
}
```

Then, you need to configure it. For this, you just have to add at least 
these lines at the end of the file "app/config/config.yml" in your project :

```yaml
    
stof_doctrine_extensions:
    orm:
        default:
            sluggable: true

```

Step 4: Routing
---------------

You need to add this route in the file "app/config/routing.yml" in your project:

```yaml
minicms:
    resource: "@MiniCMSBundle/Resources/config/routing.yml"
    prefix: /
    
```

Step 5: Security
----------------

If you want to correctly enable logging, you just have to add these lines in "app/config/security.yml" :

```yaml
    access_control:
       - { path: ^/admin, roles: ROLE_ADMIN }
```

All the rest of this file can be customizable as you want.

Step 6: Configure database
--------------------------
Create a database and edit "database_name" in the file "app/config/parameters.yml"

Use this command to create tables in this base : 

```console
$ php bin/console doctrine:schema:update --force
```

The MiniCMSBundle is now ready to use ! 

Configuration
=============

Some parameters can be configurated. See [config.rst](https://github.com/treviller/MiniCMS/blob/master/Resources/doc/config.rst) file for more information.

License
=======

This bundle is under the MIT license. See the complete license in the bundle.

About
=====

MiniCMSBundle is an initiative as part of [OpenClassroom](https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony) course.
