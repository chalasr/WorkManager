<?php

namespace Wac\TechWebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Project
{
  /**
  * @ORM\OneToMany(targetEntity="Listing", mappedBy="project")
  */
    protected $listings;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


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
     * @return Project
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
     * Constructor
     */
    public function __construct()
    {
        $this->listings = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add listings
     *
     * @param \Wac\TechWebBundle\Entity\Listing $listings
     * @return Project
     */
    public function addListing(\Wac\TechWebBundle\Entity\Listing $listings)
    {
        $this->listings[] = $listings;

        return $this;
    }

    /**
     * Remove listings
     *
     * @param \Wac\TechWebBundle\Entity\Listing $listings
     */
    public function removeListing(\Wac\TechWebBundle\Entity\Listing $listings)
    {
        $this->listings->removeElement($listings);
    }

    /**
     * Get listings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getListings()
    {
        return $this->listings;
    }
}
