<?php

namespace Tests\Unit;

use App\Models\Settings;
use App\Models\SettingType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * @internal
 *
 * @covers \App\Models\Settings
 */
class SettingsTest extends TestCase
{
    use RefreshDatabase;

    private $setting;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setting = Settings::create([
            'setting_type_id' => factory(SettingType::class)->create()->id,
            'name'            => 'Order Placed',
            'value'           => 'This is a random text',
        ]);
    }

    /** @test */
    public function it_has_a_name()
    {
        $this->assertEquals('Order Placed', $this->setting->name);
    }

    /** @test */
    public function it_has_a_value()
    {
        $this->assertEquals('This is a random text', $this->setting->value);
    }

    /** @test */
    public function it_has_a_slug()
    {
        $this->assertEquals(Str::slug($this->setting->name), $this->setting->slug);
    }

    /** @test */
    public function it_belongs_to_a_setting_type()
    {
        $this->assertInstanceOf(SettingType::class, $this->setting->type);
    }

    /** @test */
    public function it_has_many_audit_logs()
    {
        $this->assertInstanceOf(Collection::class, $this->setting->audits);
    }
}
