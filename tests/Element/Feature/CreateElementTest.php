<?php

declare(strict_types=1);

namespace App\Tests\Element\Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateElementTest extends WebTestCase
{
    /** @test */
    public function element_can_be_created_and_retrieved(): void
    {
        $client = static::createClient();

        // Create part
        $client->jsonRequest(
            'POST',
            '/elements',
            [
                'type' => 'products',
                'fields' => [
                    ['name' => 'name', 'value' => 'Box'],
                    ['name' => 'delivered_at', 'value' => '2022-01-01'],
                ]
            ]);

        $response = $client->getResponse();
        $uuid = json_decode($response->getContent(), true)['uuid'];

        $this->assertSame(201, $response->getStatusCode());

        // Retrieve part
        $client->jsonRequest('GET', '/elements/' . $uuid);
        $response = $client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame($uuid, json_decode($response->getContent(), true)['uuid']);
    }
}