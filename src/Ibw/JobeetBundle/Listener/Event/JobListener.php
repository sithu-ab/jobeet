<?php
namespace Ibw\JobeetBundle\Listener\Event;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

use Ibw\JobeetBundle\Entity\Job;

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
     * @param LifecycleEventArgs $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof Job) {
            $entity->setContainer($this->container);
        }

        $em = $eventArgs->getEntityManager();
        $repository = $em->getRepository('IbwJobeetBundle:Job');
        if ($entity instanceof Job ) {
            $repository->setContainer($this->container);
        }
    }
}
