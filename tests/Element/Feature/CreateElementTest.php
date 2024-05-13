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
            '/builder/products',
            ['name' => 'Box', 'delivered_at' => '2022-01-01']
        );

        $response = $client->getResponse();
        $uuid = json_decode($response->getContent(), true)['uuid'];

        $this->assertSame(201, $response->getStatusCode());

        // Retrieve part
        $client->jsonRequest('GET', '/elements/' . $uuid);
        $response = $client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(
            [
                'uuid' => $uuid,
                'group' => 'products',
                'fields' => [
                    'name' => 'Box',
                    'delivered_at' => '2022-01-01T00:00:00+00:00',
                ],

            ],
            json_decode($response->getContent(), true)
        );
    }

    /** @test */
    public function element_can_be_updated(): void
    {
        $client = static::createClient();

        // Create part
        $client->jsonRequest(
            'POST',
            '/builder/products',
            ['name' => 'Box', 'delivered_at' => '2022-01-01']
        );

        $response = $client->getResponse();
        $uuid = json_decode($response->getContent(), true)['uuid'];

        $this->assertSame(201, $response->getStatusCode());

        // Update part
        $client->jsonRequest(
            'PATCH',
            '/elements/' . $uuid,
            ['name' => 'Package', 'delivered_at' => '2024-10-10']
        );

        $response = $client->getResponse();

        $this->assertSame(200, $response->getStatusCode());

        // Retrieve part
        $client->jsonRequest('GET', '/elements/' . $uuid);
        $response = $client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(
            [
                'uuid' => $uuid,
                'group' => 'products',
                'fields' => [
                    'name' => 'Package',
                    'delivered_at' => '2024-10-10T00:00:00+00:00',
                ],

            ],
            json_decode($response->getContent(), true)
        );
    }
}