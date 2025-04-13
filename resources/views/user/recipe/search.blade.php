<form action="{{ route('healthy-recipe.search') }}" method="get" class="d-flex align-items-center justify-content-end gap-2 p-2">
    {{-- @csrf --}}
    @error('search')
        <p class="text-danger">{{ $message }}</p>
    @enderror
    <div class="col" style="max-width: 600px;">
        <input type="text" name="search" class="form-control @error('search') is-invalid @enderror" id="search"
            placeholder="Search for a recipe...">
    </div>
    <button class="btn btn-primary col" style="max-width: 150px;" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
</form>