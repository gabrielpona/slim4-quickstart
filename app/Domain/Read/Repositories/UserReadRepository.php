<?php

namespace App\Domain\Read\Repositories;

use App\Domain\Read\Models\UserModel;
use Doctrine\ORM\EntityManagerInterface;


class UserReadRepository implements IUserReadRepository
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function listAll(): array
    {
        return $this->entityManager->getRepository(UserModel::class)->findAll();
    }


}

?>