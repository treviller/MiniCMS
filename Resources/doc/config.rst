Configuration
=============

If you need to personnalize the bundle, you just have to add some lines
in the file 'app/config/config.yml' in your project.

1) Level access
---------------

You can change the default access level of your created pages :

.. code-block:: yaml

	# app/config/config.yml
	mini_cms:
	    default_access_level: public
    

Values : public / member / admin

2) Page versioning
------------------

If you want to enable page versioning, update your configuration as follows:

.. code-block:: yaml

	#app/config/config.yml
	mini_cms:
	    versioning: true
