<?php

namespace App\Controller;

Use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
Use App\Entity\Contribution;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;


class ContributionData extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Contribution $data): array
    {
        $results = [];
        $results[] = [
            "contribution" => $data,
            "member" => $data->getMembre(),
            "technology" => $data->getTechnology(),
            "project" => $data->getProject(),
        ]; 
        /* $contributions = $this->em->getRepository(Contribution::class)->findall();
        foreach($contributions as $contribution) {
            $results[] = [
                "contribution" => $contribution,
                "membre" => $contribution->getMembre(),
                "technology" => $contribution->getTechnology(),
                "projet" => $contribution->getProject(),
            ];
        } */
       
        return $results;
    }
}
