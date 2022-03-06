<?php

namespace App\Controller;

use App\Entity\Contribution;
Use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;


class ProjectData extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Project $data): array
    {
        $results = [];
        $contributions = [];
        $resultContributions = $data->getContributions();
        $tehcnologies = $data->getTechnologies();
        foreach($resultContributions as $contribution) {
            $contributions[] = [
                "technology" => $contribution->getTechnology(),
                "member" => $contribution->getMembre(),
            ];
        }
        $results[] = [
            "project" => $data,
            "contributions" => $contributions,
            "technologies" => $tehcnologies,
        ];       
        return $results;
    }
}
