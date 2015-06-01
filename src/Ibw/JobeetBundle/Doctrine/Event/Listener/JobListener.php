<?php
namespace Ibw\JobeetBundle\Doctrine\Event\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class JobListener
{
    /** @var ContainerInterface */
    protected $container;

    /**
    * @param ContainerInterface @container
    */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @ORM\PostLoad
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if (method_exists($entity, 'setContainer')) {
            $entity->setContainer($this->container);
        }

        $em = $eventArgs->getEntityManager();
        $repository = $em->getRepository('IbwJobeetBundle:Job');
        if (method_exists($repository, 'setContainer')) {
            $repository->setContainer($this->container);
        }
    }
}
