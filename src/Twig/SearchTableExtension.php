<?php


namespace App\Twig;


use App\Entity\Form\Search\AbstractSearch;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SearchTableExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('sortHeader', [$this, 'renderSortHeader']),
        ];
    }

    public function renderSortHeader(AbstractSearch $entity, $property, $header)
    {
        $class = "sort-column";
        if($entity->getSort() == $property){
            $order = is_null($entity->getSortOrder()) ? AbstractSearch::SORT_ORDER_ASC : $entity->getSortOrder();
            if($order == AbstractSearch::SORT_ORDER_ASC){
                $class .= " sort-asc";
                $icon = '<i class="fas fa-sort-down"></i>';
            }
            else{
                $class .= " sort-desc";
                $icon = '<i class="fas fa-sort-up"></i>';
            }
        }
        else{
            $order = "";
            $icon = '<i class="fas fa-sort"></i>';
        }
        return '<th data-field="' . $property . '" data-order="' . $order . '" class="' . $class .'">' . $header . " " . $icon . "</th>";
    }
}