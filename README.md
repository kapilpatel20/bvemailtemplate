Documentation
=============

1. Run below command to install from composer

    composer require kapilpatel20/bvemailtemplate dev-master

2. Add bundle in AppKernel.php

    new BviTemplateBundle\BviTemplateBundle(),

3. Export route file in your app/config/routing.yml as below

    BviTemplateBundle:
        resource: "@BviTemplateBundle/Resources/config/routing.yml"
        prefix:   /

4. Install assets using below command

    php app/console assets:install

5. Update your db schema using belwo command

    php app/console doctrine:schema:update --force
