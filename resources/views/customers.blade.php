<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <title>SafeZone-Registration</title>
</head>
<body>

<div class="container" style="margin-top: 50px;">

    <h4 class="text-center">SafeZone User Registration</h4><br>

    <button onclick="getLocation()" class="btn btn-info">Get Your Location</button>

<p id="demo"></p>

    <h5># Add Customer</h5>
    <div class="card card-default">
        <div class="card-body">
            <form id="addCustomer" class="form-inline" method="POST" action="">
                <div class="form-group mb-2">
                    <label for="name" class="sr-only">Name</label>
                    <input id="name" type="text" class="form-control" name="name" placeholder="Name"
                           required autofocus>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="phone" class="sr-only">phone</label>
                    <input id="phone" type="tel" class="form-control" name="phone" placeholder="phone number"
                    pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required autofocus>
                    
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="device_id" class="sr-only">Device Id</label>
                    <input  type="text" class="form-control" name="device_id" id="device_id" placeholder="safe123"
                     required autofocus>
                    
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="url" class="sr-only">Latitude</label>
                    <input  type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude"
                     required autofocus>
                    
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="url" class="sr-only">Longitude</label>
                    <input  type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude"
                     required autofocus>
                    
                </div>
                
                <button id="submitCustomer" type="button" class="btn btn-primary mb-2">Submit</button>
            </form>
        </div>
    </div>

    <br>

    <h5># Customers</h5>
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>phone number</th>
            <th>device_id</th>
            <th width="180" class="text-center">Action</th>
        </tr>
        <tbody id="tbody">

        </tbody>
    </table>
</div>

<!-- Update Model -->
<form action="" method="POST" class="users-update-record-model form-horizontal">
    <div id="update-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:55%;">
            <div class="modal-content" style="overflow: hidden;">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Update</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body" id="updateBody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-success updateCustomer">Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Delete Model -->
<form action="" method="POST" class="users-remove-record-model">
    <div id="remove-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Delete</h4>
                    <button type="button" class="close remove-data-from-delete-form" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>Do you want to delete this record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form"
                            data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-danger waves-effect waves-light deleteRecord">Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


{{--Firebase Tasks--}}
<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.10.1/firebase.js"></script>
<script>
    // Initialize Firebase
    var config = {
        apiKey: "{{ config('services.firebase.api_key') }}",
        authDomain: "{{ config('services.firebase.auth_domain') }}",
        databaseURL: "{{ config('services.firebase.database_url') }}",
        storageBucket: "{{ config('services.firebase.storage_bucket') }}",
    };
    firebase.initializeApp(config);

    var database = firebase.database();

    var lastIndex = 0;

    // Get Data
    firebase.database().ref('customers/').on('value', function (snapshot) {
        var value = snapshot.val();
        var htmls = [];
        $.each(value, function (index, value) {
            if (value) {
                htmls.push('<tr>\
        		<td>' + value.name + '</td>\
        		<td>' + value.phone + '</td>\
                <td>' + value.device_id + '</td>\
                <td>' + '<a href="http://maps.google.com/maps?q=loc:'+ value.latitude +' ,' + value.longitude +'" target="_blank">map adreess!</a></td>\
        		<td><button data-toggle="modal" data-target="#update-modal" class="btn btn-info updateData" data-id="' + index + '">Update</button>\
        		<button data-toggle="modal" data-target="#remove-modal" class="btn btn-danger removeData" data-id="' + index + '">Delete</button></td>\
        	</tr>');
            }
            lastIndex = index;
        });
        $('#tbody').html(htmls);
        $("#submitUser").removeClass('desabled');
    });

    // Add Data
    $('#submitCustomer').on('click', function () {


        var values = $("#addCustomer").serializeArray();
        var name = values[0].value;
        var phone = values[1].value;
        var latitude= values[3].value;
        var longitude = values[4].value;
        var device_id = values[2].value;
        var userID = lastIndex + 1;

        console.log(values);

        firebase.database().ref('customers/' + userID).set({
            name: name,
            phone: phone,
            latitude: latitude,
            longitude: longitude,
            device_id: device_id,
        });

        // Reassign lastID value
        lastIndex = userID;
        $("#addCustomer input").val("");
    });

    // Update Data
    var updateID = 0;
    $('body').on('click', '.updateData', function () {
        updateID = $(this).attr('data-id');
        firebase.database().ref('customers/' + updateID).on('value', function (snapshot) {
            var values = snapshot.val();
            var updateData = '<div class="form-group">\
		        <label for="first_name" class="col-md-12 col-form-label">Name</label>\
		        <div class="col-md-12">\
		            <input id="first_name" type="text" class="form-control" name="name" value="' + values.name + '" required autofocus>\
		        </div>\
		    </div>\
		    <div class="form-group">\
		        <label for="phone" class="col-md-12 col-form-label">phone</label>\
		        <div class="col-md-12">\
		            <input id="phone" type="tel" class="form-control" name="phone" value="' + values.phone + '" required autofocus>\
		        </div>\
		    </div>\
            <div class="form-group">\
		        <label for="device_id" class="col-md-12 col-form-label">phone</label>\
		        <div class="col-md-12">\
		            <input id="last_name" type="tex" class="form-control" name="device_id" value="' + values.device_id + '" required autofocus>\
		        </div>\
		    </div>\
            <div class="form-group">\
		        <label for="url" class="col-md-12 col-form-label">google map address</label>\
		        <div class="col-md-12">\
		            <input id="url" type="text" class="form-control" name="latitude" value="' + values.latitude + '" required autofocus>\
		        </div>\
                <div class="form-group">\
		        <label for="url" class="col-md-12 col-form-label">google map address</label>\
		        <div class="col-md-12">\
		            <input id="url" type="text" class="form-control" name="longitude" value="' + values.longitude+ '" required autofocus>\
		        </div>\
		    </div>';

            $('#updateBody').html(updateData);
        });
    });

    $('.updateCustomer').on('click', function () {
        var values = $(".users-update-record-model").serializeArray();
        var postData = {
            name: values[0].value,
            phone: values[1].value,
            url: values[2].value,
            device_id: values[3].value,
            
        };

        var updates = {};
        updates['/customers/' + updateID] = postData;

        firebase.database().ref().update(updates);

        $("#update-modal").modal('hide');
    });

    // Remove Data
    $("body").on('click', '.removeData', function () {
        var id = $(this).attr('data-id');
        $('body').find('.users-remove-record-model').append('<input name="id" type="hidden" value="' + id + '">');
    });

    $('.deleteRecord').on('click', function () {
        var values = $(".users-remove-record-model").serializeArray();
        var id = values[0].value;
        firebase.database().ref('customers/' + id).remove();
        $('body').find('.users-remove-record-model').find("input").remove();
        $("#remove-modal").modal('hide');
    });
    $('.remove-data-from-delete-form').click(function () {
        $('body').find('.users-remove-record-model').find("input").remove();
    });
</script>
<script>
    var x = document.getElementById("demo");
    
    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
      }
    }
    
    function showPosition(position) {
      x.innerHTML = "Latitude: " + position.coords.latitude + 
      "<br>Longitude: " + position.coords.longitude;
    }
    </script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
