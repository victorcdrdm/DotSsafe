<?php

namespace App\Controller;

Use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;


class MemberData extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Member $data)
    {
        $result = [];
        $contributions = $data->getContributions();
        foreach ($contributions as $contribution) {
            if(!in_array($contribution['technology'], $result)) {
                array_push($result, $contribution['technology']);
            }
        }
        $result = $contributions;             
        return $result;
    }
}
