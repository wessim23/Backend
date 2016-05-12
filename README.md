# Backend
**❮ NOTE ❯** This bundle releases new versions on a regular basis. Make sure
to update your dependencies frequently to get the latest version.
[Check out the changelog](https://github.com/javiereguiluz/EasyAdminBundle/releases)
to learn about the new features and read the [UPGRADE guide](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/UPGRADE.md).

-----

EasyAdmin
=========

[![Build Status](https://travis-ci.org/javiereguiluz/EasyAdminBundle.svg?branch=master)](https://travis-ci.org/javiereguiluz/EasyAdminBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a3bfb8d9-7b2d-47ab-a95f-382af395bd51/mini.png)](https://insight.sensiolabs.com/projects/a3bfb8d9-7b2d-47ab-a95f-382af395bd51)
[![Coverage Status](https://coveralls.io/repos/javiereguiluz/EasyAdminBundle/badge.svg?branch=master)](https://coveralls.io/r/javiereguiluz/EasyAdminBundle?branch=master)
<sup><kbd>**SUPPORTS SYMFONY 2.x and 3.x**</kbd></sup>

<img src="https://raw.githubusercontent.com/javiereguiluz/EasyAdminBundle/master/Resources/doc/images/easyadmin-promo.png" alt="Symfony Backends created with EasyAdmin" align="right" />

EasyAdmin lets you create administration backends for Symfony applications
with unprecedented simplicity.

**Features**

  * **CRUD** operations on Doctrine entities (create, edit, list, delete).
  * Full-text **search**, **pagination** and column **sorting**.
  * Fully **responsive** design (smartphones, tablets and desktops).
  * Supports Symfony 2.x and 3.x.
  * Translated into tens of languages.
  * **Fast**, **simple** and **smart** where appropriate.

**Requirements**

  * Symfony 2.3+ or 3.x applications (Silex not supported).
  * Doctrine ORM entities (Doctrine ODM and Propel not supported).
  * Entities with composite keys or using inheritance are not supported.

Documentation
-------------

#### Getting Started Guide

The [Getting Started Guide](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/getting-started.md) explains how to
install the bundle and how to create your first backend. This guide is a must-
read before using EasyAdmin.

#### The Book

  * [Chapter 1 - General configuration](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/book/1-general-configuration.md)
  * [Chapter 2 - Design configuration](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/book/2-design-configuration.md)
  * [Chapter 3 - `list`, `search` and `show` views configuration](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/book/3-list-search-show-configuration.md)
  * [Chapter 4 - `edit` and `new` views configuration](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/book/4-edit-new-configuration.md)
  * [Chapter 5 - Actions configuration](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/book/5-actions-configuration.md)
  * [Chapter 6 - Menu configuration](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/book/6-menu-configuration.md)
  * [Chapter 7 - About this project](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/book/7-about.md)
  * [Appendix - Full configuration reference](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/book/configuration-reference.md)

#### Tutorials

  * [How to translate the backend](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/tutorials/i18n.md)
  * [How to define custom actions](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/tutorials/custom-actions.md)
  * [How to define custom options for entity properties](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/tutorials/custom-property-options.md)
  * [How to manage configuration for complex backends](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/tutorials/complex-backend-config.md)
  * [Tips and tricks](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/tutorials/tips-and-tricks.md)

#### Third-party bundles/services integrations

  * [How to upload files and images with VichUploaderBundle](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/tutorials/upload-files-and-images.md)
  * [How to integrate FOSUserBundle to manage users](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/tutorials/fosuserbundle-integration.md)
  * [How to use a WYSIWYG editor with IvoryCKEditorBundle](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/tutorials/wysiwyg-editor.md)
  * [How To integrate FOSRestBundle and EasyAdmin](https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/tutorials/fosrestbundle-integration.md)

> **❮ NOTE ❯** you are reading the documentation of the bundle's **development**
> version. You can also [read the documentation of the latest stable version ➜]
> (https://github.com/javiereguiluz/EasyAdminBundle/tree/v1.12.6/).

Demo Application
----------------

[easy-admin-demo](https://github.com/javiereguiluz/easy-admin-demo) is a complete
Symfony application created to showcase EasyAdmin features.

Installation
------------

### Step 1: Download the Bundle

```bash
$ composer require px/backend
```

This command requires you to have Composer installed globally, as explained
in the [Composer documentation](https://getcomposer.org/doc/00-intro.md).

### Step 2: Enable the Bundle

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new JavierEguiluz\Bundle\EasyAdminBundle\EasyAdminBundle(),
            new px\BackendBundle\pxBackendBundle(),
        );
    }

    // ...
}
```

### Step 3: Load the Routes of the Bundle

```yaml
# app/config/routing.yml
px_backend:
    resource: "@pxBackendBundle/Controller/"
    type:     annotation
    prefix:   /admin

easy_admin_bundle:
    resource: "@EasyAdminBundle/Controller/"
    type:     annotation
    prefix:   /admin


# ...
```

### Step 4: Prepare the Web Assets of the Bundle

```cli
# Symfony 2
php app/console assets:install 

# Symfony 3
php bin/console assets:install
```

That's it! Now everything is ready to create your first admin backend.

Your First Backend
------------------

Creating your first backend will take you less than 30 seconds. Let's suppose
that your Symfony application defines three Doctrine ORM entities called
`Product`, `Category` and `User`.

Open the `app/config/config.yml` file and add the following configuration:

```yaml
# app/config/config.yml
imports:
    - { resource: @pxBackendBundle/Resources/config/config.yml }
```

Open the `px/BackendBundle/Resources/config/config.yml` file and add the following configuration:

```yaml
# px/BackendBundle/Resources/config/config.yml
imports:
    - { resource: admin.yml }
easy_admin:
    entities:
        Ticket:
            class: AppBundle\Entity\Ticket
```

Open the `px/BackendBundle/Resources/config/admin.yml` file and add the following configuration:

```yaml
# px/BackendBundle/Resources/config/admin.yml
parameters:
    Ticket:
        entity_path: AppBundle\Entity\Ticket
        entity_name: AppBundle:Ticket
        table_id: dt_admin_table
        main_alias: d
        fields:
            0:
                name: id
                label: Id
                tabSortable: true
                tabVisible: true
                tabSearchable: true
                sClass: " center col-sm-2 col-md-2"

            1:
                name: actions
                label: Actions
                tabSortable: false
                tabVisible: true
                tabSearchable: false
                sClass: "col-sm-2 col-md-2 table-action center"
        default_order: 
            name: id
            index: 0
            sens: asc
```

**Congratulations! You've just created your first fully-featured backend!**
Browse the `/admin` URL in your Symfony application and you'll get access to
the admin backend:

![Default EasyAdmin Backend interface](https://raw.githubusercontent.com/javiereguiluz/EasyAdminBundle/master/Resources/doc/images/easyadmin-default-backend.png)

Keep reading the rest of the documentation to learn how to create complex backends.

License
-------

This software is published under the [MIT License](LICENSE.md)

