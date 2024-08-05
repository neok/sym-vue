<?php

namespace App\Tests\Controller\ApiController;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TicketControllerTest extends WebTestCase
{
    private string $token;
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $body = json_encode([
            "email" => "test@gmail.com",
            "password" => "strange!"
        ]);

        $this->client->request('POST', '/api/login_check', [], [], [], $body);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $json = json_decode($this->client->getResponse()->getContent(), true);
        $this->token = $json['token'];
    }

    public function testGetTicket()
    {
        $this->client->request('GET', '/api/tickets/1', [], [], ['HTTP_AUTHORIZATION' => 'Bearer ' . $this->token]);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
        $json = json_decode($this->client->getResponse()->getContent(), true);
        foreach (['id', 'name', 'price', 'quantity'] as $key) {
            $this->assertArrayHasKey($key, $json);
        }
    }

    public function testEditTicket()
    {
        $body = json_encode([
            "name" => "New Ticket Name",
        ]);

        $this->client->request('PATCH', '/api/tickets/1', [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token,
            'CONTENT_TYPE' => 'application/json'
        ], $body);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $this->client->getResponse()->getStatusCode());
    }

    public function testCreate()
    {
        $body = json_encode([
            "name" => "New Ticket",
            "price" => "100",
            "quantity" => 10,
            "event" => 1
        ]);

        $this->client->request('POST', '/api/tickets', [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token,
            'CONTENT_TYPE' => 'application/json'
        ], $body);

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
        $json = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('name', $json);

    }

    public function testCreateTicketInvalidData()
    {
        $body = json_encode([
            "title" => "",  // Invalid title, assuming title is required
            "description" => "New ticket description"
        ]);

        $this->client->request('POST', '/api/tickets', [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token,
            'CONTENT_TYPE' => 'application/json'
        ], $body);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }
}
