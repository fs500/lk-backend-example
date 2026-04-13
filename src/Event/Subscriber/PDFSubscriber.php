<?php


namespace App\Event\Subscriber;

use App\Entity\Building;
use App\Entity\BuildingProgress;
use App\Entity\Contacts;
use App\Entity\Flat;
use App\Entity\Floor;
use App\Entity\Page;
use App\Message\PDFNotification;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\MessageBusInterface;

class PDFSubscriber implements EventSubscriberInterface
{
    /**
     * @var Request|null
     */
    private ?Request $request;


    private $messageBus;

    public function __construct(RequestStack $requestStack, MessageBusInterface $messageBus)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->messageBus = $messageBus;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::onFlush
        ];
    }

    public function onFlush(OnFlushEventArgs $eventArgs){
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            $this->updatePdf($entity);
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $this->updatePdf($entity);
        }
    }

    protected function updatePdf($entity){
        $classes = [
            Flat::class,
            Floor::class,
            Page::class,
            Building::class,
            BuildingProgress::class,
            Contacts::class
        ];
        if(
            in_array(get_class($entity),$classes) &&
            $this->request &&
            $this->messageBus
        )
        {
            $message = new PDFNotification();
            if($entity instanceof Flat){
                $message->setFlat($entity->getNumber());
            }
            if($entity instanceof Floor){
                $message->setFloor($entity->getNumber());
            }
            $exec = true;
            if($entity instanceof Page){
                $exec = $exec && $entity->getType() == Page::TYPE_INDEX;
            }
            if($exec){
                $this->messageBus->dispatch($message);
            }
        }
    }
}