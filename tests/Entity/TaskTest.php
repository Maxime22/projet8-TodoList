<?php

namespace App\Tests\Entity;

use DateTime;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{
    public function setUp(): void
    {
        $this->em = self::getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function getValidEntity(): Task
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "admin"]);

        return (new Task())
            ->setTitle("Hello")
            ->setContent("Blablablablabla")
            ->setCreatedAt()
            ->toggle(false)
            ->setAuthor($user)
            ;
    }

    public function assertHasErrors(Task $task, int $errorNumber = 0)
    {
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($task);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[]= $error->getPropertyPath(). ' => ' . $error->getMessage();
        }
        $this->assertCount($errorNumber, $errors, implode(', ', $messages));
    }

    public function testValidTask()
    {
        $task = $this->getValidEntity();
        $this->assertHasErrors($task);
    }

    public function testCreatedAt()
    {
        $task = $this->getValidEntity();
        $this->assertInstanceOf(DateTime::class, $task->getCreatedAt());
    }
}