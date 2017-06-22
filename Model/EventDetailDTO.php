<?php


namespace rmatil\CmsBundle\Model;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

class EventDetailDTO {

    /**
     * @Type("integer")
     *
     * @var integer
     */
    private $id;

    /**
     * @Type("string")
     *
     * @var string
     */
    private $color;

    /**
     * @Type("array<rmatil\CmsBundle\Model\OfferDTO>")
     * @Serializer\MaxDepth(2)
     *
     * @var \rmatil\CmsBundle\Model\OfferDTO[]
     */
    private $offers;

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
    public function getColor(): ?string {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color = null) {
        $this->color = $color;
    }

    /**
     * @return \rmatil\CmsBundle\Model\OfferDTO[]
     */
    public function getOffers(): ?array {
        return $this->offers;
    }

    /**
     * @param \rmatil\CmsBundle\Model\OfferDTO[] $offers
     */
    public function setOffers(array $offers = null) {
        $this->offers = $offers;
    }


}
