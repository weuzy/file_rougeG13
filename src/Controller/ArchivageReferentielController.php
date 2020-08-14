<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Entity\Referentiel;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @var EntityManagerInterface
 */
class ArchivageReferentielController
{
    private $archive;
    public function __construct(EntityManagerInterface $manager)
    {
        $this -> archive = $manager;
    }
    public function __invoke(Referentiel $data): Referentiel
    {
        $data -> setArchive(1);
        //$this -> archive -> persist($update);
        $this -> archive -> flush();
        return $data;
    }
}
