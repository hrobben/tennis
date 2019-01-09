<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TornooiRepository")
 */
class Tornooi
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
    private $omschrijving;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $datum;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Speler", mappedBy="tornooi")
     */
    private $spelers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Wedstrijd", mappedBy="tornooi")
     */
    private $wedstrijden;

    public function __construct()
    {
        $this->spelers = new ArrayCollection();
        $this->wedstrijden = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOmschrijving(): ?string
    {
        return $this->omschrijving;
    }

    public function setOmschrijving(string $omschrijving): self
    {
        $this->omschrijving = $omschrijving;

        return $this;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(\DateTimeInterface $datum): self
    {
        $this->datum = $datum;

        return $this;
    }

    /**
     * @return Collection|Speler[]
     */
    public function getSpelers(): Collection
    {
        return $this->spelers;
    }

    public function addSpeler(Speler $speler): self
    {
        if (!$this->spelers->contains($speler)) {
            $this->spelers[] = $speler;
            $speler->addTornooi($this);
        }

        return $this;
    }

    public function removeSpeler(Speler $speler): self
    {
        if ($this->spelers->contains($speler)) {
            $this->spelers->removeElement($speler);
            $speler->removeTornooi($this);
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
            $wedstrijden->setTornooi($this);
        }

        return $this;
    }

    public function removeWedstrijden(Wedstrijd $wedstrijden): self
    {
        if ($this->wedstrijden->contains($wedstrijden)) {
            $this->wedstrijden->removeElement($wedstrijden);
            // set the owning side to null (unless already changed)
            if ($wedstrijden->getTornooi() === $this) {
                $wedstrijden->setTornooi(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getOmschrijving().' - '.date_format($this->getDatum(), 'd-m-Y H:i');
    }
}
