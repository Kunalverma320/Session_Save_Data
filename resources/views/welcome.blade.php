<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Session Prac</title>
    <link rel="stylesheet" href="{{asset('asset/css/style.css')}}">

</head>

<body>
    <div class="container">


        <form action="{{ route('form.data') }}" method="post" enctype="multipart/form-data">
            @csrf

            @if (session('success'))
                <div class="alert alert-success">
                   <span>{{ session('success') }}</span>
                </div>
            @endif
            <div class="row">
                <div class="column left">
                    <label for="name">Name</label><br>
                    <input id="name" type="text" name="Name" value="{{old('Name')}}">
                    @error('Name')
                        <div class="alert alert-danger">*{{ $message }}</div>
                    @enderror
                </div>
                <div class="column right">
                    <label for="Password">Password</label><br>
                    <input id="Password" type="password" name="Password" value="{{old('Password')}}"><br>
                    @error('Name')
                        <div class="alert alert-danger">*{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="column left">
                    <label for="Email">Email</label><br>
                    <input id="Email" type="Email" name="Email" value="{{old('Email')}}">
                    @error('Email')
                        <div class="alert alert-danger">*{{ $message }}</div>
                    @enderror
                </div>
                <div class="column right">
                    <label for="Image">Image</label><br>
                    <input id="Image" type="file" name="Image" value="{{old('Image')}}"><br>
                    @error('Image')
                        <div class="alert alert-danger">*{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="column left">
                    <label for="Mobile">Mobile</label><br>
                    <input id="Mobile" type="number" name="Mobile" value="{{old('Mobile')}}">
                    @error('Mobile')
                        <div class="alert alert-danger">*{{ $message }}</div>
                    @enderror
                </div>
                <div class="column right">
                    <label for="Date">Date</label><br>
                    <input id="Date" type="datetime-local" name="Date" value="{{old('Date')}}"><br>
                    @error('date')
                        <div class="alert alert-danger">*{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="column left">
                    <label for="Role">Role</label><br>
                    <select name="Role" id="Role">
                        <option value="Admin" {{ old('Role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="User" {{ old('Role') == 'User' ? 'selected' : '' }}>User</option>
                    </select>
                    @error('Role')
                        <div class="alert alert-danger">*{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="margintop4">
                <input class="sign-in-btn" type="submit" value="Submit">
            </div>
        </form>

        <br><br><br><br>
        <div>
        <form action="{{route('csv.upload')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="csvupload" id="csvupload">
            <div class="margintop4">
                <input class="sign-in-btn" type="submit" value="Submit">
            </div>
        </form>
        </div>
        <br><br><br><br>
        @if (Session::has('formData'))
            <table style="width:100%" class="margintop4">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Role</th>
                    <th>Password</th>
                    <th>Image</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                @foreach (Session::get('formData') as $id => $item)
                    <tr>

                        <td>{{ $id }}</td>
                        <td>{{ $item['Name'] }}</td>
                        <td>{{ $item['Email'] }}</td>
                        <td>{{ $item['Mobile'] }}</td>
                        <td>{{ $item['Role'] }}</td>
                        <td>{{ $item['Password'] }}</td>
                        <td>
                            @if (isset($item['Image']))
                                <img src="{{ url('storage/' . $item['Image']) }}" alt="Uploaded Image"
                                    class="uploaded-image" width="100">
                            @endif
                        </td>

                        <td>{{ $item['Date'] }}</td>

                        <td>
                            {{-- <button>Edit</button> --}}
                            <a href="{{ route('form.data.edit', $id) }}" type="button" class="button">Edit</a>
                            <a href="{{route('form.data.delete',$id)}}" type="button" class="button">Delete</a>

                        </td>
                    </tr>
                @endforeach
            </table>
            <center class="margintop4"><a href="{{route('final.submit')}}" class="button">Final Submit</a></center>
        @endif

    </div>
</body>

</html>
