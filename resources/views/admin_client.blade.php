<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sieunguoimay Admin</title>

    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script>
        var Client = {load(){
                console.log('client loading');
            }};
        Client.load();
    </script>
</head>
<body>


    <div id="layout" class="container-fluid">
        <div class="row-12">
            <h3>This is the view, where you draw anything onto it</h3>
        </div>
        <div class="row-12">
            <div class="container">
                <div class="row-12">
                    <h3> This is where we display client devices</h3>
                </div>
                <div class="row-12" id="div_client_devices">No data</div>
            </div>
        </div>
    </div>


<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script defer src="/lib/fontawesome/js/all.js"></script> <!--load all styles -->
    
<script src="/js/admin/MainActivity.js"></script>
<script src="/js/admin/Client.js"></script>
<script>
    MainActivity.Init();
    Client.Init();
</script>

</body>
</html>