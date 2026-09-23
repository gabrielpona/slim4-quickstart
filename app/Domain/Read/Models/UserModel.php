<?php

namespace App\Domain\Read\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity, ORM\Table(name: 'users')]
final class UserModel {
    #[ORM\Id, ORM\Column(type: 'integer'), ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(type: 'string', unique: true, nullable: false, options: ['collation' => 'NOCASE'])]
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

}



?>
