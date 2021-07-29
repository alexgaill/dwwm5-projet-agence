<?php
namespace App\EventSubscriber;

use App\Entity\Appointment;
use App\Repository\PropertyRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

class EasyAdminSubscriber implements EventSubscriberInterface {

    public function __construct(PropertyRepository $repository)
    {
        $this->repo = $repository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ["getProperty"]
        ];
    }

    public function getProperty(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Appointment)) {
            return;
        }
        
        $property = $this->repo->find($entity->property);
        $entity->setProperty($property);
    }

}