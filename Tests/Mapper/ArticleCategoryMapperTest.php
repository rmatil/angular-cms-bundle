<?php


namespace rmatil\CmsBundle\Tests\Mapper;


use PHPUnit\Framework\TestCase;
use rmatil\CmsBundle\Entity\ArticleCategory;
use rmatil\CmsBundle\Mapper\ArticleCategoryMapper;
use rmatil\CmsBundle\Model\ArticleCategoryDTO;

class ArticleCategoryMapperTest extends TestCase {

    /**
     * @var ArticleCategoryMapper
     */
    private $articleCategoryMapper;

    public function setUp() {
        $this->articleCategoryMapper = new ArticleCategoryMapper();
    }


    /**
     * @param $entity ArticleCategory
     *
     * @dataProvider entityProvider
     */
    public function testEntityToDto($entity) {
        $dto = $this->articleCategoryMapper->entityToDto($entity);

        $this->assertEquals($entity->getId(), $dto->getId());
        $this->assertEquals($entity->getName(), $dto->getName());
    }

    /**
     * @param $dto ArticleCategoryDTO
     *
     * @dataProvider dtoProvider
     */
    public function testDtoToEntity($dto) {
        $entity = $this->articleCategoryMapper->dtoToEntity($dto);

        $this->assertEquals($dto->getId(), $entity->getId());
        $this->assertEquals($dto->getName(), $entity->getName());
    }

    public function entityProvider() {
        $articleCategory = new ArticleCategory();
        $articleCategory->setId(1);
        $articleCategory->setName('category');

        return [
            [$articleCategory]
        ];
    }

    public function dtoProvider() {
        $dto = new ArticleCategoryDTO();

        $dto->setId(1);
        $dto->setName('dto');

        return [
            [$dto]
        ];
    }
}
