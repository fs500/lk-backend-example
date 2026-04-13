<?php


namespace App\Controller\API;

use App\Entity\Builder;
use App\Entity\Contacts;
use App\Entity\Notification;
use App\Entity\SocialNetwork;
use App\Repository\BuilderRepository;
use App\Repository\ContactsRepository;
use App\Repository\NotificationRepository;
use App\Repository\SocialNetworkRepository;
use App\Services\FileUrlHelper;
use App\Services\SettingRegistry;
use App\View\CommonView;
use App\View\NotificationView;
use App\View\ScriptsView;
use App\View\SocialNetworkView;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;


/**
 * Class CommonController
 * @package App\Controller\API
 *
 * @Route("/api",name="api_common_")
 */
class CommonController extends AbstractController
{

    /**
     * @var FileUrlHelper
     */
    private FileUrlHelper $fileUrlHelper;

    public function __construct(FileUrlHelper $fileUrlHelper)
    {
        $this->fileUrlHelper = $fileUrlHelper;
    }

    /**
     * @param SocialNetworkRepository $networkRepository
     * @param ContactsRepository $contactsRepository
     * @param SettingRegistry $settingRegistry
     * @param NotificationRepository $notificationRepository
     * @return JsonResponse
     *
     * @OA\Get(
     *     tags={"Общее"},
     *     path="/api/common",
     *     summary="Общие данные",
     *     @OA\Response(
     *       response=200,
     *       description="Общие данные по сайту",
     *       @OA\JsonContent(ref="#/components/schemas/Common")
     *     )
     * )
     *
     * @Route("/common", "index")
     */
    public function index(
        SocialNetworkRepository $networkRepository,
        ContactsRepository $contactsRepository,
        SettingRegistry $settingRegistry,
        NotificationRepository $notificationRepository
    ){
        $contacts = $contactsRepository->findOneBy([]);
        $sn = $networkRepository->findAll();
        $scripts = $settingRegistry->get('scripts');
        $legalText = $this->getLegalTextWithDate($settingRegistry->get('legal/text'));
        $notification = $notificationRepository->findCurrent();

        $view = $this->populateView($contacts, $sn, $scripts, $legalText, $notification);

        return new JsonResponse($view);
    }

    /**
     * @param Contacts|null $contacts
     * @param SocialNetwork[] $sn
     * @param $scripts
     * @param $legalText
     * @param Notification $notification
     * @return CommonView
     */
    protected function populateView($contacts, $sn, $scripts, $legalText, $notification){
        $view = new CommonView();
        $view->legalText = $legalText;
        if(!is_null($contacts)){
            $view->phone = $contacts->getPhone();
            $view->email = $contacts->getEmail();
        }

        foreach ($sn as $n){
            $sView = new SocialNetworkView();
            $sView->icon = $this->fileUrlHelper->get($n, 'iconFile', $n->getIcon());
            $sView->url = $n->getUrl();
            $view->socialNetworks[] = $sView;
        }

        $view->scripts = new ScriptsView();
        $view->scripts->head = $scripts['head'];
        $view->scripts->bodyOpen = $scripts['bodyOpen'];
        $view->scripts->bodyClose = $scripts['bodyClose'];

        if(!is_null($notification)){
            $view->notification = new NotificationView();
            $view->notification->header = $notification->getHeader();
            $view->notification->text = $notification->getText();
            $view->notification->image = $this->fileUrlHelper->get($notification, 'imageFile', $notification->getImage());
            $view->notification->buttonText = $notification->getButtonText();
            $view->notification->buttonUrl = $notification->getButtonUrl();
        }

        return $view;
    }

    protected function getLegalTextWithDate($text){
        if(strpos($text, '{date}') !== false){
            $date = new DateTime();
            $months = [
                1 => 'января',
                2 => 'февраля',
                3 => 'марта',
                4 => 'апреля',
                5 => 'мая',
                6 => 'июня',
                7 => 'июля',
                8 => 'августа',
                9 => 'сентября',
                10 => 'октября',
                11 => 'ноября',
                12 => 'декабря',
            ];
            $dateText = $date
                ->format('d') . " " .
                $months[$date->format('n')] . " " .
                $date->format('Y') . " г."
            ;
            $text = str_replace('{date}', $dateText, $text);
        }
        return $text;
    }

}