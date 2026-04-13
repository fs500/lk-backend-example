<?php

namespace App\Command;

use App\Entity\YandexYmlCategory;
use App\Entity\YandexYmlCurrency;
use App\Entity\YandexYmlSet;
use App\Entity\YandexYmlShop;
use Doctrine\ORM\EntityManagerInterface;
use Eyetronic\YandexBuildingYml\Objects\Currency;
use Eyetronic\YandexBuildingYml\Objects\Offer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class YmlCommand extends Command
{
    protected static $defaultName = 'app:yml';
    protected static $defaultDescription = '';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em, string $name = null)
    {
        $this->em = $em;
        parent::__construct($name);
    }

    public function execute(InputInterface $input, OutputInterface $output){
        $this->clear();
        $this->fillData();
        return self::SUCCESS;
    }

    public function fillData(){
        $currency = new YandexYmlCurrency();
        $currency->setName(Currency::CURRENCY_ID_RUR)->setRate(1);
        $this->em->persist($currency);

        $shop = new YandexYmlShop();
        $shop
            ->setName("Браун Хаус")
            ->setUrl("https://brownhouse.ru/")
            ->setCurrency($currency)
            ->setEmail('info@brownhouse.ru')
            ->setParamConversion(1)
            ->setVendor("ГК «Академия»")
            ->setParamEstateType(Offer::PARAM_ESTATE_TYPE_PRIMARY)
            ->setParamAddress("дер. Новое Девяткино, ул. Энергетиков")
            ->setParamLatitude(60.057551)
            ->setParamLongitude(30.482163)
            ->setParamTotalFloor(9)
            ->setParamSubwayDistance(15)
            ->setParamSubwayDistanceUnit(Offer::PARAM_SUBWAY_DISTANCE_UNIT_TRANSPORT)
            ->setParamSite("https://brownhouse.ru/")
            ->setParamPhone("+7 (812) 321-16-16")
        ;
        $this->em->persist($shop);

        $baseCategory = new YandexYmlCategory();
        $baseCategory
            ->setHeader("Квартира")
            ->setShop($shop)
        ;
        $this->em->persist($baseCategory);
        foreach (YandexYmlCategory::getRoomsTypeChoices() as $rooms => $header){
            $category = new YandexYmlCategory();
            $this->em->persist($category);
            $category
                ->setShop($shop)
                ->setParent($baseCategory)
                ->setHeader($header)
                ->setRoomsType($rooms)
            ;
        }

        $set = new YandexYmlSet();
        $set
            ->setShop($shop)
            ->setName("Купить квартиру в новостройке в Санкт-Петербурге")
            ->setUrl("https://brownhouse.ru/")
        ;
        $this->em->persist($set);

        $this->em->flush();
    }

    public function clear(){
        $categories = $this->em->getRepository(YandexYmlCategory::class)->findAll();
        $pCategories = [];
        foreach ($categories as $category){
            if(is_null($category->getParent())){
                $pCategories[] = $category;
            }
            else{
                $this->em->remove($category);
            }
        }

        foreach ($pCategories as $c){
            $this->em->remove($c);
        }

        $shops = $this->em->getRepository(YandexYmlShop::class)->findAll();
        foreach ($shops as $shop){
            $this->em->remove($shop);
        }

        $currencies = $this->em->getRepository(YandexYmlCurrency::class)->findAll();
        foreach ($currencies as $currency){
            $this->em->remove($currency);
        }

        $this->em->flush();
        $this->em->getConnection()->executeQuery('ALTER TABLE yandex_yml_shop AUTO_INCREMENT = 1');
        $this->em->getConnection()->executeQuery('ALTER TABLE yandex_yml_currency AUTO_INCREMENT = 1');
        $this->em->getConnection()->executeQuery('ALTER TABLE yandex_yml_category AUTO_INCREMENT = 1');
        $this->em->getConnection()->executeQuery('ALTER TABLE yandex_yml_offer AUTO_INCREMENT = 1');
        $this->em->getConnection()->executeQuery('ALTER TABLE yandex_yml_set AUTO_INCREMENT = 1');
        $this->em->getConnection()->executeQuery('ALTER TABLE yandex_yml_offer_yandex_yml_set AUTO_INCREMENT = 1');
    }
}