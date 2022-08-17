<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class EditSettingsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|User|User[]
     */
    private $admin;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|User|User[]
     */
    private $user;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|Settings
     */
    private $setting;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->seed(\RoleSeeder::class);

        $this->setting = factory(Settings::class)->create();

        $this->user = factory(User::class)->create()->assignRole('admin');

        $this->admin = factory(User::class)
            ->create()
            ->assignRole('admin')
            ->givePermissionTo(
                factory(Permission::class)->create(['name' => 'update-settings'])
            );
    }

    /** @test */
    public function guest_users_can_not_edit_or_update_settings()
    {
        $this->expectException(AuthenticationException::class);

        $this->get(route('admin.settings.edit', [$this->setting->type, $this->setting]));

        $this->patch(route('admin.settings.update', [$this->setting->type, $this->setting]));
    }

    /** @test */
    public function authenticated_users_without_appropriate_permissions_can_not_edit_or_update_settings()
    {
        $this->expectException(AuthorizationException::class);

        $this->actingAs($this->user);

        $this->get(route('admin.settings.edit', [$this->setting->type, $this->setting]));

        $this->patch(route('admin.settings.update', [$this->setting->type, $this->setting]));
    }

    /** @test */
    public function authenticated_users_with_appropriate_permissions_can_view_form_to_edit_settings()
    {
        $this->actingAs($this->admin);

        $this->get(route('admin.settings.edit', [$this->setting->type, $this->setting]))
            ->assertOk()
            ->assertViewIs('admin.settings.edit');
    }
}
