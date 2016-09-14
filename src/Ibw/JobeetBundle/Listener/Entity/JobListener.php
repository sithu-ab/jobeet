<?php
namespace Ibw\JobeetBundle\Listener\Entity;

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
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function postLoad(Job $entity, LifecycleEventArgs $eventArgs)
    {
        if ($entity instanceof Job) {
            $entity->setContainer($this->container);
        }

        $em = $eventArgs->getEntityManager();
        $repository = $em->getRepository('IbwJobeetBundle:Job');
        if ($entity instanceof Job) {
            $repository->setContainer($this->container);
        }
    }
}
