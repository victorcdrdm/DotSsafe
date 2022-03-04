<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProjectRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(itemOperations={
 *          "put",
 *          "get",
 *          "get_data_project"={
 *              "method"="GET",
 *              "path"="/projects/{id}/data",
 *              "controller"="App\Controller\ProjectData",
 *          }
 *      })
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Technology::class, inversedBy="projects")
     */
    private $technologies;

    /**
     * @ORM\OneToMany(targetEntity=Contribution::class, mappedBy="project")
     */
    private $contributions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->technologies = new ArrayCollection();
        $this->contributions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Technology>
     */
    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(Technology $technology): self
    {
        if (!$this->technologies->contains($technology)) {
            $this->technologies[] = $technology;
        }

        return $this;
    }

    public function removeTechnology(Technology $technology): self
    {
        $this->technologies->removeElement($technology);

        return $this;
    }

    /**
     * @return Collection<int, Contribution>
     */
    public function getContributions(): Collection
    {
        return $this->contributions;
    }

    public function addContribution(Contribution $contribution): self
    {
        if (!$this->contributions->contains($contribution)) {
            $this->contributions[] = $contribution;
            $contribution->setProject($this);
        }

        return $this;
    }

    public function removeContribution(Contribution $contribution): self
    {
        if ($this->contributions->removeElement($contribution)) {
            // set the owning side to null (unless already changed)
            if ($contribution->getProject() === $this) {
                $contribution->setProject(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
