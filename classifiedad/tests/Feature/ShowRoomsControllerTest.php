<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models;
//use GuzzleHttp\Psr7\UploadedFile;



class ShowRoomsControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/rooms');

        $response->assertStatus(200)
                ->assertSeeText('Type')
                ->assertViewIs('rooms.index')
                ->assertViewHas('rooms');
    }

    public function testRoomParameter(){
        $roomTypes = Models\RoomType::factory()->count(3)->create();
        $rooms = Models\Room::factory()->count(20)->create();
        $roomType = $roomTypes->random();
        
        $response = $this->get('/rooms/'.$roomType->id);
        $response->assertStatus(200)
                ->assertSeeText('Type')
                ->assertViewIs('rooms.index')
                ->assertViewHas('rooms')
                ->assertSeeText($roomType->name);
    }
    public function testUpdateFile(){
       //Storage::fake('pictures');
        //$file = UploadedFile::fake()->image('sample.jpg');
        $roomType = Models\RoomType::factory()->create();
         $response = $this->put('/room_types/{$roomType->id}',['picture'=>UploadedFile::fake()->image('sample.jpg')]);
        $response->assertStatus(302)
                    ->assertRedirect('/room_types');
        Storage::disk('public')->assertExists('sample.jpg');
    }
}