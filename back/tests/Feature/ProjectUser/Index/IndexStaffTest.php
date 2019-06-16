<?php

namespace Tests\Feature\ProjectUser\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffAccessingProjectUserIndex()
    {
        $project = $this->privateProjectAndUserInProjectProvider()['project'];

        $this->json('GET', route('projects.users.index', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'preferenceId',
                'addressId',
                'activated',
                'touAccepted',
                'subscriptionPaidAt',
                'email',
                'username',
                'firstName',
                'lastName',
                'studentNumber',
                'promotion',
                'schoolYear',
                'phone',
                'nationality',
                'birthDate',
                'birthCity',
                'socialInsuranceNumber',
                'iban',
                'bic',
                'createdAt',
                'updatedAt',
                'roles',
            ]]);
    }
}
