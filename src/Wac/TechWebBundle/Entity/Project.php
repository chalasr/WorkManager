<?php

namespace Wac\TechWebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project.
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Project
{
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="projects", cascade={"persist"})
     * @ORM\JoinTable(name="project_user",
     *     joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="Listing", mappedBy="project",  cascade={"remove"})
     */
    protected $listings;

    /**
     * @var int
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
    protected $name;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->listings = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add listings.
     *
     * @param \Wac\TechWebBundle\Entity\Listing $listings
     *
     * @return Project
     */
    public function addListing(\Wac\TechWebBundle\Entity\Listing $listings)
    {
        $this->listings[] = $listings;

        return $this;
    }

    /**
     * Remove listings.
     *
     * @param \Wac\TechWebBundle\Entity\Listing $listings
     */
    public function removeListing(\Wac\TechWebBundle\Entity\Listing $listings)
    {
        $this->listings->removeElement($listings);
    }

    /**
     * Get listings.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListings()
    {
        return $this->listings;
    }

    /**
     * Add users.
     *
     * @param \Wac\TechWebBundle\Entity\User $users
     *
     * @return Project
     */
    public function addUser(\Wac\TechWebBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users.
     *
     * @param \Wac\TechWebBundle\Entity\User $users
     */
    public function removeUser(\Wac\TechWebBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
