<?php


namespace rmatil\CmsBundle\Tests\Entity;


use PHPUnit\Framework\TestCase;
use rmatil\CmsBundle\Entity\MediaTag;

class MediaTagTest extends TestCase {

    /**
     * @var \rmatil\CmsBundle\Entity\MediaTag
     */
    private $mediaTag;

    public function setUp() {
        $this->mediaTag = new MediaTag();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAccessors($id, $name) {
        $this->mediaTag->setId($id);
        $this->mediaTag->setName($name);

        $this->assertEquals($id, $this->mediaTag->getId());
        $this->assertEquals($name, $this->mediaTag->getName());
    }

    public function dataProvider() {
        return [
            [1, 'Gallery'],
            [1, null]
        ];
    }
}
