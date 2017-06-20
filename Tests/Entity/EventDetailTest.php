<?php


namespace rmatil\CmsBundle\Tests\Entity;


use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;
use rmatil\CmsBundle\Entity\Article;
use rmatil\CmsBundle\Entity\Event;
use rmatil\CmsBundle\Entity\EventDetail;
use rmatil\CmsBundle\Entity\Language;
use rmatil\CmsBundle\Entity\Offer;
use rmatil\CmsBundle\Entity\Page;
use rmatil\CmsBundle\Entity\User;
use rmatil\CmsBundle\Entity\UserGroup;

class EventDetailTest extends PHPUnit_Framework_TestCase {

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
    public function testAccessors($id, $offers, $event) {
        $this->eventDetail->setId($id);
        $this->eventDetail->setOffers($offers);
        $this->eventDetail->setEvent($event);

        $this->assertEquals($id, $this->eventDetail->getId());
        $this->assertEquals($offers, $this->eventDetail->getOffers());
        $this->assertEquals($event, $this->eventDetail->getEvent());
    }

    public function dataProvider() {
        $offer = new Offer();
        $event = new Event();

        $offers = new ArrayCollection([$offer]);

        return [
            [1, null, null],
            [2, $offers, $event]
        ];
    }
}
