<?php

namespace App\Entity;

use App\Repository\UploadRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UploadRepository::class)
 */
class Upload
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ficName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ficNameOrigine;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getFicName(): ?string
    {
        return $this->ficName;
    }

    public function setFicName(string $ficName): self
    {
        $this->ficName = $ficName;

        return $this;
    }

    public function getFicNameOrigine(): ?string
    {
        return $this->ficNameOrigine;
    }

    public function setFicNameOrigine(?string $ficNameOrigine): self
    {
        $this->ficNameOrigine = $ficNameOrigine;

        return $this;
    }
}
