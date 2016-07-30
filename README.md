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
namespace AppBundle\DependencyInjection;

class AppExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        //通过配置参数，设置manager的class
        $container->getDefinition('doctrine.manager.example')
                ->addMethodCall('setClass', [$config['app_class']]);

    }
}
```

black code
```php
$this->get('doctrine.manager.example')->find($id);
$this->get('doctrine.manager.example')->findAll();
$this->get('doctrine.manager.example')->findOneBy($criteria);
$this->get('doctrine.manager.example')->findBy($criteria);
$this->get('doctrine.manager.example')->create($properties);
$this->get('doctrine.manager.example')->update($properties);
$this->get('doctrine.manager.example')->delete($properties);
$this->get('doctrine.manager.example')->getManager();
$this->get('doctrine.manager.example')->getRepository();
```