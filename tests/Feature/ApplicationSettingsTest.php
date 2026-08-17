<?php

namespace Tests\Feature;

use App\Models\User;
use App\Filament\Pages\ApplicationSettings;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class ApplicationSettingsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_save_links_in_application_settings(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_CANDIDATO,
            'application_text' => 'Initial text',
        ]);

        $this->actingAs($user);

        Livewire::test(ApplicationSettings::class)
            ->set('data.application_text', 'Updated application text')
            ->set('data.github_link', 'https://github.com/testuser')
            ->set('data.linkedin_link', 'https://linkedin.com/in/testuser')
            ->call('save')
            ->assertHasNoErrors();

        $user->refresh();

        $this->assertEquals('Updated application text', $user->application_text);
        $this->assertEquals('https://github.com/testuser', $user->github_link);
        $this->assertEquals('https://linkedin.com/in/testuser', $user->linkedin_link);
    }

    public function test_links_are_optional_in_application_settings(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_CANDIDATO,
            'application_text' => 'Initial text',
        ]);

        $this->actingAs($user);

        Livewire::test(ApplicationSettings::class)
            ->set('data.application_text', 'Updated application text')
            ->set('data.github_link', null)
            ->set('data.linkedin_link', null)
            ->call('save')
            ->assertHasNoErrors();

        $user->refresh();

        $this->assertNull($user->github_link);
        $this->assertNull($user->linkedin_link);
    }
}
