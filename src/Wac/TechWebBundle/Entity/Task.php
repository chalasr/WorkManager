<?php

namespace Wac\TechWebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wac\TechWebBundle\Entity\TaskRepository")
 */
class Task
{
    /**
     * @ORM\ManyToOne(targetEntity="Card", inversedBy="tasks")
     * @ORM\JoinColumn(name="card_id", referencedColumnName="id")
     */
    protected $card;

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
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="done", type="boolean")
     */
    protected $done = false;

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
     * @return Task
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
     * Set done.
     *
     * @param bool $done
     *
     * @return Task
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done.
     *
     * @return bool
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set card.
     *
     * @param \Wac\TechWebBundle\Entity\Card $card
     *
     * @return Task
     */
    public function setCard(\Wac\TechWebBundle\Entity\Card $card = null)
    {
        $this->card = $card;

        return $this;
    }

    /**
     * Get card.
     *
     * @return \Wac\TechWebBundle\Entity\Card
     */
    public function getCard()
    {
        return $this->card;
    }
}
