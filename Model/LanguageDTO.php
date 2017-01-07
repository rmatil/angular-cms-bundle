<?php


namespace rmatil\CmsBundle\Model;


use JMS\Serializer\Annotation\Type;

class LanguageDTO {

    /**
     * Id of the language
     *
     * @Type("integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * Name of the Language
     *
     * @Type("string")
     *
     * @var string
     */
    protected $name;

    /**
     * ISO 639-1-Code of the Language: Is a 2-letter abbr.
     *
     * @Type("string")
     *
     * @var string
     */
    protected $code;


    /**
     * Gets the Id of the language.
     *
     * @return integer
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Sets the Id of the language.
     *
     * @param integer $id the id
     */
    public function setId(int $id = null) {
        $this->id = $id;
    }

    /**
     * Gets the value of name.
     *
     * @return string
     */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
     */
    public function setName(string $name = null) {
        $this->name = $name;
    }

    /**
     * Gets the ISO 639-1-Code of the Language: Is a 2-letter abbr..
     *
     * @return string
     */
    public function getCode(): ?string {
        return $this->code;
    }

    /**
     * Sets the ISO 639-1-Code of the Language: Is a 2-letter abbr..
     *
     * @param string $code the code
     */
    public function setCode(string $code = null) {
        $this->code = $code;
    }
}
