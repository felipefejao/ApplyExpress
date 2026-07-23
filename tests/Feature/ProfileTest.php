<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_dashboard(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_user_profile_fields_are_persisted(): void
    {
        $user = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@applyexpress.test',
            'linkedin' => 'https://linkedin.com/in/demo',
            'github' => 'https://github.com/demo',
            'phone' => '+55 11 99999-9999',
            'bio' => 'Demo user bio',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Demo User',
            'email' => 'demo@applyexpress.test',
            'linkedin' => 'https://linkedin.com/in/demo',
            'github' => 'https://github.com/demo',
            'phone' => '+55 11 99999-9999',
            'bio' => 'Demo user bio',
        ]);
    }

    public function test_user_can_be_authenticated(): void
    {
        $user = User::factory()->create([
            'email' => 'auth@applyexpress.test',
            'password' => bcrypt('password'),
        ]);

        $this->assertTrue(auth()->attempt([
            'email' => 'auth@applyexpress.test',
            'password' => 'password',
        ]));

        $this->assertAuthenticatedAs($user);
    }
}
