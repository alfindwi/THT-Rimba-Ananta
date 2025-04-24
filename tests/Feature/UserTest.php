<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_users()
    {
        $users = User::factory()->count(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'users');

        $response->assertJsonFragment([
            'name' => $users[0]->name,
            'email' => $users[0]->email,
        ]);
    }

    public function test_get_user_by_id()
    {
        $user = User::factory()->create();

        $response = $this->getJson('/api/users/' . $user->id);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function test_get_user_not_found()
    {
        $response = $this->getJson('/api/users/oqbdqodubqodubq');

        $response->assertStatus(404);

        $response->assertJson([
            'message' => 'User not found',
        ]);
    }

    public function test_create_user()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'B7YHw@example.com',
            'age' => 30,
        ];
        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'message' => 'User created successfully',
        ]);

        $user = $response->json('user');
        $this->assertNotNull($user['id']);
        $this->assertEquals($user['name'], $userData['name']);
        $this->assertEquals($user['email'], $userData['email']);
        $this->assertEquals($user['age'], $userData['age']);

        $userId = $user['id'];

        $this->assertDatabaseHas('users', [
            'id' => $userId,
            'name' => $userData['name'],
            'email' => $userData['email'],
            'age' => $userData['age'],
        ]);
    }

    public function test_create_user_name_missing()
    {
        $userData = [
            'email' => 'B7YHw@example.com',
            'age' => 30,
        ];
        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422);

        $response->assertJsonFragment([
            'errors' => [
                'name' => ['Name is required'],
            ]
        ]);
    }

    public function test_create_user_email_missing()
    {
        $userData = [
            'name' => 'John Doe',
            'age' => 30,
        ];
        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422);

        $response->assertJsonFragment([
            'errors' => [
                'email' => ['Email is required'],
            ]
        ]);
    }

    public function test_create_user_age_missing()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'B7YHw@example.com',
        ];
        $response = $this->postJson('/api/users', $userData);
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'errors' => [
                'age' => ['Age is required'],
            ]
        ]);
    }


    public function test_create_user_email_exists()
    {
        $user = User::factory()->create([
            'email' => 'B7YHw@example.com',
        ]);

        $userData = [
            'name' => 'John Doe',
            'email' => 'B7YHw@example.com',
            'age' => 30,
        ];
        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email' => 'Email already exists',
        ]);
        $this->assertDatabaseMissing('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'age' => $userData['age'],
        ]);
    }

    public function test_update_user()
    {
        $user = User::factory()->create();

        $userData = [
            'name' => 'Jane Doe',
            'email' => 'HrY7U@example.com',
            'age' => 25,
        ];
        $response = $this->putJson('/api/users/' . $user->id, $userData);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'User updated successfully',
        ]);
        $response->assertJsonFragment([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'age' => $userData['age'],
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $userData['name'],
            'email' => $userData['email'],
            'age' => $userData['age'],
        ]);
    }

    public function test_update_user_not_found()
    {
        $userData = [
            'name' => 'Jane Doe',
            'email' => 'HrY7U@example.com',
            'age' => 25,
        ];
        $response = $this->putJson('/api/users/oqbdqodubqodubq', $userData);
        $response->assertStatus(404);
        $response->assertJsonFragment([
            'message' => 'User not found',
        ]);
        $this->assertDatabaseMissing('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'age' => $userData['age'],
        ]);
    }

    public function test_update_user_email_exists()
{
    $user1 = User::factory()->create([
        'email' => 'B7YHw@gmail.com',
    ]);
    $user2 = User::factory()->create([
        'email' => 'HrY7U@gmail.com',
    ]);

    $userData = [
        'name' => 'Jane Doe',
        'email' => 'B7YHw@gmail.com', 
        'age' => 25,
    ];

    $response = $this->putJson('/api/users/' . $user1->id, $userData);

    $response->assertStatus(422);

    $response->assertJsonValidationErrors([
        'email' => 'Email already exists',
    ]);

    $this->assertDatabaseMissing('users', [
        'name' => $userData['name'],
        'email' => $userData['email'],
        'age' => $userData['age'],
    ]);
}

    

    public function test_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson('/api/users/' . $user->id);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'User deleted successfully',
        ]);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
    public function test_delete_user_not_found()
    {
        $response = $this->deleteJson('/api/users/oqbdqodubqodubq');
        $response->assertStatus(404);
        $response->assertJsonFragment([
            'message' => 'User not found',
        ]);
    }
}
