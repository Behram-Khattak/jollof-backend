<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\SettingType;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RoleSeeder;
use SettingsSeeder;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class ViewSettingsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|User|User[]
     */
    private $user;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|User|User[]
     */
    private $admin;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|SettingType
     */
    private $type;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->seed(RoleSeeder::class);
        $this->seed(SettingsSeeder::class);
        $this->type = factory(SettingType::class)->create();

        $this->user = factory(User::class)->create()->assignRole('admin');

        $this->admin = factory(User::class)
            ->create()
            ->assignRole('admin')
            ->givePermissionTo(
                factory(Permission::class)->create(['name' => 'read_settings'])
            );
    }

    /** @test */
    public function guest_users_can_not_view_settings()
    {
        $this->expectException(AuthenticationException::class);

        $this->get(route('admin.settings.index', $this->type));
    }

    /** @test */
    public function authenticated_users_without_appropriate_permissions_can_not_view_settings()
    {
        $this->expectException(AuthorizationException::class);

        $this->actingAs($this->user);

        $this->get(route('admin.settings.index', $this->type));
    }

    /** @test */
    public function authenticated_users_with_appropriate_permission_can_view_settings()
    {
        $this->actingAs($this->admin);

        $this->get(route('admin.settings.index', $this->type))
            ->assertOk()
            ->assertViewIs('admin.settings.index');
    }
}
