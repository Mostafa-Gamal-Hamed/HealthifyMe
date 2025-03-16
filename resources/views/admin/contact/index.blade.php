@extends('admin.layout')

@section('title')
    Messages
@endsection

@section('body')
    <div class="p-3">
        <div class="shadow shadow-lg bg-light rounded h-100 p-4">
            @if ($messages->isEmpty())
                <h3 class="mb-5 text-center text-danger">No messages found.</h3>
            @else
                <div class="row justify-content-between align-items-center mb-4">
                    <h6 class="col">Messages</h6>
                    <form class="col" role="search">
                        <input class="form-control me-2" type="text" id="search" placeholder="Search by email"
                            aria-label="Search">
                    </form>
                </div>
                <div class="table-responsive">
                    {{ $messages->appends(request()->input())->links() }}
                    <table class="table text-center" id="showTable">
                        <thead>
                            <tr>
                                <th>ID.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Received</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                @if ($message->status === 'unread')
                                    <tr class="table-warning">
                                        <td scope="row">{{ $message->id }}</td>
                                        <td>{{ $message->name }}</td>
                                        <td>{{ $message->email }}</td>
                                        <td>{{ $message->subject }}</td>
                                        <td>
                                            <span data-featherlight="<p>{{ $message->message }}</p>"
                                                style="cursor: pointer;">
                                                {{ Str::limit($message->message, 30, '...') }}
                                            </span>
                                        </td>
                                        <td><span class="badge bg-warning text-dark">{{ $message->status }}</span></td>
                                        <td>{{ $message->created_at->format('d-m-Y') }}</td>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.contact.show', $message->id) }}"
                                                class="btn btn-md btn-info">
                                                <i class="fa-solid fa-info"></i></i>
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.contact.delete', $message->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-md"
                                                    onclick="return confirm('Are you sure?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td scope="row">{{ $message->id }}</td>
                                        <td>{{ $message->name }}</td>
                                        <td>{{ $message->email }}</td>
                                        <td>{{ $message->subject }}</td>
                                        <td>
                                            <span data-featherlight="<p>{{ $message->message }}</p>"
                                                style="cursor: pointer;">
                                                {{ Str::limit($message->message, 30, '...') }}
                                            </span>
                                        </td>
                                        <td><span class="badge bg-secondary">{{ $message->status }}</span></td>
                                        <td>{{ $message->created_at->format('d-m-Y') }}</td>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.user.show', $message->id) }}"
                                                class="btn btn-md btn-success">
                                                <i class="fa-solid fa-info"></i></i>
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.user.delete', $message->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-md"
                                                    onclick="return confirm('Are you sure?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif

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
            $("#search").on("input", function() {
                var value = $(this).val().toLowerCase();
                $('#showTable').find('thead').hide();
                $('#showTable').find('tbody').hide();

                if (value === '') {
                    $('#showTable').find('thead').show();
                    $('#showTable').find('tbody').show();
                    return;
                }

                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.sentMessage.search', '') }}/" + value,
                    success: function(response) {
                        if (response.emails && response.emails.length > 0) {
                            var body  = $('#showTable').find('tbody');
                            body.empty();

                            response.emails.forEach(function(email) {
                                var created_at = new Date(email.created_at);
                                var createdAt = created_at.toLocaleDateString('en-GB');

                                var message = `
                                    <span data-featherlight="<p>${email.message}</p>" style="cursor: pointer;">
                                        ${email.message.length > 50 ? email.message.substring(0, 50) + '....' : email.message}
                                    </span>
                                `;

                                var sender = `${email.user.firstName} ${email.user.lastName}`;

                                var show   = `{{ url('admin.sentMessage.show', '') }}/${email.id}`;
                                var remove = `{{ url('admin.sentMessage.delete', '') }}/${email.id}`;

                                body.append(`
                                    <tr>
                                        <td>${email.id}</td>
                                        <td>${email.email}</td>
                                        <td>${message}</td>
                                        <td>${sender}</td>
                                        <td>${email.contact_id}</td>
                                        <td>${createdAt}</td>
                                        <td>
                                            <a href="${show}" class="btn btn-md btn-success">
                                                <i class="fa-solid fa-info"></i></i>
                                            </a>
                                        </td>
                                        <td>
                                            <form action="${remove}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-md"
                                                    onclick="return confirm('Are you sure?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                `);
                            });

                        } else {
                            $('#showTable tbody').html(
                                `<tr><td colspan="8" class='text-danger fw-bold'>No results found.</td></tr>`
                            );
                        }

                        $('#showTable').find('thead').show();
                        $('#showTable').find('tbody').show();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endsection
