<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Books - SecangkirKoding.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body style="background: lightgray">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-md btn-primary mb-3" data-toggle="modal"
                            data-target="#exampleModal">
                            New Book
                        </button>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">BOOK NAME</th>
                                    <th scope="col">AUTHOR</th>
                                    <th scope="col">PUBLISH</th>
                                    <th scope="col">OPTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($books as $book)
                                    <tr>
                                        {{-- <td class="text-center">
                                            <img src="{{ Storage::url('public/books/') . $book->image }}"
                                                class="rounded" style="width: 150px">
                                        </td> --}}
                                        <td>{{ $book->id }}</td>
                                        <td>{{ $book->books_name }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>{{ $book->publish }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                action="{{ route('book.destroy', $book->id) }}" method="POST">
                                                <a href="{{ route('book.edit', $book->id) }}"
                                                    class="btn btn-sm btn-warning">EDIT</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        Data Buku belum Tersedia.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        <div>
                            {{ $books->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form input buku -->
                    <form action="{{ route('book.store') }}" method="POST">
                        @csrf
                        <!-- Tambahkan field-input buku sesuai kebutuhan Anda -->
                        <div class="form-group">
                            <label for="books_name">Book Name</label>
                            <input type="text" class="form-control" id="books_name" name="books_name" required>
                        </div>
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" id="author" name="author" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="publish">Publish</label>
                            <input type="text" class="form-control" id="publish" name="publish" required>
                        </div> --}}
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        //message with toastr
        @if (session()->has('success'))

            toastr.success('{{ session('success') }}', 'BERHASIL!');
        @elseif (session()->has('error'))

            toastr.error('{{ session('error') }}', 'GAGAL!');
        @endif
    </script>

</body>

</html>
