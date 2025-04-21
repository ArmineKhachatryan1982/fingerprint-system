@extends('layouts.app')
@section('page-script')
    <script src = "{{ asset('assets/js/user-role.js') }}"></script>
@endsection

@section('content')
<main id="main" class="main">

    <section class="section">
        <form
            method = "POST"
            action = "{{ route('users.update', $user->id) }}">
            @method('PUT')
                <div class="row">
                            <div class="col-lg-6">

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <nav>
                                                <ol class="breadcrumb">
                                                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Օգտատերերի ցանկ</a></li>

                                                    <li class="breadcrumb-item active">Խմբագրել</li>
                                                </ol>
                                            </nav>
                                        </h5>



                                            <div class="row mb-3">

                                                <label for="inputText" class="col-sm-3 col-form-label">Անուն</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="Աշխատակցի անունը"
                                                        value="{{ $user->name }}">
                                                    @error('name')
                                                        <div class="mb-3 row justify-content-start">
                                                            <div class="col-sm-9 text-danger fts-14">{{ $message }}
                                                            </div>
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="row mb-3">
                                                <label for="inputEmail" class="col-sm-3 col-form-label">Էլ.հասցե</label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control" name="email"
                                                        placeholder="example@gmail.com"
                                                        value="{{ $user->email }}">
                                                    @error('email')
                                                        <div class="mb-3 row justify-content-start">
                                                            <div class="col-sm-9 text-danger fts-14">{{ $message }}
                                                            </div>
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>

                                            <div class="row mb-3">
                                                <label for="inputEmail"  class="col-sm-3 col-form-label">Գաղտնաբառ</label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="password" class="form-control" placeholder="Password" value="">
                                                    @error('password')
                                                    <div class="mb-3 row justify-content-start">
                                                        <div class="col-sm-9 text-danger fts-14">{{ $message }}
                                                        </div>
                                                    </div>
                                                @enderror

                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="inputEmail" class="col-sm-3 col-form-label">Հաստատել գաղտնաբառը</label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="confirm-password" class="form-control" placeholder="Confirm Password" value="">
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="inputEmail" class="col-sm-3 col-form-label">Դերեր</label>
                                                <div class="col-sm-9">


                                                    <select name = "roles[]" class="form-control" id="selectedRole" multiple="multiple">
                                                        @foreach ($roles as $value => $label)

                                                            <option
                                                                @if($isEditMode) disabled @endif
                                                                value="{{ $value }}" {{ isset($userRole[$value]) ? 'selected' : ''}}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('roles')
                                                    <div class="mb-3 row justify-content-start">
                                                        <div class="col-sm-9 text-danger fts-14">{{ $message }}
                                                        </div>
                                                    </div>
                                                @enderror
                                                </div>

                                            </div>

                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6" id="componentContainer">


                                    @if (in_array('client_admin', $userRole) || in_array('client_admin_rfID', $userRole))

                                        <x-client-edit :user="$user"/>
                                    @endif

                            </div>
                        <div class="row mb-3 {{ in_array('client_admin', $userRole) || in_array('client_admin_rfID', $userRole) ? 'd-none' : null  }}" id="loginBtn">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Պահպանել</button>
                            </div>
                        </div>




                </div>
                </form>

    </section>


</main>
@endsection
