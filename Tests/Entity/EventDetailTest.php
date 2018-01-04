<?php


namespace rmatil\CmsBundle\Tests\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use rmatil\CmsBundle\Entity\Event;
use rmatil\CmsBundle\Entity\EventDetail;
use rmatil\CmsBundle\Entity\Offer;

class EventDetailTest extends TestCase {

    /**
     * @var \rmatil\CmsBundle\Entity\EventDetail
     */
    private $eventDetail;

    public function setUp() {
        $this->eventDetail = new EventDetail();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAccessors($id, $color, $offers, $event) {
        $this->eventDetail->setId($id);
        $this->eventDetail->setColor($color);
        $this->eventDetail->setOffers($offers);
        $this->eventDetail->setEvent($event);

        $this->assertEquals($id, $this->eventDetail->getId());
        $this->assertEquals($color, $this->eventDetail->getColor());
        $this->assertEquals($offers, $this->eventDetail->getOffers());
        $this->assertEquals($event, $this->eventDetail->getEvent());
    }

    public function dataProvider() {
        $offer = new Offer();
        $event = new Event();

        $offers = new ArrayCollection([$offer]);

        return [
            [1, "#123", null, null],
            [2, "#123", $offers, $event]
        ];
    }
}
