<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @var EntityManagerInterface
 */
class ArchivageUser
{
    private $archive;
    public function __construct(EntityManagerInterface $manager)
    {
        $this -> archive = $manager;
    }
    public function __invoke(User $data): User
    {
        $data -> setArchives(1);
        $this -> archive -> flush();
        return $data;
    }
}