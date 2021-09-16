<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookControllerTest extends TestCase
{

    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function shouldReturnAllBooks()
    {
        $user = User::find(1);
        Sanctum::actingAs($user);

        $response = $this->get('/api/books');
        $response->assertOk();

        $data = $response->json();
        $this->assertIsArray($data);
    }

    /**
     * @test
     */
    public function shouldBeCreatedNewBook()
    {
        $user = User::find(1);
        Sanctum::actingAs($user);

        $payload = [
            'title' => $this->faker->company,
            'description' => $this->faker->sentence,
            'author' => $this->faker->name,
            'number_page' => $this->faker->buildingNumber,
        ];

        $response = $this->post('/api/books', $payload);

        $data = $response->json();

        $this->assertIsArray($data);
        $response->assertCreated();
    }

    /**
     * @test
     */
    public function shouldBeUpdatedNewBook()
    {
        $user = User::find(1);
        Sanctum::actingAs($user);

        $payload = [
            'title' => $this->faker->company,
            'description' => $this->faker->sentence,
            'author' => $this->faker->name,
            'number_page' => $this->faker->buildingNumber,
        ];

        $response = $this->post('/api/books', $payload);

        $book = $response->json();

        $book['title'] = 'Updated title';

        $response = $this->put("/api/books/{$book['id']}", $book);

        $data = $response->json();

        $this->assertIsArray($data);
        $response->assertOk();
    }

    /**
     * @test
     */
    public function shouldRejectForbiddenRequest()
    {
        $response = $this->get("/api/books");

        $response->assertRedirect();
    }

}
