<?php
namespace App\Controller;

use App\Entity\GroupesDeCompetences;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @var EntityManagerInterface
 */

class ArchivageGroupesDeCompetences
{
    private $archives;
    public function __construct(EntityManagerInterface $manager)
    {
        $this -> archives = $manager;
    }

    public function __invoke(GroupesDeCompetences $data): GroupesDeCompetences
    {
        $data -> setArchives(1);
        $this -> archives -> flush();
        return $data;
    }
}