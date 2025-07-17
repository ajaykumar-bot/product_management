@extends('app', ['title' => 'Create Product'])

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="productMessage"></div>
            <div class="card">
                <div class="card-header" id="formTitle" >{{ 'Create Product' }}</div>

                <div class="card-body">
                    <form id="productForm">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="category" class="col-md-4 col-form-label text-md-end">{{ __('Category') }}</label>
                            <div class="col-md-6">
                                <input id="category" type="text" class="form-control" name="category" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('Price') }}</label>
                            <div class="col-md-6">
                                <input id="price" type="number" class="form-control" name="price" required min="0" step="0.01">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button id="submitBtn" type="submit" class="btn btn-primary">
                                    {{ 'Submit' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(() => {
        const token = localStorage.getItem("token");
        const productId = new URLSearchParams(window.location.search).get('id');

        if (!token) {
            window.location.href = "/login";
            return;
        }

        $.ajax({
            url: "/api/check-auth",
            method: "GET",
            headers: {
                Authorization: "Bearer " + token,
            },
            success: function () {
                if (productId) {
                    $('#formTitle').text('Edit Product');
                    $('#submitBtn').text('Update');

                    // Load product data
                    $.ajax({
                        url: `/api/get-products/${productId}`,
                        method: 'GET',
                        headers: { Authorization: 'Bearer ' + token },
                        success: function(response) {
                            const product = response.product || response.products;
                            $('#name').val(product.name);
                            $('#category').val(product.category);
                            $('#price').val(product.price);
                        },
                        error: function () {
                            $('#productMessage').html(`<div class="alert alert-danger">Failed to load product data.</div>`);
                        }
                    });
                }

                // Submit form
                $('#productForm').on('submit', function(e) {
                    e.preventDefault();

                    const data = {
                        name: $('#name').val(),
                        category: $('#category').val(),
                        price: $('#price').val()
                    };

                    let url = '/api/create-product';
                    let method = 'POST';

                    if (productId) {
                        url = `/api/update-product/${productId}`;
                        method = 'PUT';
                    }

                    $.ajax({
                        url: url,
                        method: method,
                        headers: {
                            Authorization: 'Bearer ' + token
                        },
                        data: data,
                        success: function(response) {
                            $('#productMessage').html(`<div class="alert alert-success">${response.message}</div>`);
                            setTimeout(() => window.location.href = '/products', 1000);
                        },
                        error: function(xhr) {
                            const message = xhr.responseJSON?.message || 'Something went wrong';
                            $('#productMessage').html(`<div class="alert alert-danger">${message}</div>`);
                        }
                    });
                });
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    localStorage.removeItem("token");
                    window.location.href = "/login";
                }
            },
        });
    });
</script>
@endsection

