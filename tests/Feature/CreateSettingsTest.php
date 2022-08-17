<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Settings;
use App\Models\SettingType;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RoleSeeder;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class CreateSettingsTest extends TestCase
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

        $this->type = factory(SettingType::class)->create();

        $this->user = factory(User::class)->create()->assignRole('admin');

        $this->admin = factory(User::class)
            ->create()
            ->assignRole('admin')
            ->givePermissionTo(
                factory(Permission::class)->create(['name' => 'create-settings'])
            );
    }

    /** @test */
    public function guest_users_can_not_create_settings()
    {
        $this->expectException(AuthenticationException::class);

        $this->post(route('admin.settings.store', $this->type));
    }

    /** @test */
    public function authenticated_users_without_appropriate_permissions_can_not_create_settings()
    {
        $this->expectException(AuthorizationException::class);

        $this->actingAs($this->user);

        $this->post(route('admin.settings.store', $this->type));
    }

    /** @test */
    public function authenticated_users_with_appropriate_permissions_can_create_settings()
    {
        config()->set('audit.console', true);

        $this->actingAs($this->admin);

        $form = factory(Settings::class)->make(['setting_type_id' => $this->type->id])->toArray();

        $this->post(route('admin.settings.store', $this->type), $form);

        $this->assertDatabaseCount('audits', 1);

        $this->assertDatabaseHas('settings', [
            'setting_type_id' => $this->type->id,
            'name'            => $form['name'],
            'value'           => $form['value'],
        ]);
    }
}
