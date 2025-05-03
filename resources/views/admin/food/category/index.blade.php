@extends('admin.layout')

@section('title')
    Categories
@endsection

@section('body')
    <div class="p-3">
        {{-- Add new category --}}
        <div class="mb-3">
            <div class="d-flex justify-content-end gap-3">
                <div style="display: none;" id="categoryForm">
                    <form action="{{ route('admin.category.store') }}" method="post" class="d-flex gab-2 justify-content-end" enctype="multipart/form-data">
                        @csrf
                        <div class="mx-2">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                id="name" aria-describedby="helpId" placeholder="Name">
                        </div>
                        <div class="mx-2">
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                id="image">
                        </div>

                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
                <a href="#" class="nav-link" id="addCategory"><i class="fa-solid fa-plus fw-bold text-warning"></i>
                    Add
                    new category
                </a>
            </div>
            @error('name')
                <p class="text-end text-danger">{{ $message }}</p>
            @enderror
            @error('image')
                <p class="text-end text-danger">{{ $message }}</p>
            @enderror
        </div>

        {{-- Message --}}
        @include('admin.success')

        <div class="shadow shadow-lg bg-light rounded h-100 p-4">
            @if ($categories->isEmpty())
                <h3 class="mb-5 text-center text-danger">No category found.</h3>
            @else
                <div class="table-responsive">
                    {{ $categories->appends(request()->input())->links() }}
                    <table class="table text-center" id="showTable">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Created at</th>
                                <th scope="col" colspan="3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <img src="{{ $category->image ? asset("storage/$category->image") : asset('images/foods/1-vegetable.jpg') }}"
                                            class="rounded-circle" style="width:60px; cursor: pointer;" alt="{{ $category->image }}"
                                            data-featherlight="<img src='{{ $category->image ? asset("storage/$category->image") : asset('images/foods/1-vegetable.jpg') }}' style='max-width:400px;'>">
                                    </td>
                                    <td>{{ $category->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.category.show', $category->id) }}"
                                            class="btn btn-md btn-info" title="Show">
                                            <i class="fa-solid fa-info"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.category.edit', $category->id) }}"
                                            class="btn btn-md btn-success" title="Edit">
                                            <i class="fa-solid fa-edit"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.category.delete', $category->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-md"
                                                onclick="return confirm('Are you sure?');" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Add category
            $('#addCategory').on('click', function() {
                $('#categoryForm').toggle('show');
            });
        });
    </script>
@endsection
