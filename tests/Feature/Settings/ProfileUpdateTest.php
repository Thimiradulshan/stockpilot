<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('profile.edit'))
            ->assertOk()
            ->assertDontSee('Delete account')
            ->assertDontSee('delete-user');
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test('pages::settings.profile')
            ->set('name', 'Updated User')
            ->set('email', 'updated@example.com')
            ->call('updateProfileInformation')
            ->assertHasNoErrors();

        $user->refresh();

        $this->assertSame('Updated User', $user->name);
        $this->assertSame('updated@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_email_address_is_unchanged(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $verifiedAt = $user->email_verified_at;

        $this->actingAs($user);

        Livewire::test('pages::settings.profile')
            ->set('name', 'Updated User')
            ->set('email', $user->email)
            ->call('updateProfileInformation')
            ->assertHasNoErrors();

        $user->refresh();

        $this->assertSame(
            $verifiedAt->toDateTimeString(),
            $user->email_verified_at?->toDateTimeString()
        );
    }

    public function test_self_account_deletion_is_not_available(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test('pages::settings.profile')
            ->assertDontSee('Delete account')
            ->assertDontSee('delete-user')
            ->assertDontSee('deleteUser');

        $this->assertNotNull($user->fresh());
        $this->assertAuthenticatedAs($user);
    }
}
