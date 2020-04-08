
// var data = [{
//     id:0,
//     ip:0,
//     fingerprint:0,
//     platform:0,
//     city:0,
//     country:0,
//     isp:0,
//     lon:0,
//     lat:0,
//     access_count:0,
//     belled:0,
//     updated_at:0
// }];


var MainActivity = {
    Init(){
        this.divClientDevices = document.getElementById('div_client_devices');
        // this.divVisits = document.getElementById('div_visits');


    },

    DisplayFingerprint(devices){
        var html = `
            <table class="table">
                <thead class="black white-text">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ip Address</th>
                        <th scope="col">Fingerprint</th>
                        <th scope="col">Platform</th>
                        <th scope="col">Location</th>
                        <th scope="col">ISP</th>
                        <th scope="col">GeoLocation</th>
                        <th scope="col">Access Count</th>
                        <th scope="col">has belled</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
        `;
        for(var i = 0; i<devices.length; i++){
            var device = devices[i];
            html+=`
                <tr>
                    <th scope="row">`+device.id+`</th>
                    <td>`+device.ip+`</td>
                    <td><a href="#" class="ac_toggle_visits">`+device.fingerprint+`</a></td>
                    <td>`+device.platform+`</td>
                    <td>`+device.city+', '+device.country+`</td>
                    <td>`+device.isp+`</td>
                    <td>`+device.lon+', '+device.lat+`</td>
                    <td>`+device.access_count+`</td>
                    <td>`+device.belled+`</td>
                    <td>`+device.updated_at+`</td>
                </tr>
                <tr>
                <td colspan="10">
                    <div id="div_`+device.fingerprint+`"></div>
                </td>
                </tr>
                `;
        }
        html+=`
                </tbody>
            </table>
        `;
        this.divClientDevices.innerHTML = html;

        $('.ac_toggle_visits').on('click',function(){
            var fingerprint = $(this).text();
            if($(this).hasClass('got_data')){
                if($('#div_'+fingerprint).hasClass('showing')){
                    $('#div_'+fingerprint).removeClass('showing');
                    $('#div_'+fingerprint).hide();
                }else{
                    $('#div_'+fingerprint).addClass('showing');
                    $('#div_'+fingerprint).show();
                }
            }else{
                console.log(fingerprint);
                if(MainActivity.requireVisitData!=null)
                    MainActivity.requireVisitData(fingerprint);
                $('#div_'+fingerprint).addClass('showing');
                $(this).addClass('got_data');
            }
        });
    }
}

MainActivity.DisplayVisitsDataOfFingerprint = function(fingerprint,visits){
    var html = `
        <table class="table">
            <thead class="black white-text">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Clicks</th>
                    <th scope="col">Fingerprint</th>
                    <th scope="col">loading_time</th>
                    <th scope="col">visiting_time</th>
                    <th scope="col">created_at</th>
                </tr>
            </thead>
            <tbody>
    `;

    for(var i = 0; i<visits.length; i++){
        var visit = visits[i];
        html+=`
            <tr>
                <th scope="row">`+visit.id+`</th>
                <td>`+visit.clicks+`</td>
                <td>`+visit.fingerprint+`</td>
                <td>`+visit.loading_time+`</td>
                <td>`+visit.visiting_time+`</td>
                <td>`+visit.created_at+`</td>
            </tr>
            `;
    }
    html+=`
            </tbody>
        </table>
    `;

    $('#div_'+fingerprint).html(html);
}