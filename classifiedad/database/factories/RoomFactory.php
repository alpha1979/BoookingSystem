<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Room::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $roomTypes = DB::table('room_types')->pluck('id')->all();
        return [
            //
            'number'=>$this->faker->unique()->randomNumber(),
            'room_type_id'=>$this->faker->randomElement($roomTypes)
        ];
    }
}