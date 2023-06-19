<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SizeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_sizes_as_an_array()
    {
        // $data = [
        //     'sizes' => ['S', 'M', 'L', 'XL'],
        // ];

        $sizes = ['S', 'M', 'L', 'XL'];

        $response = $this->postJson('/api/sizes', $sizes);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Sizes created successfully',
            ]);

        $this->assertDatabaseHas('sizes', [
            'sizes' => json_encode($sizes['sizes']),
        ]);
    }
}
