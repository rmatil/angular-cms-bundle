## Installation

* composer install
* add FOSUserBundle to AppKernel
* add JMSSerializer to AppKernel
* add DoctrineMigrationsBundle to AppKernel
* add rmatilCmsBundle to AppKernel

```php
    
     public function registerBundles()
        {
            $bundles = [
                // ....
                new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
                new JMS\SerializerBundle\JMSSerializerBundle(),
                new FOS\UserBundle\FOSUserBundle(),
                new Vich\UploaderBundle\VichUploaderBundle(),
                new rmatil\CmsBundle\rmatilCmsBundle(),
                new AppBundle\AppBundle(),
            ];
    
            if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
                $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
                $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
                $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            }
    
            return $bundles;
        }
```

* Add routing for FOSUser to `routing.yml`
* Add routing for CmsBundle to `routing.yml`

```yaml

    # rmatil CmsBundle
    rmatil_cms:
        resource: "@rmatilCmsBundle/Resources/config/routing.yml"
        prefix:   "/api"
    
    # FOS UserBundle
    fos_user:
        resource: "@FOSUserBundle/Resources/config/routing/all.xml"

    
```

* Add the following to `config.yml`

```yaml

    # FOS UserBundle
    fos_user:
        db_driver: orm
        firewall_name: main # must match the firewall name where fos_user_bundle is configured
        user_class: rmatil\CmsBundle\Entity\User
        registration:
            confirmation:
                enabled: true
    
    # Doctrine Migrations
    doctrine_migrations:
        dir_name: "%kernel.root_dir%/../src/rmatil/CmsBundle/Resources/doctrine-migrations"
        namespace: Application\Migrations
        table_name: migration_versions
        name: Application Migrations

```


* Add the following to `security.yml`

```yaml

    encoders:
        FOS\UserBundle\Model\UserInterface: bcrypt
    
    role_hierarchy:
        ROLE_MEMBER:      [ROLE_USER]
        ROLE_ADMIN:       [ROLE_MEMBER]
        ROLE_SUPER_ADMIN: [ROLE_ADMIN]

    # http://symfony.com/doc/current/book/security.html#where-do-users-come-from-user-providers
    providers:
        fos_userbundle:
            id: fos_user.user_provider.username
            
    firewalls:
        # disables authentication for assets and the profiler, adapt it according to your needs
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false

        # Basic Authentication for API requests
        api:
            pattern: /api/*
            stateless: true
            anonymous: true
            form_login: false
            http_basic:
                provider: fos_userbundle

        # Form Login Authentication for all other requests
        main:
            # activate different ways to authenticate

            # http_basic: ~
            # http://symfony.com/doc/current/book/security.html#a-configuring-how-your-users-will-authenticate

            # form_login: ~
            # http://symfony.com/doc/current/cookbook/security/form_login_setup.html

            # FOS UserBundle
            pattern: ^/
            form_login:
                provider: fos_userbundle
                csrf_token_generator: security.csrf.token_manager
                # if you are using Symfony < 2.8, use the following config instead:
                # csrf_provider: form.csrf_provider

            logout:       true
            anonymous:    true
    
    access_control:
        - { path: ^/login$, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/register, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/resetting, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/api/, role: ROLE_ADMIN }
```

* Add the following to `web/.htaccess` and replace `app_dev.php` with `app.php` for production

```
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{HTTP_HOST} ^dev.flimsfestival.rmatil.vagrant
    RewriteRule ^(.*)$ app_dev.php [QSA,L]
    # Rewrite all other queries to the front controller.
    # RewriteRule ^ %{ENV:BASE}/app.php [L]
```

* Change the path in `AppKernel` for files to `tmp` folder:

```php

    // ...
    
    public function getCacheDir()
    {
//        return dirname(__DIR__).'/var/'.$this->environment.'/cache';
        return '/tmp/var/'.$this->environment.'/cache';
    }

    public function getLogDir()
    {
//        return dirname(__DIR__).'/var/'.$this->environment.'/logs';
        return '/tmp/var/'.$this->environment.'/logs';
    }
    
    // ...

```
* Change the path in `config.yml` for sessions:

```yaml

    session:
        # http://symfony.com/doc/current/reference/configuration/framework.html#handler-id
        handler_id:  session.handler.native_file
        #save_path:   "%kernel.root_dir%/../var/sessions/%kernel.environment%"
        save_path:   "/tmp/var/sessions/%kernel.environment%"
```

* Add the configuration for Vich Uploader Bundle in `config.yml`:

```yaml

    # Vich Uploader Bundle
    vich_uploader:
        db_driver: orm
    
        mappings:
            upload:
                uri_prefix:         /upload
                upload_destination: '%kernel.root_dir%/../web/upload'
                namer:              vich_uploader.namer_origname
                inject_on_load:     false
                delete_on_update:   true
                delete_on_remove:   true
```

## File Upload

* Open correct `php.ini`: `sudo vim /etc/php/7.1/fpm/php.ini`
* Check for `file_uploads`. Should be `On`
* Check for `post_max_size`.
* Check for `upload_max_filesize`. Should have the same size as `post_max_size`
* Restart apache
* Make sure, that the upload folder has write permissions: `chmod +x web/uploads`
* Make sure, file uploads work. If not check [http://stackoverflow.com/questions/3586919/why-would-files-be-empty-when-uploading-files-to-php](http://stackoverflow.com/questions/3586919/why-would-files-be-empty-when-uploading-files-to-php)
