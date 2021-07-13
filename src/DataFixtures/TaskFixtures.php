<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $author = UserFixtures::DEMO_USER_REFERENCE;
        
        $data = [
            "title" => ['Tâche 1', 'Tâche 2', 'Tâche 3', 'Tâche 4', 'Tâche 5'],
            "content" => ['Faire du sport', 'Ranger la maison', 'Faire la vaisselle', 'Aller courir', 'Faire une session CodinGame'],
            "isDone" => [true, false, true, false, true]
        ];

        for ($i = 0; $i < count($data['title']); $i++) {
            $task = new Task();
            $task->setCreatedAt();
            $task->setTitle($data["title"][$i]);
            $task->setContent($data["content"][$i]);
            $task->toggle($data["isDone"][$i]);
            // we need anonymous users for the tasks which already exist
            // except one for the tests that we put to demo user
            if($i===4){
                $task->setAuthor($this->getReference($author));
            }else{
                $task->setAuthor(null);
            }
            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
