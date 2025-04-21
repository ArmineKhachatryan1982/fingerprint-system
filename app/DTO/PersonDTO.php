<?php
namespace App\DTO;

class PersonDTO
{
    public $id;
    public $entry_code_id;

    public $client_id;
    public $name;
    public $surname;
    public $schedule_name_id;
    public $department_id;
    public $email;
    public $phone;
    public $type;
    public $image;
    public function __construct($id, $entry_code_id, $client_id, $name, $surname, $schedule_name_id, $department_id, $email, $phone, $type, $image)
    {
        $this->id = $id;
        $this->entry_code_id = $entry_code_id;
        $this->client_id = $client_id;
        $this->name = $name;
        $this->surname = $surname;
        $this->schedule_name_id = $schedule_name_id;
        $this->department_id = $department_id;
        $this->email = $email;
        $this->phone = $phone;
        $this->type = $type;
        $this->image = $image;
    }

    public static function fromModel($person)
    {
// dd($person);
        return new self(
            $person->id,
            $person->entry_code_id,
            $person->client_id,
            $person->name,
            $person->surname,
            $person->schedule_name_id,
            $person->department_id,
            $person->email,
            $person->phone,
            $person->type,
            $person->image,
        );
    }



}
