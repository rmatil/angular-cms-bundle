<?php


namespace rmatil\CmsBundle\Tests\Entity;


use PHPUnit\Framework\TestCase;
use rmatil\CmsBundle\Entity\Event;
use rmatil\CmsBundle\Entity\File;
use rmatil\CmsBundle\Entity\Location;
use rmatil\CmsBundle\Entity\RepeatOption;
use rmatil\CmsBundle\Entity\User;
use rmatil\CmsBundle\Entity\UserGroup;

class EventTest extends TestCase {

    /**
     * @var Event
     */
    private $event;

    public function setUp() {
        $this->event = new Event();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAccessors($id, $author, $location, $file, $name, $content, $additionalInfo, $repeatOption, $startDate, $endDate, $lastEditDate, $creationDate, $allowedUserGroup, $urlName) {
        $this->event->setId($id);
        $this->event->setAuthor($author);
        $this->event->setLocation($location);
        $this->event->setFile($file);
        $this->event->setName($name);
        $this->event->setContent($content);
        $this->event->setAdditionalInfo($additionalInfo);
        $this->event->setRepeatOption($repeatOption);
        $this->event->setStartDate($startDate);
        $this->event->setEndDate($endDate);
        $this->event->setLastEditDate($lastEditDate);
        $this->event->setCreationDate($creationDate);
        $this->event->setAllowedUserGroup($allowedUserGroup);
        $this->event->setUrlName($urlName);

        $this->assertEquals($id, $this->event->getId());
        $this->assertEquals($author, $this->event->getAuthor());
        $this->assertEquals($location, $this->event->getLocation());
        $this->assertEquals($file, $this->event->getFile());
        $this->assertEquals($name, $this->event->getName());
        $this->assertEquals($content, $this->event->getContent());
        $this->assertEquals($additionalInfo, $this->event->getAdditionalInfo());
        $this->assertEquals($repeatOption, $this->event->getRepeatOption());
        $this->assertEquals($startDate, $this->event->getStartDate());
        $this->assertEquals($endDate, $this->event->getEndDate());
        $this->assertEquals($lastEditDate, $this->event->getLastEditDate());
        $this->assertEquals($creationDate, $this->event->getCreationDate());
        $this->assertEquals($allowedUserGroup, $this->event->getAllowedUserGroup());
        $this->assertEquals($urlName, $this->event->getUrlName());
    }

    public function dataProvider() {
        return [
            [1, new User(), new Location(), new File(), 'event name', 'content', 'additional info', new RepeatOption(), new \DateTime(), new \DateTime(), new \DateTime(), new \DateTime(), new UserGroup(), 'url-name']
        ];
    }
}
