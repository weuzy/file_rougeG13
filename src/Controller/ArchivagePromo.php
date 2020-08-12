<?php
namespace App\Controller;

use App\Entity\Promo;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @var EntityManagerInterface
 */
class ArchivagePromo
{
    private $archive;

    public function __construct(EntityManagerInterface $manager)
    {
        $this -> archive = $manager;
    }
    public function __invoke(Promo $data): Promo
    {
        $data -> setArchive(0);
        $this -> archive -> flush();
        return $data;
    }
}