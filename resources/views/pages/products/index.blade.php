@extends('layouts.app')

@section('title', 'Product')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@12">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Product</h1>
                <div class="section-header-button">
                    <a href="{{ route('products.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Product</a></div>
                    <div class="breadcrumb-item">All Product</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Posts</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('products.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>

                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Statuss</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($products as $product)
                                            <tr>

                                                <td>{{ $product->name }}
                                                </td>
                                                <td>
                                                    {{ $product->category->name }}
                                                </td>
                                                <td>
                                                    {{ $product->price }}
                                                </td>
                                                <td>
                                                    {{ $product->status == 1 ? 'Active' : 'Inactive' }}
                                                </td>
                                                <td>{{ $product->created_at }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-left">
                                                        <a href='{{ route('products.edit', $product->id) }}'
                                                            class="btn btn-sm btn-info btn-icon mr-2">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('products.destroy', $product->id) }}" method="post" id="delete-form">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $products->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <script>
        function confirmDelete() {
            var isConfirmed = confirm("Apakah Anda yakin ingin menghapus item ini?");

            if (isConfirmed) {
                document.getElementById('delete-form').submit();
            } else {
                // Opsi "cancel"
                alert("Penghapusan dibatalkan.");
            }
        }
    </script>
@endpush





