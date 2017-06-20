<?php


namespace rmatil\CmsBundle\Model;

use JMS\Serializer\Annotation\Type;

class MediaTagDTO {

    /**
     * Id of the Offer
     *
     * @Type("integer")
     *
     * @var integer
     */
    private $id;

    /**
     * Name of the offer
     *
     * @Type("string")
     *
     * @var string
     */
    protected $name;


    /**
     * Files corresponding to this tag.
     *
     * @Type("array<rmatil\CmsBundle\Model\FileDTO>")
     *
     * @var \rmatil\CmsBundle\Model\FileDTO[]
     */
    protected $files;

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
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name = null) {
        $this->name = $name;
    }

    /**
     * @return \rmatil\CmsBundle\Model\FileDTO[]
     */
    public function getFiles(): ?array {
        return $this->files;
    }

    /**
     * @param \rmatil\CmsBundle\Model\FileDTO[] $files
     */
    public function setFiles(array $files = null) {
        $this->files = $files;
    }
}
