<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <title>main</title>
</head>
<body>

<div class="container" style="margin-top: 50px;">

    <h4 class="text-center">SafeZone User Registration</h4><br>

    <h5># Add Customer</h5>
    <div class="card card-default">
        <div class="card-body">
            <form id="addCustomer" class="form-inline" method="POST" action="">
                <div class="form-group mb-2">
                    <label for="smoke" class="sr-only">flame</label>
                    <input id="smoke" type="text" class="form-control" name="flame" placeholder="flame"
                           required autofocus>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="smoke" class="sr-only">smoke</label>
                    <input id="smoke" type="text" class="form-control" name="smoke" placeholder="smoke"
                    pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required autofocus>
                    
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="motion" class="sr-only">motion</label>
                    <input id="motion" type="text" class="form-control" name="motion" placeholder="motion"
                    pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required autofocus>
                    
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="device_id" class="sr-only">Device Id</label>
                    <input  type="text" class="form-control" name="device_id" id="device_id" placeholder="device id"
                     required autofocus>
                    
                </div>
                <button id="submitCustomer" type="button" class="btn btn-primary mb-2">Submit</button>
            </form>
        </div>
    </div>

    <br> 
   
</div>

<!-- Update Model -->

<!-- Delete Model -->



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
  
    firebase.database().ref('reports/').limitToLast(1).on('value', function (snapshot) {
        
        var value = snapshot.val();
        $.each(value, function (index, value) {
            if (value.flame == 1 ) {
                database.ref('customers/').orderByChild('device_id').limitToLast(1).equalTo(value.device_id).on('value', function (snapshot) { 
                    var values = snapshot.val();
                    if (values !== null) {
                        const audio = new Audio('http://www.mp3clock.com/soundeffects/ambulance.wav');
                    audio.play();
                    $.each(values, function (index, values) {
                    window.open('http://maps.google.com/maps?q=loc:'+ values.latitude +' ,' + values.longitude +'');
                    });
                   
                    }
                  
                });
               
                
            }
            lastIndex = index;
        });
      
    });
    
    
    // Add Data
    $('#submitCustomer').on('click', function () {
        var values = $("#addCustomer").serializeArray();
        var flame = values[0].value;
        var smoke = values[1].value;
        var motion = values[2].value;
        var device_id = values[3].value;
        var userID = lastIndex + 1;

        console.log(values);

        firebase.database().ref('/reports/' + userID).set({
            flame: flame,
            smoke: smoke,
            motion: motion,
            device_id: device_id,
        });

        // Reassign lastID value
        lastIndex = userID;
        $("#addCustomer input").val("");
    });

    //update data

    // Remove Data

</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
