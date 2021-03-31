<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\WorkSchedule;

class WorkScheduleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_work_schedule()
    {
        $workSchedule = WorkSchedule::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/work_schedules', $workSchedule
        );

        $this->assertApiResponse($workSchedule);
    }

    /**
     * @test
     */
    public function test_read_work_schedule()
    {
        $workSchedule = WorkSchedule::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/work_schedules/'.$workSchedule->id
        );

        $this->assertApiResponse($workSchedule->toArray());
    }

    /**
     * @test
     */
    public function test_update_work_schedule()
    {
        $workSchedule = WorkSchedule::factory()->create();
        $editedWorkSchedule = WorkSchedule::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/work_schedules/'.$workSchedule->id,
            $editedWorkSchedule
        );

        $this->assertApiResponse($editedWorkSchedule);
    }

    /**
     * @test
     */
    public function test_delete_work_schedule()
    {
        $workSchedule = WorkSchedule::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/work_schedules/'.$workSchedule->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/work_schedules/'.$workSchedule->id
        );

        $this->response->assertStatus(404);
    }
}
