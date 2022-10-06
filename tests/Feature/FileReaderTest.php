<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FileReaderTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_file_read_page_is_accessible()
    {
        $this->actingAsAdmin();
        $response = $this->get('/');
        $response->assertOk();
        $response->assertViewIs('home');
    }

    public function test_file_read_successfully()
    {
        $this->actingAsAdmin();
        $response = $this->get(route('file.reader', ['file' => public_path('index.php')]));
        $response->assertOk();
        $response->assertJsonStructure(['html']);
    }

    public function test_file_unread_successfully()
    {
        $this->actingAsAdmin();
        $response = $this->get(route('file.reader', ['file' => public_path('wrong_index.php')]));
        $response->assertStatus(500);
        $response->assertJsonStructure(['error', 'message']);
        $response->assertJson(['message' => 'unable to find this file']);
    }

    public function test_directory_unread_successfully()
    {
        $this->actingAsAdmin();
        $response = $this->get(route('file.reader', ['file' => public_path()]));
        $response->assertStatus(500);
        $response->assertJsonStructure(['error', 'message']);
        $response->assertJson(['message' => 'unable to handle directory path']);
    }

    private function actingAsAdmin()
    {
        $this->post('/login', [
            'email' => 'admin',
            'password' => 'admin',
        ]);
    }


}
