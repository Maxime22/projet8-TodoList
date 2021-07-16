<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\NeedLoginTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserControllerTest extends WebTestCase{

    use NeedLoginTrait;

    public function setUp(): void
    {
        $this->client = static::createClient();

        $this->em = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testListUserIsRedirectedWhenNotConnected()
    {
        $this->client->request('GET', '/users');
        $this->assertResponseRedirects();
    }

    public function testListUserIsForbiddenWhenNotAdmin()
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "demo"]);
        $this->login($this->client, $user);

        $this->client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testListUserAccessForAdmin()
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "admin"]);
        $this->login($this->client, $user);

        $this->client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testNewUserIsRedirected()
    {
        $this->client->request('GET', '/users/create');
        $this->assertResponseRedirects();
    }

    public function testEditUserIsRedirected()
    {
        $this->client->request('GET', '/users/1/edit');
        $this->assertResponseRedirects();
    }
    
    public function testLetAuthenticatedUserAdminAccessNewUser()
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "admin"]);
        $this->login($this->client, $user);

        $this->client->request('GET', '/users/create');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
    public function testLetAuthenticatedUserAdminAccessEditUser()
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "admin"]);
        $this->login($this->client, $user);

        $this->client->request('GET', '/users/1/edit');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    
    public function testNewUser(){
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "admin"]);
        $this->login($this->client, $user);

        $crawler = $this->client->request("GET", "/users/create");
        $form = $crawler->selectButton("Ajouter")->form([
            'user[username]' => 'demo3',
            'user[email]' => 'demo3@hotmail.fr',
            'user[password][first]' => '1234Jean%1234',
            'user[password][second]' => '1234Jean%1234',
            'user[roles]' => 'ROLE_ADMIN',

        ]);
        
        $this->client->submit($form);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');
    }
    public function testEditUser(){
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "admin"]);
        $this->login($this->client, $user);

        $crawler = $this->client->request("GET", "/users/1/edit");
        $form = $crawler->selectButton("Modifier")->form([
            'user[username]' => 'demo4',
            'user[email]' => 'demo4@hotmail.fr',
            'user[password][first]' => '1234Jean%12345',
            'user[password][second]' => '1234Jean%12345',
            'user[roles]' => 'ROLE_ADMIN',

        ]);

        $this->client->submit($form);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');
    }


}