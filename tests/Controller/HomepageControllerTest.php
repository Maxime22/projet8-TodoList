<?php

namespace Tests\Controller;

use App\Entity\User;
use App\Tests\NeedLoginTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageControllerTest extends WebTestCase
{
    use NeedLoginTrait;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->em = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
    }
    
    public function testHomePageAccessWhenNotConnected()
    {
        $this->client->request('GET', '/');
        $this->assertResponseRedirects();
    }

    public function testHomePageAccesWhenAdminConnected()
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "admin"]);
        $this->login($this->client, $user);
        $this->client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testHomePageAccesWhenUserConnected()
    {
        $user = $this->em->getRepository(User::class)->findOneBy(["username" => "demo"]);
        $this->login($this->client, $user);
        $this->client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
