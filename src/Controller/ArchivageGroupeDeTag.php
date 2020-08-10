<?php
namespace App\Controller;

use App\Entity\GroupeDeTag;
use Doctrine\ORM\EntityManagerInterface;




class ArchivageGroupeDeTag
{
    private $archives;
    public function __construct(EntityManagerInterface $manager)
    {
        $this -> archives = $manager;
    }

    public function __invoke(GroupeDeTag $data): GroupeDeTag
    {
        $data -> setArchives(1);
        $this -> archives -> flush();
        return $data;
    }
}