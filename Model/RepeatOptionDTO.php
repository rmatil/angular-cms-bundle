<?php


namespace rmatil\CmsBundle\Model;

use JMS\Serializer\Annotation\Type;

class RepeatOptionDTO {

    /**
     * @Type("integer")
     *
     * @var integer
     */
    private $id;

    /**
     * @Type("string")
     *
     * @var string
     */
    private $option;

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
    public function getOption(): ?string {
        return $this->option;
    }

    /**
     * @param string $optionValue
     */
    public function setOption(string $optionValue = null) {
        $this->option = $optionValue;
    }
}
