<?php


namespace App\Services;


use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Pdf
{

    private $mpdf;

    private $publicDir;

    public function __construct(ContainerInterface $container)
    {
        $this->publicDir = $container->getParameter('app.path.public');
        $this->initMpdf();
    }

    public function output($html){
        $this->mpdf->WriteHTML($html);
        return $this->mpdf->Output(null, Destination::STRING_RETURN);
    }

    public function fileOutput($filename, $html){
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output($filename, Destination::FILE);
    }

    public function reset(){
        $this->initMpdf();
    }

    protected function initMpdf(){
        $fontDir = $this->publicDir . DIRECTORY_SEPARATOR . 'fonts';
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $this->mpdf = new Mpdf([
            'fontDir' => array_merge($fontDirs, [
                $fontDir,
            ]),
            'fontdata' => $fontData + [
                    'ceraproregular' => [
                        'R' => 'ceraproregular.ttf',
                    ],
                    'cerapromedium' => [
                        'R' => 'cerapromedium.ttf',
                    ],
                    'forumregular' => [
                        'R' => 'forumregular.ttf',
                    ]
                ],
            'default_font' => 'ceraproregular',
            'margin_footer' => 0,
            'margin_header' => 0,
        ]);
        $this->mpdf->showImageErrors = true;
        $this->mpdf->SetMargins(0, 0, 0);
    }
}