<?php

namespace Tests\Unit;

use App\Models\Settings;
use App\Models\SettingType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * @internal
 *
 * @covers \App\Models\SettingType
 */
class SettingTypeTest extends TestCase
{
    use RefreshDatabase;
    private $type;

    protected function setUp(): void
    {
        parent::setUp();

        $this->type = SettingType::create([
            'name' => 'Random Name',
        ]);

        factory(Settings::class)->create(['setting_type_id' => $this->type->id]);
    }

    /** @test */
    public function it_has_a_name()
    {
        $this->assertEquals('Random Name', $this->type->name);
    }

    /** @test */
    public function it_has_a_slug()
    {
        $this->assertEquals(Str::slug($this->type->name), $this->type->slug);
    }

    /** @test */
    public function it_has_many_settings()
    {
        $this->assertInstanceOf(Collection::class, $this->type->settings);
    }
}
