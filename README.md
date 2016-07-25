Doctrine Manager
====

Usage
---

require `composer.json`
```json
{
    "require": {
        "foreverglory/doctrine-manager": "~1.0"
    }
}
```
add service
```yaml
services:
    doctrine.manager.example:
        class: Glory\DoctrineManager\DoctrineManager
        arguments: ['@doctrine']
```
add ClassName

```php
//src:DependencyInjection/AppExtension.php
namespace AppBundle\PayBundle\DependencyInjection;

class AppExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        //通过配置参数，设置manager的class
        $container->getDefinition('doctrine.manager.example')
                ->addMethodCall('setPayClass', [$config['app_class']]);

    }
}
```
