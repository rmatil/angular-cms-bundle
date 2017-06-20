<?php


namespace rmatil\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="offers")
 */
class Offer {

    /**
     * Id of the OfferDTO
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @var integer
     */
    private $id;

    /**
     * Name of the offer
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $name;

    /**
     * The amount in cents
     *
     * @ORM\Column(type="integer")
     *
     * @var string
     */
    protected $amount;

    /**
     * The currency of the price.
     * MUST be in the 3-letter ISO 4217 format.
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $currency;

    /**
     * The url to the offer provided, if any
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    protected $url;

    /**
     * Many offers belong to one event
     *
     * @ORM\ManyToOne(targetEntity="EventDetail", inversedBy="offers")
     */
    protected $eventDetail;

    /**
     * @return int
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id = null) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name = null) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAmount(): ?string {
        return $this->amount;
    }

    /**
     * @param string $amount
     */
    public function setAmount(string $amount = null) {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): ?string {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency = null) {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getUrl(): ?string {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url = null) {
        $this->url = $url;
    }

    /**
     * @return \rmatil\CmsBundle\Entity\EventDetail
     */
    public function getEventDetail() {
        return $this->eventDetail;
    }

    /**
     * @param \rmatil\CmsBundle\Entity\EventDetail $eventDetail
     */
    public function setEventDetail($eventDetail) {
        $this->eventDetail = $eventDetail;
    }

}
