
Client.Init = function(){
    console.log('client setup done. You can start talking with the server for data now.');

    this.SetupCallbacks();
    this.getData();
}
Client.getData = function(){
    $.get('/get_client_data',null,function(response){
        console.log(response);
        if(response.status=="OK"){
            MainActivity.DisplayFingerprint(JSON.parse(response.data));
            console.log(JSON.parse(response.data));
        }
    });
}


Client.OnRequireVisitData = function(fingerprint){
    $.get('/get_visit_data_by_fingerprint',{fingerprint:fingerprint},function(response){
        console.log(response);
        if(response.status=="OK"){
            MainActivity.DisplayVisitsDataOfFingerprint(fingerprint,JSON.parse(response.data));
            console.log(JSON.parse(response.data));
        }
    });
}

Client.SetupCallbacks = function(){
    MainActivity.requireVisitData = this.OnRequireVisitData;
}