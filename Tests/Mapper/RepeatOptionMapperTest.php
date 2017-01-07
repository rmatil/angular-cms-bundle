<?php


namespace rmatil\CmsBundle\Tests\Mapper;


use PHPUnit_Framework_TestCase;
use rmatil\CmsBundle\Entity\RepeatOption;
use rmatil\CmsBundle\Mapper\RepeatOptionMapper;
use rmatil\CmsBundle\Model\RepeatOptionDTO;

class RepeatOptionMapperTest extends PHPUnit_Framework_TestCase {

    /**
     * @var RepeatOptionMapper
     */
    private $repeatOptionMapper;

    public function setUp() {
        $this->repeatOptionMapper = new RepeatOptionMapper();
    }

    /**
     * @param $entity RepeatOption
     *
     * @dataProvider entityProvider
     */
    public function testEntityToDto($entity) {
        $dto = $this->repeatOptionMapper->entityToDto($entity);

        $this->assertEquals($entity->getId(), $dto->getId());
        $this->assertEquals($entity->getOption(), $dto->getOption());
    }

    /**
     * @param $dto RepeatOptionDTO
     *
     * @dataProvider dtoProvider
     */
    public function testDtoToEntity($dto) {
        $entity = $this->repeatOptionMapper->dtoToEntity($dto);

        $this->assertEquals($dto->getId(), $entity->getId());
        $this->assertEquals($dto->getOption(), $entity->getOption());
    }

    public function entityProvider() {
        $option = new RepeatOption();
        $option->setId(1);
        $option->setOption(RepeatOption::WEEKLY);

        return [
            [$option]
        ];
    }

    public function dtoProvider() {
        $dto = new RepeatOptionDTO();
        $dto->setId(2);
        $dto->setOption(RepeatOption::YEARLY);

        return [
            [$dto]
        ];
    }
}
