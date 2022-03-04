<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ContributionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *      itemOperations={
 *          "put",
 *          "get",
 *          "get_data_contribution"={
 *              "method"="GET",
 *              "path"="/contributions/{id}/data",
 *              "controller"="App\Controller\ContributionData",
 *          }
 *      }
 * )
 * @ORM\Entity(repositoryClass=ContributionRepository::class)
 */
class Contribution
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="contributions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity=Member::class, inversedBy="contributions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $membre;

    /**
     * @ORM\ManyToOne(targetEntity=Technology::class, inversedBy="contributions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $technology;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getMembre(): ?Member
    {
        return $this->membre;
    }

    public function setMembre(?Member $membre): self
    {
        $this->membre = $membre;

        return $this;
    }

    public function getTechnology(): ?Technology
    {
        return $this->technology;
    }

    public function setTechnology(?Technology $technology): self
    {
        $this->technology = $technology;

        return $this;
    }
}
