<?php


namespace rmatil\CmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tags")
 *
 **/
class MediaTag {

    /**
     * Id of the Tag
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @var integer
     */
    private $id;

    /**
     * Name of the Tag
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="File", inversedBy="tags")
     * @ORM\JoinTable(name="media_tags")
     *
     * @var ArrayCollection
     */
    private $files;

    public function __construct() {
        $this->files = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection
     */
    public function getFiles() {
        return $this->files;
    }

    /**
     * @param ArrayCollection $files
     */
    public function setFiles(ArrayCollection $files) {
        $this->files = $files;
    }

    /**
     * Does add the association to File as well!
     *
     * @param \rmatil\CmsBundle\Entity\File $file
     */
    public function addFile(File $file) {
        $file->addTag($this);
        $this->files->add($file);
    }

    /**
     * Does remove the tag from the given file as well!
     *
     * @param \rmatil\CmsBundle\Entity\File $file
     */
    public function removeFile(File $file) {
        $file->removeTag($this);
        $this->files->removeElement($file);
    }

}
