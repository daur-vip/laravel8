<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Brands
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">


                <div class="col-md-8">
                    <div class="card">


                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <span type="button" class="close" data-bs-dismiss="alert"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></span>
                                <strong>{{ session('success') }}</strong>
                            </div>
                        @endif

                        <div class="card-header">
                            All Brands
                        </div>



                        <table class="table">

                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Brand Name</th>
                                    <th scope="col">Brand Image</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($brands as $brand)
                                    <tr>
                                        <th scope="row">{{ $brands->firstItem() + $loop->index }}</th>
                                        <td>{{ $brand->brand_name }}</td>
                                        <td><img src="{{ asset($brand->brand_image) }}" alt="" style="height:40px;">
                                        </td>
                                        <td>
                                            @if ($brand->created_at != null)
                                                {{ Carbon\Carbon::parse($brand->created_at)->diffForHumans() }}
                                            @else
                                                <span class="text-danger">No date set</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('brand/edit/' . $brand->id) }}"
                                                class="btn btn-info">Edit</a>
                                            <a href="{{ url('brand/delete/' . $brand->id) }}"
                                                class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                        {{ $brands->links() }}


                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Add Brand
                        </div>
                        <div class="card-body">
                            <form action="{{ route('store.brand') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Brand Name</label>
                                    <input type="text" name="brand_name" class="form-control">

                                    @error('brand_name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <label>Brand Image</label>
                                    <input type="file" name="brand_image" class="form-control">

                                    @error('brand_image')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                                <button type="submit" class="btn btn-primary">Add brand</button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>

</x-app-layout>
