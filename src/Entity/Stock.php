<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="stock")
 */
class Stock {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * *@ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gift", mappedBy="receiver")
     */
    private $gifts;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
}
