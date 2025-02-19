<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const DEMO_USER_REFERENCE = 'demo-user';

    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
    * @return void
    */
    public function load(ObjectManager $manager)
    {
        $data = [
            "username" => ['admin','demo'],
            "mail" => ['admin@hotmail.fr', 'demo@hotmail.fr'],
            "roles" => [['ROLE_ADMIN'],['ROLE_USER']]
        ];

        for ($i = 0; $i < count($data['username']); $i++) {
            $user = new User();
            $user->setUsername($data['username'][$i]);
            $user->setEmail($data['mail'][$i]);
            $user->setRoles($data['roles'][$i]);
            $user->setPassword($this->passwordHasher->hashPassword($user, "1234Jean%1234"));
            $manager->persist($user);
            if ($data['username'][$i] === "demo") {
                $this->addReference(self::DEMO_USER_REFERENCE, $user);
            }
        }

        $manager->flush();
    }
}
