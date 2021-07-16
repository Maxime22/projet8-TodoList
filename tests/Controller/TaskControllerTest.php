<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Tests\NeedLoginTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    use NeedLoginTrait;

    public function setUp(): void
    {
        $this->client = static::createClient();

        $this->em = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testListTaskIsRedirected()
    {
        $this->client->request('GET', '/tasks');
        $this->assertResponseRedirects();
    }
    public function testNewTaskIsRedirected()
    {
        $this->client->request('GET', '/tasks/create');
        $this->assertResponseRedirects();
    }

    public function testEditTaskIsRedirected()
    {
        $this->client->request('GET', '/tasks/1/edit');
        $this->assertResponseRedirects();
    }

    public function testToggleTaskIsRedirected()
    {
        $this->client->request('GET', '/tasks/1/toggle');
        $this->assertResponseRedirects();
    }
    
    public function testDeleteTaskIsRedirected()
    {
        $this->client->request('GET', '/tasks/1/delete');
        $this->assertResponseRedirects();
    }

    public function testLetAuthenticatedUserAccessListTask()
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "demo"]);
        $this->login($this->client, $user);

        $this->client->request('GET', '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLetAuthenticatedUserAccessNewTask()
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "demo"]);
        $this->login($this->client, $user);

        $this->client->request('GET', '/tasks/create');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testLetAuthenticatedUserAccessEditTask()
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "demo"]);
        $this->login($this->client, $user);

        $this->client->request('GET', '/tasks/1/edit');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLetAuthenticatedUserAccessToggleTask()
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "demo"]);
        $this->login($this->client, $user);

        $this->client->request('GET', '/tasks/1/toggle');
        $this->assertResponseRedirects();
    }
    public function testNoAccessDeleteTask()
    {
        // this user is not the user who created the task
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "demo"]);
        $this->login($this->client, $user);

        $this->client->request('GET', '/tasks/1/delete');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testAccessDeleteTask()
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "demo"]);
        $this->login($this->client, $user);
        $this->client->request('GET', '/tasks/5/delete');
        $this->assertResponseRedirects();
    }

    public function testAccessAdminDeleteNullAuthorTask()
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "admin"]);
        $this->login($this->client, $user);
        $this->client->request('GET', '/tasks/1/delete');
        $this->assertResponseRedirects();
    }

    public function testNewTask(){
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "demo"]);
        $this->login($this->client, $user);

        $crawler = $this->client->request("GET", "/tasks/create");
        $form = $crawler->selectButton('Ajouter')->form([
            'task[title]' => 'demoComment',
            'task[content]' => 'i am happy to add a content',
        ]);
        $this->client->submit($form);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Liste des tâches');
    }

    public function testEditTask(){
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "demo"]);
        $this->login($this->client, $user);

        $crawler = $this->client->request("GET", "/tasks/1/edit");
        $form = $crawler->selectButton('Modifier')->form([
            'task[title]' => 'demoComment2',
            'task[content]' => 'i am happy to add a content too',
        ]);
        $this->client->submit($form);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Liste des tâches');
    }
}
