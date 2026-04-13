<?php


namespace App\Event\Subscriber;


use Eyetronic\AjaxUploaderBundle\Event\NewFileEvent;
use Liip\ImagineBundle\Service\FilterService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CreateAjaxFileThumbnailSubscriber implements EventSubscriberInterface
{
    /**
     * @var FilterService
     */
    protected $imagine;

    function __construct(FilterService $imagine)
    {
        $this->imagine = $imagine;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            NewFileEvent::NAME => "createThumbnail"
        ];
    }

    public function createThumbnail(NewFileEvent $event)
    {

        $fileType = mime_content_type($event->getTempFile()->getFile()->getPathname());

        if (in_array($fileType, ["image/jpeg", "image/png", "image/gif"])) {
            $response = $event->getResponse();
            $extraData = $response->getExtraData();

            $extraData['thumbnail'] =
                $this->imagine->getUrlOfFilteredImage(
                    $response->getUrl(),
                    "ajax_uploader"
                )
            ;

            $response->setExtraData($extraData);
        }
    }
}