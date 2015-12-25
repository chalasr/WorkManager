<?php

namespace Wac\TechWebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * User.
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Wac\TechWebBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\ManyToMany(targetEntity="Project", mappedBy="users")
     */
    protected $projects;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add projects.
     *
     * @param \Wac\TechWebBundle\Entity\Project $projects
     *
     * @return User
     */
    public function addProject(\Wac\TechWebBundle\Entity\Project $projects)
    {
        $this->projects[] = $projects;

        return $this;
    }

    /**
     * Remove projects.
     *
     * @param \Wac\TechWebBundle\Entity\Project $projects
     */
    public function removeProject(\Wac\TechWebBundle\Entity\Project $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }
}
