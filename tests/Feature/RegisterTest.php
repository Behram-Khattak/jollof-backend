<?php

namespace Tests\Feature;

use App\Enums\DefaultRoles;
use App\Models\BusinessType;
use App\Models\User;
use BusinessTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use RoleSeeder;
use Tests\TestCase;

/**
 * @internal
 *
 * @covers \App\Http\Controllers\Auth\RegisterController
 */
class RegisterTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(BusinessTypeSeeder::class);
        $this->seed(RoleSeeder::class);
    }

    /** @test */
    public function authenticated_users_can_not_visit_the_register_route()
    {
        $this->actingAs(factory(User::class)->create());

        $this->get(route('register'))->assertRedirect();
        $this->get(route('merchant.register'))->assertRedirect();
    }

    /** @test */
    public function guests_can_create_customer_accounts()
    {
        $this->withoutExceptionHandling();

        $form = [
            'role'                   => $role = DefaultRoles::USER,
            'first_name'             => $this->faker->firstName,
            'last_name'              => $this->faker->lastName,
            'username'               => $this->faker->unique()->firstName,
            'email'                  => $this->faker->unique()->safeEmail,
            'password'               => 'password',
            'password_confirmation'  => 'password',
            'terms'                  => 'on',
        ];

        $this->post(route('register'), $form);

        $this->assertDatabaseHas('users', [
            'first_name' => $form['first_name'],
            'last_name'  => $form['last_name'],
            'username'   => $form['username'],
            'email'      => $form['email'],
        ]);

        $user = User::whereEmail($form['email'])->firstOrFail();

        $this->assertTrue($user->hasRole($role));

        $this->assertGuest();
    }

    /** @test */
    public function guests_can_create_merchant_accounts()
    {
        $this->withoutExceptionHandling();

        $form = [
            'role'                   => $role = DefaultRoles::MERCHANT,
            'first_name'             => $this->faker->firstName,
            'last_name'              => $this->faker->lastName,
            'username'               => $this->faker->unique()->firstName,
            'email'                  => $this->faker->unique()->safeEmail,
            'telephone'              => $this->faker->e164PhoneNumber,
            'business_type'          => (string) BusinessType::first()->id,
            'business_name'          => $this->faker->company,
            'business_description'   => $this->faker->paragraph,
            'state'                  => $this->faker->state,
            'city'                   => $this->faker->city,
            'address'                => $this->faker->streetAddress,
            'terms'                  => 'on',
            'password'               => 'password',
            'password_confirmation'  => 'password',
        ];

        $this->post(route('register'), $form);

        $this->assertDatabaseHas('users', [
            'first_name' => $form['first_name'],
            'last_name'  => $form['last_name'],
            'username'   => $form['username'],
            'email'      => $form['email'],
            'telephone'  => $form['telephone'],
        ]);

        $user = User::whereEmail($form['email'])->firstOrFail();

        $this->assertDatabaseHas('businesses', [
            'owner_id'          => $user->id,
            'business_type_id'  => $form['business_type'],
            'name'              => $form['business_name'],
            'description'       => $form['business_description'],
        ]);

        $this->assertTrue($user->hasRole($role));

        $this->assertGuest();
    }
}
