@extends('admin.admin_master')

@section('admin')


    <div class="py-12">
        <div class="container">
            <div class="row">


                <div class="col-md-8">
                    <div class="card">


                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <span type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></span>
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
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($sliders as $slider)
                                    <tr>
                                        <th scope="row">{{ $brands->firstItem() + $loop->index }}</th>
                                        <td>{{ $slider->title }}</td>
                                        <td>{{ $slider->description }}</td>
                                        <td><img src="{{ asset($slider->image) }}" alt="" style="height:40px;">
                                        </td>
                                        <td>
                                            <a href="{{ url('slider/edit/' . $slider->id) }}"
                                                class="btn btn-info">Edit</a>
                                            <a href="{{ url('slider/delete/' . $slider->id) }}" class="btn btn-danger"
                                                onclick="return confirm('Are you sure?')">Delete</a>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

        

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

@endsection
