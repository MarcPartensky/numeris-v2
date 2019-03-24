<?php

namespace Tests\Feature\User\UpdateTermsOfUse;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Tests\TestCaseWithAuth;

class UpdateTermsOfUseAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingHisOwnTermsOfUse()
    {
        $user_id = 4; // Own terms-of-use

        User::find($user_id)->update(['tou_accepted' => false]);

        $data = [
            'tou_accepted' => true
        ];

        $this->json('PATCH', route('users.update.terms-of-use', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'phone',
                'nationality',
                'birthDate',
                'birthCity',
                'socialInsuranceNumber',
                'iban',
                'bic',
                'createdAt',
                'updatedAt',
            ]);
    }
}
