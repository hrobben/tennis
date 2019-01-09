<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpelerRepository")
 */
class Speler
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roepnaam;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tussenvoegsel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $achternaam;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\School", inversedBy="spelers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $school;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tornooi", inversedBy="spelers")
     */
    private $tornooi;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Wedstrijd", mappedBy="speler1")
     */
    private $wedstrijden;

    public function __construct()
    {
        $this->tornooi = new ArrayCollection();
        $this->wedstrijden = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoepnaam(): ?string
    {
        return $this->roepnaam;
    }

    public function setRoepnaam(string $roepnaam): self
    {
        $this->roepnaam = $roepnaam;

        return $this;
    }

    public function getTussenvoegsel(): ?string
    {
        return $this->tussenvoegsel;
    }

    public function setTussenvoegsel(?string $tussenvoegsel): self
    {
        $this->tussenvoegsel = $tussenvoegsel;

        return $this;
    }

    public function getAchternaam(): ?string
    {
        return $this->achternaam;
    }

    public function setAchternaam(string $achternaam): self
    {
        $this->achternaam = $achternaam;

        return $this;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(?School $school): self
    {
        $this->school = $school;

        return $this;
    }

    /**
     * @return Collection|Tornooi[]
     */
    public function getTornooi(): Collection
    {
        return $this->tornooi;
    }

    public function addToernooi(Tornooi $toernooi): self
    {
        if (!$this->tornooi->contains($toernooi)) {
            $this->tornooi[] = $toernooi;
        }

        return $this;
    }

    public function removeTornooi(Tornooi $tornooi): self
    {
        if ($this->tornooi->contains($tornooi)) {
            $this->tornooi->removeElement($tornooi);
        }

        return $this;
    }

    /**
     * @return Collection|Wedstrijd[]
     */
    public function getWedstrijden(): Collection
    {
        return $this->wedstrijden;
    }

    public function addWedstrijden(Wedstrijd $wedstrijden): self
    {
        if (!$this->wedstrijden->contains($wedstrijden)) {
            $this->wedstrijden[] = $wedstrijden;
            $wedstrijden->setSpeler1($this);
        }

        return $this;
    }

    public function removeWedstrijden(Wedstrijd $wedstrijden): self
    {
        if ($this->wedstrijden->contains($wedstrijden)) {
            $this->wedstrijden->removeElement($wedstrijden);
            // set the owning side to null (unless already changed)
            if ($wedstrijden->getSpeler1() === $this) {
                $wedstrijden->setSpeler1(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getRoepnaam().' '.(empty($this->getTussenvoegsel())?'':$this->getTussenvoegsel().' ').$this->getAchternaam();
    }
}
