@extends('user.layout')

@section('meta')
<meta name="keywords" content="{{ $category->name }}, healthy food types, nutrition guide, food groups, fruits, vegetables, drinks, meat, fish, fats, oil, proteins, balanced diet">
<meta name="description" content="{{ $category->name }}, Browse different food categories including fruits, vegetables, proteins, grains, and more. Discover their nutritional value and health benefits.">
@endsection

@section('title')
    {{ $category->name }} | HealthifyMe
@endsection

@section('body')
    <div class="titlepage mt-5">
        <h2>{{ $category->name }}</h2>
    </div>

    <div class="container mb-5">
        @if ($foods->isEmpty())
            <h2 class="text-center text-danger fw-bold">Empty</h2>
        @else
            <h4 class="text-center fw-bold">Click on one <i class="fa-solid fa-arrow-down"></i></h4>
            <div class="row justify-content-center align-items-center mb-3 gap-2">
                @foreach ($foods as $food)
                    @php
                        $rand = $color[array_rand($color)];
                    @endphp

                    <button class="col btn btn-sm btn-{{ $rand }} showFood" data-id="{{ $food->id }}">{{ $food->name }}</button>
                @endforeach
            </div>
            <div style="max-height: 700px;min-height: 500px;width: 100%;">
                {{-- Logo --}}
                <div id="logoBeforeFood" class="text-center"><img src="{{ asset('images/logo.png') }}" class="img-fluid" width="50%" alt="Logo"></div>

                {{-- Food --}}
                <div class="row shadow bg-light shadow-lg justify-content-center p-3 gap-2" id="details"
                    style="display: none;">
                    <p class="col-xl-12 text-center text-success fw-bold">Items per 100g</p>
                    <div class="col-xl-5">
                        <div class="about-box_img">
                            <figure>
                                <img src="" class="img-fluid rounded" id="foodImage" alt="Food">
                            </figure>
                        </div>
                    </div>
                    <div class="col-xl-5 position-relative">
                        <div class="about-box">
                            <h1 class="fw-bold" id="foodName">About us</h1>
                            <div class="table-responsive rounded overflow-auto">
                                <table class="table shadow table-light text-center rounded">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Calories</th>
                                            <th scope="col">Protein</th>
                                            <th scope="col">Carbs</th>
                                            <th scope="col">Fats</th>
                                            <th scope="col">Vitamins</th>
                                            <th scope="col">Fiber</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="fw-bold">
                                            <td id="Calories"></td>
                                            <td id="Protein"></td>
                                            <td id="Carbs"></td>
                                            <td id="Fats"></td>
                                            <td id="Vitamins"></td>
                                            <td id="Fiber"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.showFood').on('click', function() {
                let id = $(this).data('id');

                $.ajax({
                    type: 'GET',
                    url: `{{ route('food.show', '') }}/` + id,
                    success: function(data) {
                        $('#logoBeforeFood').fadeOut();
                        $('#details').hide(50);
                        $('#details').show(250);

                        $('#foodName').text(data.name);
                        $('#foodImage').attr('src', `{{ asset('storage') }}/${data.image}`);
                        $('#Calories').text(data.calories);
                        $('#Protein').text(data.protein);
                        $('#Carbs').text(data.carbs);
                        $('#Fats').text(data.fats);
                        $('#Vitamins').text(data.vitamins);
                        $('#Fiber').text(data.fiber);
                    },
                    error: function(xhr, status, error) {
                        alert("Failed to load food details. Please try again.");
                    }
                });
            });
        });
    </script>
@endsection
