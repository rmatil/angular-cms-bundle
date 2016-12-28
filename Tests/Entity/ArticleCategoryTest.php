<?php


namespace Entity;


use PHPUnit_Framework_TestCase;
use rmatil\CmsBundle\Entity\ArticleCategory;

class ArticleCategoryTest extends PHPUnit_Framework_TestCase {

    /**
     * @var ArticleCategory
     */
    private $articleCategory;

    public function setUp() {
        $this->articleCategory = new ArticleCategory();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAccessors($id, $name) {
        $this->articleCategory->setId($id);
        $this->articleCategory->setName($name);

        $this->assertEquals($id, $this->articleCategory->getId());
        $this->assertEquals($name, $this->articleCategory->getName());
    }

    public function dataProvider() {
        return [
            [1, 'some name'],
            [2, 'some-name']
        ];
    }
}
