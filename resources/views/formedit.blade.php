<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FormEdit</title>
    <link rel="stylesheet" href="{{asset('asset/css/style.css')}}">

</head>
<body>
    <div class="container">
    <form action="{{ route('form.data.edit.save',$id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="column left">
                <label for="name">Name</label><br>
                <input id="name" type="text" name="Name" value="{{$record['Name']}}">
                @error('Name')
                    <div class="alert alert-danger">*{{ $message }}</div>
                @enderror
            </div>
            <div class="column right">
                <label for="Password">Password</label><br>
                <input id="Password" type="password" name="Password" value="{{$record['Password']}}"><br>
                @error('Name')
                    <div class="alert alert-danger">*{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="column left">
                <label for="Email">Email</label><br>
                <input id="Email" type="Email" name="Email" value="{{$record['Email']}}">
                @error('Email')
                    <div class="alert alert-danger">*{{ $message }}</div>
                @enderror
            </div>
            <div class="column right">
                <label for="Image">Image</label><br>
                <input id="Image" type="file" name="Image"><br>
                @if(isset($record['Image']))
                    <img src="{{ asset('storage/' . $record['Image']) }}" alt="Uploaded Image" width="50" height="50" class="uploaded-image">
                @endif
                @error('Image')
                    <div class="alert alert-danger">*{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="column left">
                <label for="Mobile">Mobile</label><br>
                <input id="Mobile" type="number" name="Mobile" value="{{$record['Mobile']}}">
                @error('Mobile')
                    <div class="alert alert-danger">*{{ $message }}</div>
                @enderror
            </div>
            <div class="column right">
                <label for="Date">Date</label><br>
                <input id="Date" type="datetime-local" name="Date" value="{{$record['Date']}}"><br>
                @error('date')
                    <div class="alert alert-danger">*{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="column left">
                <label for="Role">Role</label><br>
                <select name="Role" id="Role">
                    <option value="Admin" {{ old('Role',$record['Role']) == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="User" {{ old('Role',$record['Role']) == 'User' ? 'selected' : '' }}>User</option>
                </select>
                @error('Role')
                    <div class="alert alert-danger">*{{ $message }}</div>
                @enderror
            </div>
        </div>


        <div class="margintop4">
            <a href="{{route('home')}}" class="button">back</a>
            <input class="sign-in-btn" type="submit" value="Update">
        </div>
    </form>
</div>
</body>
</html>
