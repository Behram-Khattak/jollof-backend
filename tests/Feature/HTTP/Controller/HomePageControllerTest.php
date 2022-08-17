<?php

namespace Tests\Feature\HTTP\Controller;

use App\Enums\BusinessTypeEnum;
use App\Models\HomeImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageControllerTest extends TestCase
{
    
//    use RefreshDatabase;
    public function testExample()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
