<?php


namespace rmatil\CmsBundle\Model;

use JMS\Serializer\Annotation\Type;

class OfferDTO {

    /**
     * Id of the Offer
     *
     * @Type("integer")
     *
     * @var integer
     */
    private $id;

    /**
     * Name of the offer
     *
     * @Type("string")
     *
     * @var string
     */
    protected $name;

    /**
     * The amount in cents
     *
     * @Type("integer")
     *
     * @var string
     */
    protected $amount;

    /**
     * The currency of the price.
     * MUST be in the 3-letter ISO 4217 format.
     *
     * @Type("string")
     *
     * @var string
     */
    protected $currency;

    /**
     * The url to the offer provided, if any
     *
     * @Type("string")
     *
     * @var string
     */
    protected $url;

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
}
