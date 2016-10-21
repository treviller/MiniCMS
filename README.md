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



Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

Step 3: Install Required Bundles
--------------------------------

Install required bundles

Step 4: Configure database
--------------------------
Create a database and edit "database_name" in "app/config/parameters.yml"

Use this command to create tables in this base : "php bin/console doctrine:schema:update --force"

The MiniCMSBundle is ready to use ! 

License
=======

This bundle is under the MIT license. See the complete license in the bundle.

About
=====

MiniCMSBundle is an initiative as part of [OpenClassroom](https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony) course.
