        @extends('layouts.app')

@section('content')
<div class="container mt-4">
    
    <div class="row mb-5">
        <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Enter Product</h5>
                <h6 class="card-subtitle mb-2 text-muted">** All fields required **</h6> 
                <form id="productForm" class="needs-validation" novalidate>
                <div class="container">
                    <div class="row gy-5">
                        <div class="col-6">
                            <div class="form-floating ">                                
                                <input id="productName" name="name" type="text" class="form-control" placeholder="Product Name" aria-label="First name" required>
                                <label for="productName">Product Name</label>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-3">
                            <div class="form-floating">
                                <input id="productQuantity" name="quantity" type="number" class="form-control" placeholder="Quantity in Stock" aria-label="Quantity in Stock"  min="0" required>
                                <label for="productQuantity">Quantity in Stock</label>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-3">
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <div class="form-floating">
                                    <input id="productPrice" name="price" type="text" class="form-control" placeholder="Price per Item" aria-label="Price per Item" required>
                                    <label for="productPrice">Price per Item</label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>                            
                        </div>
                        <div class="col">
                            <div class="float-end">                                
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>                                        
                    </div>
                </form>                 
            </div>
        </div>
        </div>
    </div>
</div>
    <div clas="row mb-5">
        <div class="col">
            <table id="productTable" class="table table-success table-striped">
            <thead>
                <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity in Stock</th>
                <th scope="col">Price per Item $</th>
                <th scope="col">Date/time submitted</th>
                <th scope="col">Total Value $</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>                
                <td>{{ $product->name }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ number_format($product->price, 2) }}</td>
                <td>{{ $product->created_at->format('Y-m-d H:i:s') }}</td>
                <td>{{ number_format($product->total_value, 2) }}</td>
                </td>
                </tr>
                @endforeach                                
                <tr>
                <td colspan="4" class="text-end">Sum of all Total Values: </td>
                <td class="fw-bold pr-2" id="totalValues"> 
                    @if (count($products))
                        <?php echo number_format($products->sum('total_value'), 2) ?>
                    @else 
                        0.00
                    @endif
                </td>
                </tr>                
            </tbody>
            </table>
        </div>
        </div>
    </div>        
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/products.ajax.js') }}"></script>
@endpush
