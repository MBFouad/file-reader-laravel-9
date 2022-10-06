<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_redirect_to_login_page()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function test_login_page_has_success_response()
    {
        $response = $this->get('/login');

        $response->assertOk();
    }

    public function test_register_page_has_not_found_response()
    {
        $response = $this->get('/register');

        $response->assertNotFound();
    }

    public function test_login_successfully()
    {
        $response = $this->post('/login', [
            'email' => 'admin',
            'password' => 'admin',
        ]);
        $response->assertSessionHas('authenticated', true);
        $response->assertRedirect('/');
    }

    public function test_login_failed()
    {
        $response = $this->post('/login', [
            'email' => 'admin_wrong',
            'password' => 'admin',
        ]);
        $response->assertSessionMissing('authenticated');
        $response->assertSessionHasErrors('email');
    }
}
