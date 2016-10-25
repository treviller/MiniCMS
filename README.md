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
- [FOSUserBundle](https://packagist.org/packages/friendsofsymfony/user-bundle) dev-master
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

Step 4: Routing
---------------

You need to add some routes in the file "app/config/routing.yml" in your project:

```yaml
minicms:
    resource: "@MiniCMSBundle/Resources/config/routing.yml"
    prefix: /

fos_user:
    resource: "@FOSUserBundle/Resources/config/routing/security.xml"
    
fos_user_register:
    resource: "@FOSUserBundle/Resources/config/routing/registration.xml"
    prefix: /register
    
```

Step 5: Configure database
--------------------------
Create a database and edit "database_name" in the file "app/config/parameters.yml"

Use this command to create tables in this base : 

```console
$ php bin/console doctrine:schema:update --force
```

Step 6: Add an administrator
----------------------------

You have to create a user with admin role, to access backend functions of MiniCMSBundle.

Use this command to create an user :

```console
$ php bin/console fos:user:create name mail password
```

And then grant it some access :

```console
$ php bin/console fos:user:promote name ROLE_ADMIN
```
The MiniCMSBundle is now ready to use ! 

Configuration
=============

Some parameters can be configurated. See [config.rst]() file for more information.

License
=======

This bundle is under the MIT license. See the complete license in the bundle.

About
=====

MiniCMSBundle is an initiative as part of [OpenClassroom](https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony) course.
