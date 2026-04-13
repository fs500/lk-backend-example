<?php


namespace App\Message\Handler;


use App\Message\PDFNotification;
use App\Services\FlatPDFManager;
use Doctrine\DBAL\Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class PDFMessageHandler implements MessageHandlerInterface
{

    /**
     * @var FlatPDFManager
     */
    private $pdfManager;

    public function __construct(
        FlatPDFManager $manager
    )
    {
        $this->pdfManager = $manager;
    }

    public function __invoke(PDFNotification $message)
    {
        try {
            if (empty($message->getFlat()) && empty($message->getFloor())) {
                echo "\nall\n";
                $this->pdfManager->renderAll();
            }

            if (!empty($message->getFlat())) {
                echo "\nflat" . $message->getFlat() . "\n";
                $this->pdfManager->renderFlat($message->getFlat());
            }

            if (!empty($message->getFloor())) {
                echo "\nfloor" . $message->getFloor() . "\n";
                $this->pdfManager->renderFloor($message->getFloor());
            }
        } catch (\Exception $e){
            echo $e->getMessage() . "\n";
        }
    }
}