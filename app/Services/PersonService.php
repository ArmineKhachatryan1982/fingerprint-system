<?php

namespace App\Services;


use App\DTO\PersonDTO;
use App\Models\Client;
use App\Models\EntryCode;
use App\Repositories\Interfaces\PersonRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PersonService
{
    protected $personRepository;

    public function __construct(PersonRepositoryInterface $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function getPeopleList()
    {
        $people = $this->personRepository->getAllPeople();

        return $people;
    }
    public function create()
    {

        $data = $this->personRepository->createPerson();

        return $data;

    }

    public function store( $personDTO)
    {
        return $this->personRepository->storePerson($personDTO->toArray());
    }
    public function edit($personId)
    {

        $data = $this->personRepository->editPerson($personId);
     

        return [
            "non_active_entry_code"=>$this->getAllNonActivatedEntryCode(),
            "person_connected_schedule_department"=>$data
        ];

    }
    public function update(PersonDTO $personDTO, array $data)
    {
        return $this->personRepository->updatePerson($personDTO, $data);
    }

    public function getAllNonActivatedEntryCode()
    {
        $client = Client::where('user_id',Auth::id())->first();

        $entry_code = EntryCode::where(['client_id'=>$client->id,'activation'=>0,'status'=>1])->get();

        if(count($entry_code)>0)
        {
            return $entry_code;
        }else{
            return false;

        }

    }



}
