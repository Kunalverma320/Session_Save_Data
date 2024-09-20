<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Locker</title>
    <style>
        .color_num {
            color: #1d04ff;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row lockavtext">

        </div>
        <div class="row lockerdata mt-2">
            {{-- fatchdata locker --}}
        </div>

        <div class="row">
            <div class="col-sm-6">
                <h1 class="text-center mt-1">Locker Room</h1>
                <div id="errors" class="alert alert-danger" style="display:none;"></div>

                <div id="successMessage" class="alert alert-success" style="display:none;"></div>
                <div class="row" id="pickupkey">
                    <div class="form-group mt-1">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter Your Name">
                    </div>
                    <div class="form-group mt-1">
                        <label for="exampleInputPassword1">Address</label>
                        <textarea name="address" class="form-control" id="address" cols="30" rows="10"
                            placeholder="Enter Your Name"></textarea>
                    </div>
                    <button type="submit" id="submitFormLocker" class="btn btn-primary mt-2">Submit</button>
                </div>
            </div>

            <div class="col-sm-6">
                <h1 class="text-center mt-1">Collect Room</h1>
                <div id="successRefMessage" class="alert alert-success" style="display:none;"></div>
                <div class="row" id="collectkey">
                    <div class="form-group mt-1">
                        <label for="exampleInputEmail1">Loker Id</label>
                        <input type="number" class="form-control" id="lokerkey" name="lokerkey"
                            placeholder="Enter Yor Loker Key">
                    </div>

                    <button type="submit" id="CollectLock" class="btn btn-primary mt-2">Submit</button>
                    <div class="row KeyDifused">

                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetchLockerData() {
            $.ajax({
                url: "{{ route('lockers.fetch') }}",
                method: "GET",
                success: function(response) {
                    let lockerCards = '';
                    let lockavtext = '';
                    let lockerav = 0;
                    lockerav = response.lockav;
                    response.data.forEach(function(locker) {
                        let buttonClass = '';
                        let buttonText = '';
                        if (locker.status === 101) {
                            buttonClass = 'btn-success';
                            buttonText = 'Available';
                        } else if (locker.status === 102) {
                            buttonClass = 'btn-danger';
                            buttonText = 'Occupied';
                        }
                        lockerCards += `
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Locker Number <span class="color_num">${locker.locker_number}</span></h5>
                                    <p class="card-text"></p>
                                     <p class="text-center btn ${buttonClass}">${buttonText}</p>
                                </div>
                            </div>
                        </div>`;
                    });
                    lockavtext = `<h3 class="card-title text-center">Locker Available: ${lockerav}</h3>`;
                    $('.lockerdata').html(lockerCards);
                    $('.lockavtext').html(lockavtext);

                },
                error: function(xhr, status, error) {
                    console.error('Error fetching locker data:', error);
                }
            });
        }


        $(document).ready(function() {
            $('#submitFormLocker').click(function(e) {
                e.preventDefault();
                let name = $('#name').val();
                let address = $('#address').val();

                $.ajax({
                    url: "{{ route('data.store') }}",
                    method: "POST",
                    data: {
                        name: name,
                        address: address,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {

                        if (response.success) {
                            $('#successMessage').text(response.message).show();
                            $('#name').val('');
                            $('#address').val('');
                            fetchLockerData();
                        }

                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = '';
                            $.each(errors, function(key, value) {
                                errorMessages += '<p>' + value[0] + '</p>';
                            });
                            $('#errors').html(errorMessages).show();
                        } else if (xhr.status === 404) {
                            $('#errors').html('<p>' + xhr.responseJSON.message + '</p>').show();
                        }
                    }
                });
            });
            $('#CollectLock').click(function(e) {
                e.preventDefault();
                let lockerkey = $('#lokerkey').val();
                $.ajax({
                    url: "{{ route('userdata.fatch') }}",
                    method: "POST",
                    data: {
                        lockerkey: lockerkey,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        let lockername = '';
                        lockername = response.data.name;
                        lockeraddress = response.data.address;

                        let lockerCards = `
                        <div class="form-group mt-1">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" id="lokerkey" value="${lockername}" name="lockername">
                        </div>
                        <div class="form-group mt-1">
                            <label for="exampleInputEmail1">Address</label>
                            <textarea type="text" class="form-control">${lockeraddress}</textarea>
                        </div>
                        <a type="submit" id="KeyRefuse" class="btn btn-dark mt-2">Defuse Key</a>
                        `;
                        $('.KeyDifused').html(lockerCards);

                        fetchLockerData();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error saving data:', error);
                    }
                });
            });

            $(document).on('click', '#KeyRefuse', function(e) {
                e.preventDefault();
                let lockerkey = $('#lokerkey').val();
                $.ajax({
                    url: "{{ route('userdata.defuse') }}",
                    method: "POST",
                    data: {
                        lockerkey: lockerkey,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#successRefMessage').text(response.message).show();
                            $('.KeyDifused').empty();
                            fetchLockerData();
                            $('#lokerkey').val('');
                        } else {
                            alert('Error in defusing key!');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error defusing key:', error);
                    }
                });
            });

            fetchLockerData();
        });
    </script>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
