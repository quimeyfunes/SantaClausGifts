<?php

namespace App\Tests;

use App\Entity\Gift;
use App\Entity\Receiver;
use App\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class StockControllerTest extends WebTestCase
{
    const GET_URL = '/api/stock/statistics';
    const POST_URL = '/api/stock';

    public function testGetStatistics(): void
    {
        static::createClient()->request('GET', self::GET_URL);
        $this->assertResponseIsSuccessful();
    }

    public function testGetStatisticsWithData(): void
    {
        $client = static::createClient();
        $container = static::getContainer();
        $entityManager = $container->get('doctrine')->getManager();

        $stock = new Stock();
        $entityManager->persist($stock);
        $entityManager->flush();

        $receiver = new Receiver();
        $receiver->setUuid('dd49d9ac-5cd3-49b0-8dbe-ea09e18f8c9d');
        $receiver->setFirstName('Marie');
        $receiver->setLastName('Deschlein');
        $receiver->setCountryCode('GE');

        $receiver2 = new Receiver();
        $receiver2->setUuid('dd5ad9ac-5cd3-49b0-8dbe-ea09e18f8c9d');
        $receiver2->setFirstName('Albert');
        $receiver2->setLastName('Camus');
        $receiver2->setCountryCode('FR');

        $entityManager->persist($receiver);
        $entityManager->persist($receiver2);
        $entityManager->flush();

        $gift = new Gift();
        $gift->setUuid('da0d6adb-6ace-4a5c-8eda-50c4d72b7468');
        $gift->setCode('sport');
        $gift->setDescription('basket');
        $gift->setPrice('15');
        $gift->setStock($stock);
        $gift->setReceiver($receiver);

        $gift2 = new Gift();
        $gift2->setUuid('da0d51bb-6ace-4a5c-8eda-50c4d72b7468');
        $gift2->setCode('software');
        $gift2->setDescription('adobe');
        $gift2->setPrice('25');
        $gift2->setStock($stock);
        $gift2->setReceiver($receiver2);

        $entityManager->persist($gift);
        $entityManager->persist($gift2);
        $entityManager->flush();

        $client->request('GET', self::GET_URL);

        $jsonResponse = $this->getJsonResponse($client);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(2, $jsonResponse[0]->GiftCount);
        $this->assertEquals(2, $jsonResponse[0]->DifferentCountriesCount);
        $this->assertEquals(20, $jsonResponse[0]->AveragePrice);
        $this->assertEquals(25, $jsonResponse[0]->MaxPrice);
        $this->assertEquals(15, $jsonResponse[0]->MinPrice);
    }

    public function testPostEmpty(): void
    {
        static::createClient()->request('POST', self::POST_URL);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testPostWithFile(): void
    {
        $csvFile = new UploadedFile(__DIR__ . '/../file1.csv', 'file1.csv', '	text/csv');
        $client = static::createClient();
        $client->request('POST', self::POST_URL, [], ['stock' => $csvFile]);

        $jsonResponse = $this->getJsonResponse($client);

        $this->assertResponseIsSuccessful();
        $this->assertNotEquals('finished with errors', $jsonResponse->status);
    }

    public function testPostRepeatedReceiver(): void
    {
        $csvFile = new UploadedFile(__DIR__ . '/../file2.csv', 'file2.csv', '	text/csv');
        $client = static::createClient();
        $client->request('POST', self::POST_URL, [], ['stock' => $csvFile]);

        $jsonResponse = $this->getJsonResponse($client);

        $this->assertResponseIsSuccessful();
        $this->assertEquals('finished with errors', $jsonResponse->status);
    }

    /**
     * @param \Symfony\Bundle\FrameworkBundle\KernelBrowser $client
     * @return mixed
     */
    protected function getJsonResponse(\Symfony\Bundle\FrameworkBundle\KernelBrowser $client)
    {
        $response = $client->getResponse();
        $jsonResponse = json_decode($response->getContent());
        return $jsonResponse;
    }
}
