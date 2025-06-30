<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Record;
use Illuminate\Support\Str;

class RecordApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_records()
    {
        Record::factory()->count(3)->create();

        $response = $this->getJson('/api/records');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_create_a_record()
    {
        $recordData = [
            'name' => 'Test Record',
            'description' => 'Description for the test record.',
            'code' => 'TESTCODE123',
            'status' => 'active',
        ];

        $response = $this->postJson('/api/records', $recordData);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'name' => 'Test Record',
                     'code' => 'TESTCODE123',
                 ]);

        $this->assertDatabaseHas('records', [
            'code' => 'TESTCODE123',
        ]);
    }

    public function test_cannot_create_record_with_missing_fields()
    {
        $response = $this->postJson('/api/records', [
            'name' => 'Partial Record',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['code', 'status']);
    }

    public function test_can_get_a_single_record()
    {
        $record = Record::factory()->create();

        $response = $this->getJson('/api/records/' . $record->uuid);

        $response->assertStatus(200)
                 ->assertJson([
                     'uuid' => $record->uuid,
                     'name' => $record->name,
                 ]);
    }

    public function test_can_update_a_record()
    {
        $record = Record::factory()->create();

        $updatedData = [
            'name' => 'Updated Record Name',
            'description' => 'Updated description.',
            'code' => 'UPDATEDCODE',
            'status' => 'inactive',
        ];

        $response = $this->putJson('/api/records/' . $record->uuid, $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => 'Updated Record Name',
                     'code' => 'UPDATEDCODE',
                 ]);

        $this->assertDatabaseHas('records', [
            'uuid' => $record->uuid,
            'name' => 'Updated Record Name',
            'code' => 'UPDATEDCODE',
        ]);
    }

    public function test_cannot_update_record_with_duplicate_code()
    {
        Record::factory()->create(['code' => 'CODE1']);
        $recordToUpdate = Record::factory()->create(['code' => 'CODE2']);

        $response = $this->putJson('/api/records/' . $recordToUpdate->uuid, [
            'name' => 'New Name',
            'code' => 'CODE1',
            'status' => 'active'
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['code']);
    }

    public function test_can_delete_a_record()
    {
        $record = Record::factory()->create();

        $response = $this->deleteJson('/api/records/' . $record->uuid);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('records', [
            'uuid' => $record->uuid,
        ]);
    }

    public function test_cannot_delete_non_existent_record()
    {
        $nonExistentUuid = Str::uuid();

        $response = $this->deleteJson('/api/records/' . $nonExistentUuid);

        $response->assertStatus(404);
    }
}
