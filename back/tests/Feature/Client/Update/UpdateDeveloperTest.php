<?php

namespace Tests\Feature\Client\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperUpdatingClient()
    {
        $client_id = 1;

        $client_data = [
            'name'      => 'AS Something',
            'reference' => '00-0000',
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris',
        ];
        $data = array_merge($client_data, $address_data);

        $this->assertDatabaseMissing('clients', $client_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PUT', route('clients.update', ['client_id' => $client_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'addressId',
                'name',
                'reference',
                'createdAt',
                'updatedAt',
                'address',
            ]);

        $this->assertDatabaseHas('clients', $client_data);
        $this->assertDatabaseHas('addresses', $address_data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingClientWithAlreadyUsedData()
    {
        $client_id = 1;

        $client_data = [
            'name'      => 'AS Connect', // Already used
            'reference' => '01-0001' // Already used
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris',
        ];
        $data = array_merge($client_data, $address_data);

        $this->assertDatabaseHas('clients', $client_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PUT', route('clients.update', ['client_id' => $client_id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name', 'reference']);

        $this->assertDatabaseHas('clients', $client_data);
        $this->assertDatabaseMissing('addresses', $address_data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUserWithoutData()
    {
        $client_id = 1;

        $this->json('PUT', route('clients.update', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'name',
                'reference',
                'street',
                'zip_code',
                'city',
            ]);
    }
}
