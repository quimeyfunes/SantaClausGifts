<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="receiver")
 */
class Receiver {

    const UUID_INDEX_IN_CSV = 4;
    const FIRSTNAME_INDEX_IN_CSV = 5;
    const LASTNAME_INDEX_IN_CSV = 6;
    const COUNTRYCODE_INDEX_IN_CSV = 7;

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
    private $firstName;
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     */
    private $countryCode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gift", mappedBy="receiver")
     */
    private $gifts;

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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param mixed $countryCode
     */
    public function setCountryCode($countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return mixed
     */
    public function getGifts()
    {
        return $this->gifts;
    }

    /**
     * @param mixed $gifts
     */
    public function setGifts($gifts): void
    {
        $this->gifts = $gifts;
    }

    public function fillWithCSVData($data){
        $this->setUuid($data[self::UUID_INDEX_IN_CSV]);
        $this->setFirstName($data[self::FIRSTNAME_INDEX_IN_CSV]);
        $this->setLastName($data[self::LASTNAME_INDEX_IN_CSV]);
        $this->setCountryCode($data[self::COUNTRYCODE_INDEX_IN_CSV]);
    }
}
