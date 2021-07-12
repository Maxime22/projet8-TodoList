<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
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
            $task->setAuthor(null);
            $manager->persist($task);
        }

        $manager->flush();
    }
}
