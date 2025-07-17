@extends('app', ['title' => 'Products | Listing'])

@section('content')
    
    <div class="container mt-5">
        <div id="productMessage"></div>
        <div class="d-flex justify-content-between mb-4">
            <h2>Product List</h2>
            <div>
                <button class="btn btn-success me-2" id="addProductBtn">+ Add Product</button>
                <button class="btn btn-danger" id="logoutBtn">Logout</button>
            </div>
        </div>
        <table class="table table-bordered" id="productTable">
            <thead class="table-stripped">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price (₹)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>

        $(document).ready(() => {
            const token = localStorage.getItem("token");
            if (token) {
                $.ajax({
                    url: "/api/check-auth",
                    method: "GET",
                    headers: {
                        Authorization: "Bearer " + token,
                    },
                    success: function () {
                        loadProducts();

                        // Handle logout
                        $('#logoutBtn').click(function () {
                            localStorage.removeItem('token');
                            window.location.href = '/login';
                        });

                        $('#addProductBtn').click(function () {
                            window.location.href = '/products/create';
                        });
                    },
                    error: function (xhr) {
                        if (xhr.status === 401) {
                            localStorage.removeItem("token");
                            window.location.href = "/login";
                        }
                    },
                });
            } else {
                window.location.href = "/login";
            }

            function loadProducts() {
                $.ajax({
                    url: '/api/get-products',
                    method: 'GET',
                    headers: { 'Authorization': 'Bearer ' + token },
                    success: function (response) {
                        const tbody = $('#productTable tbody');
                        tbody.empty();

                        if (response.products && response.products.length > 0) {
                            response.products.forEach((product, index) => {
                                tbody.append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${product.name}</td>
                                        <td>${product.category}</td>
                                        <td>${product.price}</td>
                                        <td><a class="btn btn-sm btn-secondary" href="/products/create?id=${product.id}">Edit</a></td>
                                    </tr>
                                `);
                            });
                        } else {
                            tbody.html(`<tr><td colspan="4" class="text-center">No products found</td></tr>`);
                        }
                    },
                    error: function () {
                        $('#productMessage').html(`<div class="alert alert-danger">Failed to load products.</div>`);
                    }
                });
            }
        }); 
    </script>
@endsection