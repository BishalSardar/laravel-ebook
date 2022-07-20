<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'e-book') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <style>
        h1 {
            text-align: center;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            margin-top: 1em;
        }

        .container {
            width: 70%;
            display: flex;
            align-items: baseline;
            gap: 3em;
        }

        .form {
            width: 50%;
            margin-top: 2em;
            border: 1px solid rgb(206, 212, 218);
            border-radius: 20px;
            padding: 2em;
        }

        .table-2 {
            padding-top: 5em;
        }

        .image-style {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .button {
            display: flex;
            gap: 1em;
        }

        .cat {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @endif

                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <h1>Ebook</h1>

    <div class="container pt-5">
        <form action="{{route('home.store')}}" method="POST" enctype="multipart/form-data" class="form">
            {{csrf_field()}}

            <div class="mb-3">
                <label for="Name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="Name" aria-describedby="emailHelp">
            </div>

            <label class="form-label">Category</label>
            <div class="cat mb-3">
                <div>
                    <select class="form-select" name="category_id" aria-label="Default select example">
                        @foreach($categories as $cat)
                        <option value="{{$cat->id}}">{{$cat->category}} </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add
                    </button>
                </div>

            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" class="form-control" id="file" accept=".jpg,.png,.jpeg" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="pdf" class="form-label">PDF</label>
                <input type="file" name="pdf" class="form-control" id="file" accept=".pdf,.docs" aria-describedby="emailHelp">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>


        <table class="table table-striped mt-4 table-2">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Image</th>
                    <th scope="col">Pdf</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ebook as $item)
                <th scope="row">
                    {{ $loop->index + 1}}
                </th>
                <td>{{$item->name}}</td>
                <td>{{$item->category['name']}}</td>
                <td> <img src="image/{{$item->image}}" alt="" class="image-style"> </td>
                <td> <a href="pdf/{{$item->pdf}}" target="_blank">{{$item->pdf}}</a> </td>
                <td>
                    <div>
                        <a href={{"edit/".$item['id']}}><button class="btn btn-success">Update</button></a>
                        <a href={{"delete/".$item['id']}}><button class="btn btn-danger">Delete</button></a>
                    </div>
                </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('category')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="">Category</label>
                            <input type="text" id="add-category" class="form-control" name="category">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="update-btn">Update</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>