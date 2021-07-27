<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="gift")
 * @ORM\Entity(repositoryClass="App\Repository\GiftRepository")
 */
class Gift {

    const UUID_INDEX_IN_CSV = 0;
    const CODE_INDEX_IN_CSV = 1;
    const DESCRIPTION_INDEX_IN_CSV = 2;
    const PRICE_INDEX_IN_CSV = 3;

    /**
     * @ORM\Column(type="string", length=100)
     * @ORM\Id
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     *
     */
    private $code;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank$gift->setUuid($data[0]);
                $gift->setCode($data[1]);
                $gift->setDescription($data[2]);
                $gift->setPrice($data[3]);
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     *
     */
    private $receiverUuid;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     *
     */
    private $stockId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Receiver", inversedBy="gifts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="receiver_uuid", referencedColumnName="uuid")
     * })

     */
    private $receiver;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stock", inversedBy="gifts")
     */
    private $stock;

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getStocks()
    {
        return $this->stocks;
    }

    /**
     * @param mixed $stocks
     */
    public function setStocks($stocks): void
    {
        $this->stocks = $stocks;
    }

    /**
     * @return mixed
     */
    public function getReceiverUuid()
    {
        return $this->receiverUuid;
    }

    /**
     * @param mixed $receiverUuid
     */
    public function setReceiverUuid($receiverUuid): void
    {
        $this->receiverUuid = $receiverUuid;
    }

    /**
     * @return mixed
     */
    public function getStockId()
    {
        return $this->stockId;
    }

    /**
     * @param mixed $stockId
     */
    public function setStockId($stockId): void
    {
        $this->stockId = $stockId;
    }

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock): void
    {
        $this->stock = $stock;
    }

    public function fillWithCSVData($data){
        $this->setUuid($data[self::UUID_INDEX_IN_CSV]);
        $this->setCode($data[self::CODE_INDEX_IN_CSV]);
        $this->setDescription($data[self::DESCRIPTION_INDEX_IN_CSV]);
        $this->setPrice($data[self::PRICE_INDEX_IN_CSV]);
    }
}
