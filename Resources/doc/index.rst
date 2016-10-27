Documentation
=============

This file describes the main functionalities of MiniCMSBundle.
You will find all informations you need to use this bundle as you want.


Page creation
-------------

Each page can be created with a title, a content of course but can also be classified in some category.
You can also defined an access level for this page. Thus, you could create some members or administrators area.
By default, all created pages will have access set to public. (`How to configure default access level: <https://github.com/treviller/MiniCMS/blob/master/Resources/doc/config.rst>`_

When a page is saved in database, you can find it in admin homepage, but you can also access to this page via its url:

yoursite/page/slug-of-your-category/slug-of-your-page

`More information about slugs <https://github.com/Atlantic18/DoctrineExtensions/blob/master/doc/sluggable.md>`_


Page edition
------------

You could edit all of your pages in administration, when you select it.
This also allow you to delete it, or to back to another version of this page from the editor.


Page versioning
---------------

If versioning is enabled, each change on pages will be saved in database.

By the way, you could restore some saved version of a page.

`How to configure versioning <https://github.com/treviller/MiniCMS/blob/master/Resources/doc/config.rst>`_
