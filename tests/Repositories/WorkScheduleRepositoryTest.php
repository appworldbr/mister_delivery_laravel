<?php namespace Tests\Repositories;

use App\Models\WorkSchedule;
use App\Repositories\WorkScheduleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class WorkScheduleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var WorkScheduleRepository
     */
    protected $workScheduleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->workScheduleRepo = \App::make(WorkScheduleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_work_schedule()
    {
        $workSchedule = WorkSchedule::factory()->make()->toArray();

        $createdWorkSchedule = $this->workScheduleRepo->create($workSchedule);

        $createdWorkSchedule = $createdWorkSchedule->toArray();
        $this->assertArrayHasKey('id', $createdWorkSchedule);
        $this->assertNotNull($createdWorkSchedule['id'], 'Created WorkSchedule must have id specified');
        $this->assertNotNull(WorkSchedule::find($createdWorkSchedule['id']), 'WorkSchedule with given id must be in DB');
        $this->assertModelData($workSchedule, $createdWorkSchedule);
    }

    /**
     * @test read
     */
    public function test_read_work_schedule()
    {
        $workSchedule = WorkSchedule::factory()->create();

        $dbWorkSchedule = $this->workScheduleRepo->find($workSchedule->id);

        $dbWorkSchedule = $dbWorkSchedule->toArray();
        $this->assertModelData($workSchedule->toArray(), $dbWorkSchedule);
    }

    /**
     * @test update
     */
    public function test_update_work_schedule()
    {
        $workSchedule = WorkSchedule::factory()->create();
        $fakeWorkSchedule = WorkSchedule::factory()->make()->toArray();

        $updatedWorkSchedule = $this->workScheduleRepo->update($fakeWorkSchedule, $workSchedule->id);

        $this->assertModelData($fakeWorkSchedule, $updatedWorkSchedule->toArray());
        $dbWorkSchedule = $this->workScheduleRepo->find($workSchedule->id);
        $this->assertModelData($fakeWorkSchedule, $dbWorkSchedule->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_work_schedule()
    {
        $workSchedule = WorkSchedule::factory()->create();

        $resp = $this->workScheduleRepo->delete($workSchedule->id);

        $this->assertTrue($resp);
        $this->assertNull(WorkSchedule::find($workSchedule->id), 'WorkSchedule should not exist in DB');
    }
}
