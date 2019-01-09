<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WedstrijdRepository")
 */
class Wedstrijd
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tornooi", inversedBy="wedstrijden")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tornooi;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Speler", inversedBy="wedstrijden")
     * @ORM\JoinColumn(nullable=false)
     */
    private $speler1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Speler", inversedBy="wedstrijden")
     * @ORM\JoinColumn(nullable=false)
     */
    private $speler2;

    /**
     * @ORM\Column(type="integer")
     */
    private $ronde;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $score1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $score2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Speler", inversedBy="wedstrijden")
     */
    private $winnaar;

    public function __construct()
    {
        $this->tornooi = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTornooi(): ?Tornooi
    {
        return $this->tornooi;
    }

    public function setTornooi(?Tornooi $tornooi): self
    {
        $this->tornooi = $tornooi;

        return $this;
    }

    public function getSpeler1(): ?Speler
    {
        return $this->speler1;
    }

    public function setSpeler1(?Speler $speler1): self
    {
        $this->speler1 = $speler1;

        return $this;
    }

    public function getSpeler2(): ?Speler
    {
        return $this->speler2;
    }

    public function setSpeler2(?Speler $speler2): self
    {
        $this->speler2 = $speler2;

        return $this;
    }

    public function getRonde(): ?int
    {
        return $this->ronde;
    }

    public function setRonde(int $ronde): self
    {
        $this->ronde = $ronde;

        return $this;
    }

    public function getScore1(): ?int
    {
        return $this->score1;
    }

    public function setScore1(?int $score1): self
    {
        $this->score1 = $score1;

        return $this;
    }

    public function getScore2(): ?int
    {
        return $this->score2;
    }

    public function setScore2(?int $score2): self
    {
        $this->score2 = $score2;

        return $this;
    }

    public function getWinnaar(): ?Speler
    {
        return $this->winnaar;
    }

    public function setWinnaar(?Speler $winnaar): self
    {
        $this->winnaar = $winnaar;

        return $this;
    }
}
