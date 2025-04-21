@extends('layouts.app')

@section("page-script")
    <script src="{{ asset('assets/js/change-status.js') }}"></script>
    <script src="{{ asset('assets/js/delete-item.js') }}"></script>
@endsection

@section('content')


{{-- commentel em heto karox e petq gal  --}}
   {{-- @include("navbar") --}}




   <main id="main" class="main">



    <section class="section">
      <div class="row">

        <div class="col-lg-12">
          <div class="card">

            <div class="card-body">
                <div class = "d-flex justify-content-between">
                    <h5 class="card-title">

                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Վերահսկվող անձնակազմի ցանկ</li>

                        </ol>
                    </nav>

                    </h5>


                </div>
              <!-- Bordered Table -->


              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Հ/Հ</th>
                    <th scope="col">ID</th>
                    {{-- <th scope="col">Նույնականացման կոդ</th> --}}
                    {{-- <th scope="col">Նկար</th> --}}
                    <th scope="col">Անուն</th>
                    <th scope="col">Ազգանուն</th>
                    <th scope="col">Գործողություն</th>
                  </tr>
                </thead>
                <tbody>

                    @if( $data !=null && count($data)>0)
                        @foreach ($data as $person)


                        {{-- {{ dump($entry_code->active_person->people->name) }} --}}

                            <tr>
                                <td>{{ ++$i }}</td>
                                <th scope="row">{{ $person->id }}</th>
                                <td>
                                    {{ $person->name ?? null }}

                                </td>
                                <td>
                                    {{ $person->surname ?? null }}

                                </td>
                                {{-- <td>
                                    {{ $person->phone ?? null }}
                                </td> --}}
                                <td>

                                    <div class="dropdown action"data-id="{{ $person->id }}" data-tb-name="superviceds">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>

                                        <div class="dropdown-menu">
                                            {{-- @if(auth()->user()->hasRole('super_admin'))
                                                <a class="dropdown-item d-flex" href="javascript:void(0);">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input change_status" type="checkbox"
                                                            role="switch" data-field-name="status"
                                                            {{ $entry_code['status'] ? 'checked' : null }}>
                                                    </div>Կարգավիճակ
                                                </a>
                                            @endif
                                            @if(auth()->user()->hasRole('client_admin'))
                                                <a class="dropdown-item d-flex" href="javascript:void(0);">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input change_status" type="checkbox"
                                                            role="switch" data-field-name="activation"
                                                            {{ $entry_code['activation'] ? 'checked' : null }}>
                                                    </div>Ակտիվացում
                                                </a>
                                            @endif --}}

                                            @if ($person !=null )
                                                <a class="dropdown-item" href="{{route('calendar',$person->id )}}"><i
                                                    class="bx bx-edit-alt me-1"></i>Ժամանակացույց</a>

                                            @endif


                                            {{-- <a class="dropdown-item" href="{{route('people.edit',$person->id)}}"><i
                                                    class="bx bx-edit-alt me-1"></i>Խմբագրել</a>--}}
                                            {{-- <button type="button" class="dropdown-item click_delete_item"
                                                data-bs-toggle="modal" data-bs-target="#smallModal"><i
                                                    class="bx bx-trash me-1"></i>
                                                Ջնջել</button> --}}
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                    @endif


                </tbody>
              </table>

              <!-- End Bordered Table -->

              @if( $data !=null && count($data)>0)
                <div class="demo-inline-spacing">
                    {{-- {{ $data->links() }} --}}
                </div>
                @endif
            </div>


          </div>





        </div>

      </div>

    </section>

  </main><!-- End #main -->
<script>
    $('.supervised').on('change', function() {

        // alert(7777)
        let isChecked = $(this).prop("checked") ? 1 : 0;
        if(isChecked){
            let people_id=$(this).val()
            let client_id = $(this).attr('data-client')
            $.ajax({
            type: "POST",
            url: '/supervised',
            data: {
                people_id: people_id,
                client_id: client_id
            },
            cache: false,
            success: function (data) {
                if (data.success) {

                }
                else {
                message = data.message

                }
            }
            });

        }
    })


</script>

@endsection
<x-modal-delete></x-modal-delete>

