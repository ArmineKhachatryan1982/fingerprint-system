<?php

namespace App\Repositories\Interfaces;

use App\DTO\PersonDTO;

interface PersonRepositoryInterface
{
    public function getAllPeople();

    public function createPerson();

    public function storePerson(PersonDTO $personDTO);

    public function editPerson($personId);

    public function updatePerson(PersonDTO $personDTO, array $data);
}
