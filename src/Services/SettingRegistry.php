<?php


namespace App\Services;


use App\Entity\Setting;
use App\Entity\SettingGroup;
use App\Repository\SettingGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class SettingRegistry
{
    private $em;

    /**
     * @var UploaderHelper
     */
    private $uploaderHelper;

    /**
     * @var Request|null
     */
    private $request;

    public function __construct(EntityManagerInterface $em, UploaderHelper $uploaderHelper, RequestStack $request)
    {
        $this->em = $em;
        $this->uploaderHelper = $uploaderHelper;
        $this->request = $request->getCurrentRequest();
    }

    public function get($name){
        if (preg_match('/[a-z0-9]{1,}(\/[a-z0-9]{1,})?/', $name)) {
            $names = explode('/', $name);

            $settingGroupName = $names[0];

            $settingsGroupData = $this->getFromDb($settingGroupName);

            // Request for one setting
            if (count($names) == 2) {
                return isset($settingsGroupData[$names[1]]) ? $settingsGroupData[$names[1]] : false;
            } else { // Request for setting group
                return $settingsGroupData;
            }
        }
    }

    public function getFileUrl($file){
        $result = null;

        if(!empty($file)){
            $entity = new Setting();
            $entity->setFile($file);
            $result = $this->uploaderHelper->asset($entity, 'uploadedFile');
            if(!is_null($this->request)){
                $result = $this->request->getUriForPath($result);
            }
        }
        return $result;
    }

    protected function getFromDb($groupName){
        /** @var SettingGroupRepository $repository */
        $repository = $this->em->getRepository(SettingGroup::class);
        $result = false;
        /** @var SettingGroup $data */
        $data = $repository->findByName($groupName);
        if(!is_null($data)){
            $result = [];
            foreach ($data->getSettings() as $setting){
                if($setting->getType() == Setting::TYPE_FILE){
                    $result[$setting->getName()] = $this->getFileUrl($setting->getFile());
                }
                else{
                    $result[$setting->getName()] = $setting->getValue();
                }
            }
        }

        return $result;
    }
}