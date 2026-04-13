<?php

namespace App\Form;


use Eyetronic\AjaxUploaderBundle\Form\Type\AjaxFileType;
use Liip\ImagineBundle\Exception\Binary\Loader\NotLoadableException;
use Liip\ImagineBundle\Service\FilterService;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;

class AjaxImageFileType extends AbstractTypeExtension
{
    /**
     * @var FilterService
     */
    protected $imagine;

    protected $propertyMappingFactory;

    function __construct(FilterService $filterService, PropertyMappingFactory $propertyMappingFactory)
    {
        $this->imagine = $filterService;
        $this->propertyMappingFactory = $propertyMappingFactory;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'show_thumbnail' => false,
            ])
        ;
    }

    /**
     * Gets the extended types.
     *
     * @return string[]
     */
    public static function getExtendedTypes(): iterable
    {
        return [AjaxFileType::class];
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['show_thumbnail'] = $options['show_thumbnail'];

        $object = $form->getParent()->getData();

        $downloadUri = $view->vars['download_uri'];
        $thumbnail = false;

        if ($downloadUri && $options['show_thumbnail']) {
            try {
                $thumbnail = $this->imagine->getUrlOfFilteredImage(
                    $downloadUri,
                    "ajax_uploader"
                );
            } catch (\Exception $e) {}
        }
        $view->vars['thumbnail'] = $thumbnail;
    }

}