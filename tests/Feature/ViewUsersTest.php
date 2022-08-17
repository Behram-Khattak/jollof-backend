<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RoleSeeder;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ViewUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|User|User[]
     */
    private $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->seed(RoleSeeder::class);

        $this->admin = factory(User::class)
            ->create()
            ->assignRole('admin')
            ->givePermissionTo(
                factory(Permission::class)->create(['name' => 'read-users'])
            );
    }

    /** @test */
    public function authenticated_users_with_permissions_can_view_all_users_grouped_by_their_roles()
    {
        $this->actingAs($this->admin);

        $this->get(route('admin.users.index'))
            ->assertOk()
            ->assertViewIs('admin.users.index');
    }

    /** @test */
    public function authenticated_users_with_permissions_can_view_a_user()
    {
        $this->actingAs($this->admin);

        $user = factory(User::class)->create();

        $this->get(route('admin.users.show', ['user' => $user]))
            ->assertOk()
            ->assertViewIs('admin.users.show');
    }
}
