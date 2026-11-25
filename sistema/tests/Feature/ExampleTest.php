<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_guest_is_redirected_to_login_for_dashboard_and_medicines(): void
    {
        $this->get('/')
            ->assertRedirect(route('login'));

        $this->get(route('medicines.index'))
            ->assertRedirect(route('login'));
    }
}
