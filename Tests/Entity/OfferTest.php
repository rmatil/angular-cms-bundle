<?php


namespace rmatil\CmsBundle\Tests\Entity;


use PHPUnit\Framework\TestCase;
use rmatil\CmsBundle\Entity\EventDetail;
use rmatil\CmsBundle\Entity\Offer;

class OfferTest extends TestCase {

    /**
     * @var Offer
     */
    private $offer;

    public function setUp() {
        $this->offer = new Offer();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAccessors($id, $name, $amount, $currency, $url, $eventDetail) {
        $this->offer->setId($id);
        $this->offer->setName($name);
        $this->offer->setAmount($amount);
        $this->offer->setCurrency($currency);
        $this->offer->setUrl($url);
        $this->offer->setEventDetail($eventDetail);

        $this->assertEquals($id, $this->offer->getId());
        $this->assertEquals($name, $this->offer->getName());
        $this->assertEquals($amount, $this->offer->getAmount());
        $this->assertEquals($currency, $this->offer->getCurrency());
        $this->assertEquals($url, $this->offer->getUrl());
        $this->assertEquals($eventDetail, $this->offer->getEventDetail());
    }

    public function dataProvider() {
        return [
            [1, 'Kategorie A', 100, 'CHF', null, null],
            [1, 'Kategorie B', 200, 'USD', 'http://starticket.ch', new EventDetail()]
        ];
    }
}
