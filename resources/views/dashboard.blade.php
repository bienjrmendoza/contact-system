<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="button-container flex items-center justify-end mt-4">
                    <input type="text" id="search" class="form-control-sm mr-1" placeholder="Search contacts..." /><button id="search-btn" class="btn btn-primary btn mr-3">Search</button>
                    <button type="button" class="btn btn-primary justify-end" data-toggle="modal" data-target="#addContactModal">
                        Add Contact
                    </button>
                </div>

                <table class="table mt-2" id='contact-table'>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    @if (!empty($contacts))
                        <tbody>
                            @foreach ($contacts AS $contact_index => $contact)
                                <tr>
                                    <td>{{ $contact_index + 1 }}</td>
                                    <td>{{ $contact['name'] }}</td>
                                    <td>{{ $contact['company'] }}</td>
                                    <td>{{ $contact['phone'] }}</td>
                                    <td>{{ $contact['email'] }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editContactModal{{ $contact['id'] }}">
                                            EDIT
                                        </button>
                                        <div class="modal fade" id="editContactModal{{ $contact['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editContactModalLabel{{ $contact['id'] }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editContactModalLabel{{ $contact['id'] }}">Edit Contact</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="{{ route('contact.update', $contact['id']) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="name">Name</label>
                                                                <input type="text" class="form-control" id="name" name="name" value="{{ $contact['name'] }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="company">Company</label>
                                                                <input type="text" class="form-control" id="company" name="company" value="{{ $contact['company'] }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="phone">Phone</label>
                                                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $contact['phone'] }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input type="email" class="form-control" id="email" name="email" value="{{ $contact['email'] }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update Contact</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        |
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteContactModal{{ $contact['id'] }}">
                                            DELETE
                                        </button> 
                                        <div class="modal fade" id="deleteContactModal{{ $contact['id'] }}" tabindex="-1" role="dialog" aria-labelledby="deleteContactModalLabel{{ $contact['id'] }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteContactModalLabel{{ $contact['id'] }}">Confirm Deletion</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this contact?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('contact.destroy', $contact['id']) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
                <div class="d-flex justify-content-between">
                    <div>
                        Showing {{ $contacts->firstItem() }} to {{ $contacts->lastItem() }} of {{ $contacts->total() }} contacts
                    </div>
                    <div>
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        

        <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addContactModalLabel">Add New Contact</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addContactForm" method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="company">Company</label>
                                <input type="text" class="form-control" id="company" name="company" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Contact</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
