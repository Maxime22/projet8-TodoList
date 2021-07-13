<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase{

    public function getValidEntity(): User
    {
        return (new User())
            ->setUsername("Jean")
            ->setEmail("jean@hotmail.fr")
            ->setPassword("1234Jean%1234")
            ->setRoles(['ROLE_ADMIN'])
            ;
    }

    public function assertHasErrors(User $user, int $errorNumber = 0)
    {
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($user);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[]= $error->getPropertyPath(). ' => ' . $error->getMessage();
        }
        $this->assertCount($errorNumber, $errors, implode(', ', $messages));
    }

    /* VALIDATORS */
    public function testValidUser()
    {
        $user = $this->getValidEntity();
        $this->assertHasErrors($user);
    }

    public function testInvalidEmailUser()
    {
        $user = $this->getValidEntity()->setEmail("Je");
        $this->assertHasErrors($user, 1);
    }

    public function testNotBlankEmailUser()
    {
        $user = $this->getValidEntity()->setEmail("");
        $this->assertHasErrors($user, 1);
    }

    public function testInvalidPasswordSizeUser()
    {
        $user = $this->getValidEntity()->setPassword("Je%1");
        $this->assertHasErrors($user, 1);
    }

    public function testNotBlankPasswordUser()
    {
        $user = $this->getValidEntity()->setPassword("");
        $this->assertHasErrors($user, 1);
    }

    public function testInvalidPasswordNoMajUser()
    {
        $user = $this->getValidEntity()->setPassword("ee12%defzefez");
        $this->assertHasErrors($user, 1);
    }

    public function testInvalidPasswordNoMinUser()
    {
        $user = $this->getValidEntity()->setPassword("EE12%CSDSF");
        $this->assertHasErrors($user, 1);
    }

    public function testInvalidPasswordNoSpecialCharUser()
    {
        $user = $this->getValidEntity()->setPassword("EE12dCSDSF");
        $this->assertHasErrors($user, 1);
    }

    public function testInvalidPasswordNoNumberUser()
    {
        $user = $this->getValidEntity()->setPassword("EE%dCSDSF");
        $this->assertHasErrors($user, 1);
    }

    public function testInvalidUsedEmailUser(){
        $user = $this->getValidEntity()->setEmail("admin@hotmail.fr");
        $this->assertHasErrors($user, 1);
    }

}