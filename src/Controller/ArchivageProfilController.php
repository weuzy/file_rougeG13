<?php

namespace App\Controller;

use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @var EntityManagerInterface
 */
class ArchivageProfilController
{
    private $archive;
    public function __construct(EntityManagerInterface $manager)
    {
        $this -> archive = $manager;
    }
    public function __invoke(Profil $data): Profil
    {
         $data -> setArchives(1);
        //$this -> archive -> persist($update);
        $this -> archive -> flush();
        return $data;
    }
}
