<?php
namespace Ibw\JobeetBundle\Listener\Event;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

use Ibw\JobeetBundle\Entity\Job;
use Ibw\JobeetBundle\Repository\JobRepository;

class MyListener
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
     * @param LifecycleEventArgs $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $this->injectContainer($eventArgs);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $this->injectContainer($eventArgs);
    }

    /**
     * Inject the service container into Entity and Repository
     *
     * @param LifecycleEventArgs $eventArgs
     */
    protected function injectContainer(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof Job) {
            $entity->setContainer($this->container);
        }

        $em = $eventArgs->getEntityManager();
        $repository = $em->getRepository('IbwJobeetBundle:Job');
        if ($repository instanceof JobRepository) {
            $repository->setContainer($this->container);
        }
    }
}
