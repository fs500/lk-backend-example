<?php


namespace App\Services;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class FileUrlHelper
{
    private UploaderHelper $uploaderHelper;

    private ?Request $request;

    public function __construct(
        UploaderHelper $uploaderHelper,
        RequestStack $requestStack
    )
    {
        $this->uploaderHelper = $uploaderHelper;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function get($entity, $fileAttr, $attrValue = null){
        $result = null;

        if(!is_null($attrValue)){
            $result = $this->uploaderHelper->asset($entity, $fileAttr);
            if(!is_null($this->request)){
                $result = $this->request->getUriForPath($result);
            }
        }
        return $result;
    }
}