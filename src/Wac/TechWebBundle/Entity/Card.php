<?php

namespace Wac\TechWebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Card
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wac\TechWebBundle\Entity\CardRepository")
 */
class Card
{

  public function __toString()
  {
      return $this->getName();
  }

  /**
    * @ORM\OneToMany(targetEntity="Task", mappedBy="card",  cascade={"remove"})
    */
    protected $tasks;

    /**
   * @ORM\ManyToOne(targetEntity="Listing", inversedBy="cards")
   * @ORM\JoinColumn(name="listing_id", referencedColumnName="id")
   */
   protected $listing;

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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


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
     * @return Card
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
     * Set description
     *
     * @param string $description
     * @return Card
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set listing
     *
     * @param \Wac\TechWebBundle\Entity\Listing $listing
     * @return Card
     */
    public function setListing(\Wac\TechWebBundle\Entity\Listing $listing = null)
    {
        $this->listing = $listing;

        return $this;
    }

    /**
     * Get listing
     *
     * @return \Wac\TechWebBundle\Entity\Listing
     */
    public function getListing()
    {
        return $this->listing;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tasks
     *
     * @param \Wac\TechWebBundle\Entity\Task $tasks
     * @return Card
     */
    public function addTask(\Wac\TechWebBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;

        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \Wac\TechWebBundle\Entity\Task $tasks
     */
    public function removeTask(\Wac\TechWebBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
