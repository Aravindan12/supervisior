@extends('products.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4>Telescope</h4>
            </div>
            <div class="pull-right">
            <input type="hidden" name="user_id" value="{{$user_id}}">
              <a class="btn btn-primary" href="{{ ('/home') }}"> Back</a>
                <a class="btn m-4 btn-success " href="{{ route('products.create') }}"> Create New Product</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Slug Name</th>
            <th name="unique_id" value="1">Unique Id</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->slug_name }}</td>
            <td>{{ $product->unique_id }}</td>
            <td>
                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('products.show',$product->id,$user_id) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('products.edit',$product->id,$user_id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $products->links() !!}
      
@endsection