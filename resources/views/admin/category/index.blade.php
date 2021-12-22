<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Categories
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
                            All Categories
                        </div>



                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($categories as $category)
                                    <tr>
                                        <th scope="row">{{ $categories->firstItem() + $loop->index }}</th>
                                        <td>{{ $category->category_name }}</td>
                                        <td>{{ $category->user->name }}</td>
                                        <td>
                                            @if ($category->created_at != null)
                                                {{ Carbon\Carbon::parse($category->created_at)->diffForHumans() }}
                                            @else
                                                <span class="text-danger">No date set</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('category/edit/' . $category->id) }}"
                                                class="btn btn-info">Edit</a>
                                            <a href="{{ url('category/soft-delete/' . $category->id) }}"
                                                class="btn btn-danger">Delete</a>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                        {{ $categories->links() }}


                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Add Category
                        </div>
                        <div class="card-body">
                            <form action="{{ route('store.category') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Category Name</label>
                                    <input type="text" name="category_name" class="form-control">

                                    @error('category_name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                                <button type="submit" class="btn btn-primary">Add category</button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>




        <div class="container">
            <div class="row">


                <div class="col-md-8">
                    <div class="card">


                        <div class="card-header">
                            Trash List
                        </div>



                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($trashCategories as $category)
                                    <tr>
                                        <th scope="row">{{ $categories->firstItem() + $loop->index }}</th>
                                        <td>{{ $category->category_name }}</td>
                                        <td>{{ $category->user->name }}</td>
                                        <td>
                                            @if ($category->created_at != null)
                                                {{ Carbon\Carbon::parse($category->created_at)->diffForHumans() }}
                                            @else
                                                <span class="text-danger">No date set</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('category/restore/' . $category->id) }}"
                                                class="btn btn-info">Restore</a>
                                            <a href="{{ url('category/delete/' . $category->id) }}"
                                                class="btn btn-danger">
                                                Delete
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                        {{ $trashCategories->links() }}


                    </div>
                </div>

                <div class="col-md-4">

                </div>


            </div>
        </div>
    </div>
</x-app-layout>
