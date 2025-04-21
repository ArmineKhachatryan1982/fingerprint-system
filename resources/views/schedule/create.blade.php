@extends('layouts.app')

@section('content')

   <main id="main" class="main">

    <section class="section">

      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
                @if (session('repeating_token'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('repeating_token') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
              <h5 class="card-title">
                <nav>
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{ route('schedule.list') }}">Հերթափոխերի ցանկ</a></li>

                      <li class="breadcrumb-item active">Ստեղծել</li>
                    </ol>
                  </nav>
              </h5>

              <!-- General Form Elements -->
              <form action="{{ route('schedule.store')}}" method="post" enctype="multipart/form-data">
                {{-- @if (Auth::user()->hasRole("client_admin"))
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Գործատուների ցանկ </label>
                        <div class="col-sm-9">
                        <select class="form-select" aria-label="Default select example" name ="client_id">
                            <option value='' disabled >Ընտրել գործատուին </option>
                            @foreach ($clients as  $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach

                        </select>
                        @error("client_id")
                            <div class="mb-3 row">
                                <p class="col-sm-10 text-danger fs-6">{{ $message }}
                                </p>
                            </div>
                        @enderror
                        </div>

                    </div>
                    @endif --}}
                    @if (Auth::user()->hasRole(["client_admin",'manager']))

                        <div class="row mb-3">
                            <label for="inputEmail" class="col-sm-3 col-form-label">Հերթափոխի անուն </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" value={{ old('name') }}>
                                @error("name")
                                    <div class="mb-3 row ">
                                        <p class="col-sm-10 text-danger fs-6">{{ $message }}
                                        </p>
                                    </div>
                                @enderror


                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <label for="inputEmail" class="col-sm-3 col-form-label">Շաբաթվա օր </label>
                            <div class="col-sm-9">
                                <select name="week_day"  class="form-select">
                                    @foreach ($weekdays as $key=>$day )
                                    <option  value = {{ $day }}>
                                        {{ $day }}
                                    </option>

                                    @endforeach
                                </select>

                                @error("week_day")
                                    <div class="mb-3 row ">
                                        <p class="col-sm-10 text-danger fs-6">{{ $message }}
                                        </p>
                                    </div>
                                @enderror


                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail" class="col-sm-3 col-form-label">Աշխատանքային օրվա սկիզբ </label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" name="day_start_time" value={{ old('day_start_time') }}>
                                @error("day_start_time")
                                    <div class="mb-3 row ">
                                        <p class="col-sm-10 text-danger fs-6">{{ $message }}
                                        </p>
                                    </div>
                                @enderror


                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail" class="col-sm-3 col-form-label">Աշխատանքային օրվա ավարտ </label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" name="day_end_time" value={{ old('day_end_time') }}>
                                @error("day_end_time")
                                    <div class="mb-3 row ">
                                        <p class="col-sm-10 text-danger fs-6">{{ $message }}
                                        </p>
                                    </div>
                                @enderror


                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail" class="col-sm-3 col-form-label">Ընդմիջման սկիզբ </label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" name="break_start_time" value={{ old('day_end_time') }}>
                                @error("break_start_time")
                                    <div class="mb-3 row ">
                                        <p class="col-sm-10 text-danger fs-6">{{ $message }}
                                        </p>
                                    </div>
                                @enderror


                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail" class="col-sm-3 col-form-label">Ընդմիջման ավարտ</label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" name="break_end_time" value={{ old('break_end_time') }}>
                                @error("break_end_time")
                                    <div class="mb-3 row ">
                                        <p class="col-sm-10 text-danger fs-6">{{ $message }}
                                        </p>
                                    </div>
                                @enderror
                            </div>
                        </div> --}}

                        @if(auth()->user()->hasRole('client_admin'))
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Ակտիվացում </label>
                            <div class="col-sm-9">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                        name="status">
                                </div>
                            </div>
                        </div>




                    @endif
                    <div class="row mt-3">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary">Ստեղծել</button>
                        </div>
                    </div>


                    @endif




              </form>

            </div>
          </div>

        </div>
    </section>

  </main><!-- End #main -->


@endsection
