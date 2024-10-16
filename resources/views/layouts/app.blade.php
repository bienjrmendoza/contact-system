<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Contact System</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <!-- Scripts -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            @if (isset($slot))
                <main>
                    {{ $slot }}
                </main>
            @endif

            @section('content')
            @show
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#search-btn').on('click', function() {
                    var query = $(this).val();
                    var query = $('#search').val();

                    $.ajax({
                        url: "{{ route('contact.search') }}",
                        method: "GET",
                        data: { query: query },
                        success: function(data) {
                            $('#contacts-table tbody').empty();

                            $.each(data, function(index, contact) {
                                $('#contacts-table tbody').append(
                                    `<tr>
                                        <td>${contact.name}</td>
                                        <td>${contact.company}</td>
                                        <td>${contact.phone}</td>
                                        <td>${contact.email}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" data-id="${contact.id}">Edit</button>
                                            <button class="btn btn-danger btn-sm delete-btn" data-id="${contact.id}">Delete</button>
                                        </td>
                                    </tr>`
                                );
                            });
                        }
                    });
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
