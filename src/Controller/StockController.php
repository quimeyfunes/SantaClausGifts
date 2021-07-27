<?php
namespace App\Controller;
use App\Entity\Gift;
use App\Entity\Receiver;
use App\Entity\Stock;
use App\Handler\CSVHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Stock controller.
 * @Route("/api", name="api_")
 */
class StockController extends BaseApiController
{
    /**
     * Gett all stocks statistics.
     * @Rest\Get("/stock/statistics")
     *
     * @return Response
     */
    public function getStockStatistics()
    {
        $result = $this->getDoctrine()->getRepository(Gift::class)->getStatistics();
        return $this->handleView($this->view($result, Response::HTTP_OK));
    }

    /**
     * Save stock from file.
     * @Rest\Post("/stock")
     * @param $request
     * @return Response
     */
    public function postStock(Request $request)
    {
        $filesBag = $request->files->all();
        $columnsNumber = 8;
        $errors = [];

        if (!$filesBag) {
            return $this->handleView($this->view(['error' => 'no stock file'], Response::HTTP_BAD_REQUEST));
        }

        foreach ($filesBag as $file){
            $stock = new Stock();
            $stock = $this->saveElement($stock, null, Stock::class, $errors);

            $fileHandler = new CSVHandler($file, $columnsNumber, true);
            while (($data = $fileHandler->getNextRow()) !== FALSE) {
                $errors = $this->saveEntitiesFromCSVRow($data, $stock);
            }

            $result = ['status' => 'ok'];
            if (!empty($errors)) {
                $result = ['status' => 'finished with errors', 'error' => $errors];
            }
            return $this->handleView($this->view($result, Response::HTTP_CREATED));
        }
    }

    /**
     * @param $data
     * @param $stock
     * @return mixed
     */
    protected function saveEntitiesFromCSVRow($data, $stock)
    {
        $receiver = new Receiver();
        $receiver->fillWithCSVData($data);
        $receiver = $this->saveElement($receiver, $receiver->getUuid(), Receiver::class, $errors);

        $gift = new Gift();
        $gift->fillWithCSVData($data);
        $gift->setStock($stock);
        $gift->setReceiver($receiver);
        $this->saveElement($gift, $gift->getUuid(), Gift::class, $errors);
        return $errors;
    }
}