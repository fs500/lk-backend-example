<?php


namespace App\Event\EntityListener;


use Doctrine\ORM\Mapping\DefaultEntityListenerResolver;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EntityListenerResolver extends DefaultEntityListenerResolver
{

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function resolve($className)
    {
        $listener = parent::resolve($className);
        if ($listener instanceof ContainerAwareInterface) {
            $listener->setContainer($this->container);
        }
        return $listener;
    }
}