<?php

namespace Tests\Feature\ClientProject\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorAccessingClientProjectIndex()
    {
        $client = $this->clientWithProjectsWithMissionsProvider();

        $this->json('GET', route('clients.projects.index', ['client_id' => $client->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'name',
                    'step',
                    'startAt',
                    'isPrivate',
                    'moneyReceivedAt',
                    'createdAt',
                    'updatedAt',
                    'missionsCount',
                    'usersCount',
                    'client',
                ]],
                'links',
                'meta',
            ]);
    }
}
