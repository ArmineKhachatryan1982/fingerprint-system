@extends('layouts.app')

@section('page-script')
    <script src = "{{ asset('assets/js/user-role.js') }}"></script>
@endsection
@section('content')


<main id="main" class="main">

        <section class="section">
             <form
                action="{{ route('users.store') }}"
                method="post"
                {{-- enctype="multipart/form-data" --}}
             >
                <div class="row">
                            <div class="col-lg-6">

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <nav>
                                                <ol class="breadcrumb">
                                                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Օգտատերերի ցանկ</a></li>

                                                    <li class="breadcrumb-item active">Ստեղծել Օգտատեր</li>
                                                </ol>
                                            </nav>
                                        </h5>

                                        <!-- General Form Elements -->


                                            <div class="row mb-3">

                                                <label for="inputText" class="col-sm-3 col-form-label">Անուն</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="Աշխատակցի անունը"
                                                        value="{{ old('name') }}">
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
                                                        value="{{ old('email') }}">
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
                                                    <select name = "roles" class="form-control" id="selectedRole">
                                                        <option disabled> Ընտրել դերեր</option>
                                                        @foreach ($roles as $value => $label)

                                                            {{-- <option  value = "{{ $value }}" {{ in_array($value, old('roles', [])) ? 'selected' : '' }} >
                                                                {{ $label }}
                                                            </option> --}}
                                                            <option  value = "{{ $value }}" {{  old('roles') == $value ? 'selected' : '' }} >
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
                                 @if ($errors->has('client.name'))
                                    <x-client/>
                                 @endif

                                @if ($errors->any(['name','email','password','confirm-password']))

                                    @if (old('roles') === 'client_admin' || old('roles') === 'client_admin_rfID')
                                        @if (!$errors->has('client.name'))
                                            <x-client/>
                                        @endif
                                    @endif
                                @endif

                            </div>
                        @if (old('roles') != 'client_admin' && old('roles')!= 'client_admin_rfID')
                            <div class="row mb-3 {{$errors->has('client.name') ?'d-none' : null  }}" id="loginBtn">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Ստեղծել</button>
                                </div>
                            </div>
                        @endif




                </div>
                </form>

        </section>

</main>


@endsection
