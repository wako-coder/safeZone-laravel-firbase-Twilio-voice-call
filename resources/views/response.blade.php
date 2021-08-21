
<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.10.1/firebase.js"></script>
<script>
     var config = {
        apiKey: "{{ config('services.firebase.api_key') }}",
        authDomain: "{{ config('services.firebase.auth_domain') }}",
        databaseURL: "{{ config('services.firebase.database_url') }}",
        storageBucket: "{{ config('services.firebase.storage_bucket') }}",
    };
    firebase.initializeApp(config);

    var database = firebase.database();

    var lastIndex = 2;
    var id = {!! json_encode($id) !!};
    var flame = {!! json_encode($flame) !!};
    var smoke = {!! json_encode($smoke) !!};
    var obstacle = {!! json_encode($obstacle) !!};
    var userID = {!! rand(1,1999) !!};
    console.log(flame);
    firebase.database().ref('/reports/' + userID).set({
           flame: flame,
            smoke: smoke,
            motion: obstacle,
            device_id : id,
        });
        lastIndex = userID;


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
                   console.log('success');
                    }
                  
                });
               
                
            }
            lastIndex = index;
        });
      
    });
        
</script>