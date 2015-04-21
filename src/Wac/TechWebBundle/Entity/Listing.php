<?php

namespace Wac\TechWebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Listing
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wac\TechWebBundle\Entity\ListingRepository")
 */
class Listing
{

  /**
    * @ORM\OneToMany(targetEntity="Card", mappedBy="listing")
    */
    protected $cards;


  /**
   * @ORM\ManyToOne(targetEntity="Project", inversedBy="listings")
   * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
   */
   protected $project;

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
     * @return Listing
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
     * Set project
     *
     * @param \Wac\TechWebBundle\Entity\Project $project
     * @return Listing
     */
    public function setProject(\Wac\TechWebBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \Wac\TechWebBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cards = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cards
     *
     * @param \Wac\TechWebBundle\Entity\Card $cards
     * @return Listing
     */
    public function addCard(\Wac\TechWebBundle\Entity\Card $cards)
    {
        $this->cards[] = $cards;

        return $this;
    }

    /**
     * Remove cards
     *
     * @param \Wac\TechWebBundle\Entity\Card $cards
     */
    public function removeCard(\Wac\TechWebBundle\Entity\Card $cards)
    {
        $this->cards->removeElement($cards);
    }

    /**
     * Get cards
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCards()
    {
        return $this->cards;
    }
}
