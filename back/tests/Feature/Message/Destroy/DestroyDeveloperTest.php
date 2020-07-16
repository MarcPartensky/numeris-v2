<?php

namespace Tests\Feature\Message\Destroy;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group message
     */
    public function testDeveloperDeletingMessage()
    {
        $message = $this->messageProvider();

        $this->assertDatabaseHas('messages', $message->toArray());

        $this->json('DELETE', route('messages.destroy', ['message_id' => $message->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertSoftDeleted('messages', $message->toArray());
    }
}
