<?php


namespace App\Services;


use App\Entity\Link;
use App\Entity\News;
use App\Entity\Project;
use App\View\LinkView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class LinkHelper
{

    /**
     * @var FileUrlHelper
     */
    private FileUrlHelper $fileUrlHelper;

    /**
     * @var Request|null
     */
    private ?Request $request;

    public function __construct(
        FileUrlHelper $fileUrlHelper,
        RequestStack $requestStack
    )
    {
        $this->fileUrlHelper = $fileUrlHelper;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function get(?Link $link = null){
        $result = null;
        if(!is_null($link) && !empty($link->getType())){
            $result = new LinkView();
            $result->text = $link->getHeader();
            $result->popup = $link->isPopup();
            switch ($link->getType()){
                case Link::TYPE_URL:
                    $result->data = [
                        'type' => LinkView::TYPE_URL,
                        'path' => [$link->getUrl()]
                    ];
                    break;
                case Link::TYPE_FILE:
                    $result->data = [
                        'type' => LinkView::TYPE_FILE,
                        'path' => [$this->fileUrlHelper->get($link, 'uploadedFile', $link->getFile())]
                    ];
                    break;
                case Link::TYPE_PAGE:
                    $path = $link->getPage();
                    $result->data = [
                        'type' => LinkView::TYPE_PAGE,
                        'path' => [$path]
                    ];
                    break;
                case Link::TYPE_FLATS_VISUAL:
                    $result->data = [
                        'type' => LinkView::TYPE_FLATS_VISUAL,
                        'path' => ['index']
                    ];
                    break;
                case Link::TYPE_FLATS_PARAMETER:
                    $result->data = [
                        'type' => LinkView::TYPE_FLATS_PARAMETER,
                        'path' => ['index']
                    ];
                    break;
                case Link::TYPE_LIVE_BROADCAST:
                    $result->data = [
                        'type' => LinkView::TYPE_LIVE_BROADCAST,
                        'path' => ['index']
                    ];
                    break;
                case Link::TYPE_NEWS_LIST:
                    $result->data = [
                        'type' => LinkView::TYPE_NEWS,
                        'path' => [News::INDEX]
                    ];
                    break;
                default:
                    $result = null;
                    break;
            }
        }
        return $result;
    }
}