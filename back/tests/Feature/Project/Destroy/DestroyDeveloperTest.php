<?php

namespace Tests\Feature\Project\Destroy;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     *
     * @dataProvider projectProvider
     */
    public function testDeveloperDeletingProjectWithoutBills($project)
    {
        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertTrue($project->missions->isEmpty());

        $this->json('DELETE', route('projects.destroy', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('projects', $project->toArray());
    }

    /**
     * @group developer
     *
     * @dataProvider projectAndMissionWithBillsProvider
     */
    public function testDeveloperDeletingProjectWithBills($project, $mission)
    {
        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertDatabaseHas('missions', $mission->toArray());

        $this->json('DELETE', route('projects.destroy', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('projects', $project->toArray());
        $this->assertDatabaseMissing('missions', $mission->toArray());
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingUnknownProject()
    {
        $project_id = 0; // Unknown project

        $this->json('DELETE', route('projects.destroy', ['project_id' => $project_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);
    }
}
