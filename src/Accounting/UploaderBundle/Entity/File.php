<?php

namespace Accounting\UploaderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * File
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Accounting\UploaderBundle\Entity\FileRepository")
 */
class File
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="path", type="text", nullable=true)
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    protected $type;

    /**
     * @Assert\File(maxSize="6000000")
    */
    protected $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
      public function setFile(UploadedFile $file = null)
      {
          $this->file = $file;
      }

  /**
   * Get file.
   *
   * @return UploadedFile
   */
    public function getFile()
    {
        return $this->file;
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return File
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return File
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    public function getAbsolutePath()
    {
       return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

   public function getWebPath()
   {
       return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
   }

   protected function getUploadRootDir()
   {
       // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
       return __DIR__.'/../../../../web/'.$this->getUploadDir();
   }

   protected function getUploadDir()
   {
       return 'uploads/documents';
   }

   public function upload()
   {
       // the file property can be empty if the field is not required
       if (null === $this->getFile()) {
           return;
       }

       // use the original file name here but you should
       // sanitize it at least to avoid any security issues

       // move takes the target directory and then the
       // target filename to move to
       $this->getFile()->move(
           $this->getUploadRootDir(),
           $this->getFile()->getClientOriginalName()
       );

       // set the path property to the filename where you've saved the file
       $this->path = $this->getFile()->getClientOriginalName();

       // clean up the file property as you won't need it anymore
       $this->file = null;
   }
}
