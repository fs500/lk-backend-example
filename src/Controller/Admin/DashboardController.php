<?php


namespace App\Controller\Admin;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Eyetronic\EyeAdminBundle\Controller\AbstractDashboardController;
use Eyetronic\EyeAdminBundle\Controller\DashboardControllerInterface;
use Eyetronic\EyeAdminBundle\Menu\MenuItem;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(){
        return new RedirectResponse(
            $this->generateUrl("admin_metatag")
        );
    }

    public static function configureMenu(EntityManagerInterface $em, Request $request): iterable
    {
        yield MenuItem::linkToRoute('Меню', 'fab fa-elementor', 'admin_menu_index');

        yield MenuItem::section('Общее', 'fab fa-elementor');

        yield MenuItem::linkToRoute('Жилой комплекс', '', 'admin_building_index');
        yield MenuItem::linkToRoute('Новости', '', 'admin_news_index');
        yield MenuItem::linkToRoute('Акции', '', 'admin_offer_index');
        yield MenuItem::linkToRoute('Застройщик', '', 'admin_builder_index');
        yield MenuItem::linkToRoute('Банки', '', 'admin_bank_index');
        yield MenuItem::linkToRoute('Социальные сети', '', 'admin_social_network_index');
        yield MenuItem::linkToRoute('Калькулятор', '', 'admin_calculator_index');
        yield MenuItem::linkToRoute('Уведомления', '', 'admin_notification_index');

        yield MenuItem::section('Страницы', 'fa fa-sitemap');
        yield MenuItem::linkToRoute('Главная страница', '', 'admin_page_index');
        yield MenuItem::linkToRoute('Как купить', '', 'admin_page_how_to_buy');
        yield MenuItem::linkToRoute('Документы', '', 'admin_document_index');
        yield MenuItem::linkToRoute('Коммерция', '', 'admin_page_commerce');
        yield MenuItem::linkToRoute('Расположение', '', 'admin_page_location');
        yield MenuItem::linkToRoute('Ход строительства', '', 'admin_building_progress_index');
        yield MenuItem::linkToRoute('Контакты', '', 'admin_page_contacts');

        yield MenuItem::section('Объекты', 'fas fa-building');
        yield MenuItem::linkToRoute('Этажи', '', 'admin_floor_index');
        yield MenuItem::linkToRoute('Квартиры', '', 'admin_flat_index');
        yield MenuItem::linkToRoute('Обновление цен', '', 'admin_flat_price_index');
        yield MenuItem::linkToRoute('Обновление квартир', '', 'admin_update_flat');

        yield MenuItem::section('Инфраструктура', 'fas fa-map-marker-alt');
        yield MenuItem::linkToRoute('Карта', '', 'admin_page_infrastructure_index');
        yield MenuItem::linkToRoute('Объекты', '', 'admin_infrastructure_index');

        yield MenuItem::section();
        yield MenuItem::linkToRoute('Метатеги', 'fas fa-code', 'admin_metatag');
        yield MenuItem::linkToRoute('Настройки', 'fas fa-wrench', 'admin_setting_index');
        yield MenuItem::section();
        yield MenuItem::linkToRoute('Пользователи', 'fas fa-user', 'admin_user_index');

        yield MenuItem::section('Фиды', 'fas fa-database');
        yield MenuItem::linkToRoute('Glavbaza', '', 'feed_glavbaza');
        yield MenuItem::linkToRoute('Петербургская недвижимость', '', 'feed_pn',);
        yield MenuItem::section('Yandex YML', 'fas fa-bullseye');
        yield MenuItem::linkToRoute('Фид', '', 'admin_yandex_yml_shop_edit');
        yield MenuItem::linkToRoute('Сеты', '', 'admin_yandex_yml_set_index');
        yield MenuItem::linkToRoute('Предложения', '', 'admin_yandex_yml_offer_index');
    }

}