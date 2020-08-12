<?php
namespace App\Controller;

use App\Entity\Groupe;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @var EntityManagerInterface
 */
class ArchivageGroupe
{
    private $archive;

    public function __construct(EntityManagerInterface $manager)
    {
        $this -> archive = $manager;
    }
    public function __invoke(Groupe $data): Groupe
    {
        $data -> setArchive(0);
        $this -> archive -> flush();
        return $data;
    }
}