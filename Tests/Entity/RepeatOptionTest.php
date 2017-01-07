<?php


namespace rmatil\CmsBundle\Tests\Entity;


use PHPUnit_Framework_TestCase;
use rmatil\CmsBundle\Entity\RepeatOption;

class RepeatOptionTest extends PHPUnit_Framework_TestCase {

    /**
     * @var RepeatOption
     */
    private $repeatOption;

    public function setUp() {
        $this->repeatOption = new RepeatOption();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAccessors($id, $option) {
        $this->repeatOption->setId($id);
        $this->repeatOption->setOption($option);

        $this->assertEquals($id, $this->repeatOption->getId());
        $this->assertEquals($option, $this->repeatOption->getOption());
    }

    public function dataProvider() {
        return [
            [1, RepeatOption::YEARLY],
            [2, RepeatOption::DAILY],
            [3, RepeatOption::WEEKLY]
        ];
    }
}
