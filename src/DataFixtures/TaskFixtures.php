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

        $authorAdmin = UserFixtures::DEMO_USER_ADMIN_REFERENCE;
        $authorLambda = UserFixtures::DEMO_USER_LAMBDA_REFERENCE;

        $data = [
            "title" => ['Tâche 1', 'Tâche 2', 'Tâche 3', 'Tâche 4', 'Tâche 5'],
            "content" => ['Faire du sport', 'Ranger la maison', 'Faire la vaisselle', 'Aller courir', 'Faire une session CodinGame'],
            "isDone" => [true, false, true, false, true]
        ];

        for ($i = 0; $i < count($data['username']); $i++) {
            $task = new Task();
            $task->setCreatedAt();
            $task->setTitle($data["title"][$i]);
            $task->setContent($data["content"][$i]);
            $task->toggle($data["isDone"][$i]);
            if($i%2==0){
                $this->getReference($authorAdmin);
            }else{
                $this->getReference($authorLambda);
            }
            $manager->persist($task);
        }

        $manager->flush();
    }

    // otherwise, by default, fixtures are linked in the alphabetical order
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
