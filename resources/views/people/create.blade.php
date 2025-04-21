@extends('layouts.app')

@section('content')
@php
$client_id = $entry_codes['client_id'];
$schedule_name = isset($entry_codes['client_schedule']) ? $entry_codes['client_schedule'] : null;
$departments = isset($entry_codes['department']) ? $entry_codes['department'] :null;
unset($entry_codes['client_schedule']);
unset($entry_codes['department']);
unset($entry_codes['client_id']);


@endphp


    <main id="main" class="main">



        <section class="section">

            <div class="row">
                <div class="col-lg-8">

                    <div class="card">
                        @if (count($entry_codes) == 0)
                            <div class="d-flex justify-content-center   vh-100 fw-bold">
                                <h2 class="mt-5">Նույնականացման կոդերը բացակայում են</h2>
                            </div>
                        @else
                            <div class="card-body">

                                <h5 class="card-title">
                                    <nav>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('people.index') }}">Աշխատակիցների
                                                    ցանկ</a></li>

                                            <li class="breadcrumb-item active">Ստեղծել</li>
                                        </ol>
                                    </nav>
                                </h5>

                                <!-- General Form Elements -->
                                {{-- {{ dd($data->active_person->people) }} --}}
                                <form action="{{ route('people.store') }}" method="post" enctype="multipart/form-data">
                                    <input type="hidden" value={{$client_id}} name="client_id">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Նույնականացման կոդ</label>
                                        <div class="col-sm-9">

                                            {{-- {{ dd($entry_codes) }} --}}

                                            <select class="form-select" aria-label="Default select example"
                                                name ="entry_code_id">
                                                <option value='' disabled>Ընտրել նույնականացման կոդը</option>
                                                @foreach ($entry_codes as $code)
                                                    <option value="{{ $code->id }}">{{ $code->token }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                                <div class="mb-3 row justify-content-end">
                                                    <div class="col-sm-10 text-danger fts-14">{{ $message }}
                                                    </div>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="row mb-3">

                                        <label for="inputText" class="col-sm-3 col-form-label">Անուն </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Աշխատակցի անունը" value="{{ old('name') }}">
                                            @error('name')
                                                <div class="mb-3 row ">
                                                    <p class="col-sm-10 text-danger fs-6">{{ $message }}
                                                    </p>
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row mb-3">

                                        <label for="inputText1" class="col-sm-3 col-form-label">Ազգանուն </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="surname"
                                                placeholder="Աշխատակցի ազգանունը" value="{{ old('surname') }}">
                                            @error('surname')
                                                <div class="mb-3 row">
                                                    <p class="col-sm-9 mb-3 text-danger fs-6 ">{{ $message }}
                                                    </p>
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                    @if($schedule_name!=null)
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Հերթափոխեր</label>
                                            <div class="col-sm-9">
                                            <select class="form-select" aria-label="Default select example" name ="schedule_name_id">
                                                    <option value='' disabled>Ընտրել հերթափոխը</option>
                                                    @foreach ($schedule_name as $key=>$schedule)
                                                    <option value="{{ $schedule->id }}"> {{ $schedule->name }}</option>
                                                    @endforeach
                                            </select>
                                            @error("schedule_name_id")
                                                <div class="mb-3 row justify-content-end">
                                                    <div class="col-sm-10 text-danger fts-14">{{ $message }}
                                                    </div>
                                                </div>
                                            @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if ($departments!=null)
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Ստորաբաժանումներ</label>
                                            <div class="col-sm-9">
                                            <select class="form-select" aria-label="Default select example" name ="department_id">

                                                    <option value='' disabled>Ընտրել ստորաբաժանումը</option>
                                                    @foreach ($departments as $department )
                                                        <option value="{{ $department->id }}" >{{ $department->name }}</option>
                                                    @endforeach

                                            </select>
                                            @error("department_id")
                                                <div class="mb-3 row justify-content-end">
                                                    <div class="col-sm-10 text-danger fts-14">{{ $message }}
                                                    </div>
                                                </div>
                                            @enderror
                                            </div>
                                        </div>





                                    @endif



                                    <div class="row mb-3">
                                        <label for="inputEmail" class="col-sm-3 col-form-label">Էլ.հասցե</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="email"
                                                placeholder="example@gmail.com" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail" class="col-sm-3 col-form-label">Հեռախոսահամար</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="phone"
                                                placeholder="+374980000" value="{{ old('phone') }}">
                                                @error('phone')
                                                <div class="mb-3 row">
                                                    <div class="col-sm-10 text-danger fts-14">{{ $message }}
                                                    </div>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label for="inputNumber" class="col-sm-3 col-form-label">ներբեռնել նկար</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" id="formFile" name="image">
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Աշխատակցի կարգավիճակ</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" aria-label="Default select example" name ="type">
                                                <option value='' disabled>Աշխատակցի կարգավիճակը</option>

                                                <option value="worker">Աշխատող</option>
                                                <option value="visitor">Այցելու</option>


                                            </select>
                                            @error('type')
                                                <div class="mb-3 row justify-content-end">
                                                    <div class="col-sm-10 text-danger fts-14">{{ $message }}
                                                    </div>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-primary">Ստեղծել</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        @endif
                    </div>

                </div>
        </section>

    </main><!-- End #main -->
@endsection
