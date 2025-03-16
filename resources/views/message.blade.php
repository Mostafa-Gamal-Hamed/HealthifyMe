{{-- Success message --}}
@if (session()->get('success'))
<script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
        });
    </script>
@endif

{{-- Error message --}}
@if ($errors->any())
    <script>
        let errorMessages = @json($errors->all());
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: errorMessages.map(error => `<p>${error}</p>`).join(''),
        });
    </script>
@endif
