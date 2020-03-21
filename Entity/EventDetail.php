<?php


namespace rmatil\CmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="event_detail")
 */
class EventDetail {

    /**
     * Id of the event detail
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @var integer
     */
    private $id;

    /**
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="eventDetail")
     *
     * @var ArrayCollection
     */
    private $offers;

    /**
     * @ORM\OneToOne(targetEntity="Event",  mappedBy="eventDetail")
     *
     * @var Event
     */
    private $event;

    /**
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    protected $eventAttendanceMode;

    /**
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    protected $eventStatus;

    /**
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    protected $performer;

    public function __construct() {
        $this->offers = new ArrayCollection();
    }

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
     * @return ArrayCollection
     */
    public function getOffers() {
        return $this->offers;
    }

    /**
     * @param ArrayCollection $offers
     */
    public function setOffers(ArrayCollection $offers = null) {
        $this->offers = $offers;
    }

    /**
     * Adds the given offer
     *
     * @param \rmatil\CmsBundle\Entity\Offer $offer
     */
    public function addOffer(Offer $offer = null) {
        $this->offers->add($offer);
    }

    /**
     * Removes the given offer from the collection, if found.
     *
     * @param \rmatil\CmsBundle\Entity\Offer $offer
     */
    public function removeOffer(Offer $offer = null) {
        $this->offers->removeElement($offer);
    }

    /**
     * @return Event
     */
    public function getEvent(): ?Event {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent(Event $event = null) {
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getEventAttendanceMode(): string
    {
        return $this->eventAttendanceMode;
    }

    /**
     * @param string $eventAttendanceMode
     */
    public function setEventAttendanceMode(string $eventAttendanceMode): void
    {
        $this->eventAttendanceMode = $eventAttendanceMode;
    }

    /**
     * @return string
     */
    public function getEventStatus(): string
    {
        return $this->eventStatus;
    }

    /**
     * @param string $eventStatus
     */
    public function setEventStatus(string $eventStatus): void
    {
        $this->eventStatus = $eventStatus;
    }

    /**
     * @return string
     */
    public function getPerformer(): string
    {
        return $this->performer;
    }

    /**
     * @param string $performer
     */
    public function setPerformer(string $performer): void
    {
        $this->performer = $performer;
    }
}
