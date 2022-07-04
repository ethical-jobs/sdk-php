<?php
declare(strict_types=1);

namespace Tests\Fixtures;

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Tests\Fixtures\Models\Family;
use Tests\Fixtures\Models\Person;
use Tests\Fixtures\Models\Vehicle;

class ModelMock
{
    /** @var \Illuminate\Database\Eloquent\Model */
    private $model;

    /** @var \Faker\Generator */
    private $faker;

    public function __construct(string $model)
    {
        $this->model = new $model;
        $this->faker = Factory::create();
    }

    public function create(?array $data = []): Model
    {
        $data = array_merge($this->getDefaults(), $data);

        $this->model->forceFill($data);

        $this->model->save();

        return $this->model;
    }

    private function getDefaults(): array
    {
        $data = [];

        switch (get_class($this->model)) {
            case Family::class:
                $data = [
                    'surname' => $this->faker->name,
                ];
                break;
            case Person::class:
                $data = [
                    'first_name' => $this->faker->firstName,
                    'last_name' => $this->faker->lastName,
                    'email' => $this->faker->email,
                    'sex' => $this->faker->randomElement(['female', 'male']),
                    'deleted_at' => null,
                ];
                break;
            case Vehicle::class:
                $data = [
                    'year' => $this->faker->numberBetween(1990,2030),
                    'make' => $this->faker->company,
                    'model' => $this->faker->word,
                ];
                break;
        }

        return $data;
    }
}
