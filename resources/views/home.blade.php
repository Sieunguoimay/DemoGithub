@extends('layout.webgl')
@section('style2')
<style>
#main_menu{
    transition: transform 0.5s ease-out;
}

#main_menu a{
    color: #222;
    text-decoration: none;
    font-size:22px;
    font-family:monospace;
    text-shadow: 0 0 4px #ffffff;
}
#main_menu a:hover{
    color: #ffa0a0;
}



div.modal-content{
    padding:9px 15px;
    border:0px solid #eee;
    background-color: #00000022;
    -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
    -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
    -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
    box-shadow: 0 5px 15px rgba(0,0,0,0);
}


.hide-menu{
    animation-name:close_menu;
    animation-duration: 0.5s;
    animation-timing-function: ease-out;
    animation-fill-mode: forwards;
}
.show-menu{
    animation-name:show_menu;
    animation-duration: 0.5s;
    animation-timing-function: ease-out;
    animation-fill-mode: forwards;
}
.animation-zoom-out{
    animation-name:zoom_out;
    animation-duration: 0.4s;
    animation-timing-function: ease-out;
    animation-fill-mode:forwards;
}
@keyframes close_menu{
    from{opacity:1;transform: translateX(0px) scale(1);}
    to{opacity:0.2;transform: translateX(-50px) scale(0.95);}
}
@keyframes show_menu{
    from{opacity:0.2;transform: translateX(-50px) scale(0.95);}
    to{opacity:1;transform: translateX(0px) scale(1);}
}
/*Main Modal show up*/
@keyframes zoom_out{
    from{transform:translateX(-180px) scale(0.8,0.5);}
    to{transform: translateX(0) scale(1);}
}

@media only screen and (max-width: 600px) {
    @keyframes show_menu{
        from{top:50px;opacity:0;}
        to{top:0px;opacity:1;}
    }
    @keyframes close_menu{
        from{top:0px;opacity:1;}
        to{top:50px;opacity:0;}
    }
    @keyframes zoom_out{
        from{transform:translateY(120px); }
        to{transform: translateX(0) ;}
    }
}


.fullscreen{
    position: absolute;
    top:0;
    left:0;
    width: 100%;
    height: 100vh;
    margin:0;
    padding:0;
}

#main_modal {
    transition: opacity 0.3s linear;
    z-index: 10;
}

.hidden {
  display: none;
}

.visuallyhidden {
  opacity: 0;
}
.visuallyvisible {
  opacity: 1;
}

.blur-effect{
    -webkit-filter: blur(4px);
    -moz-filter: blur(4px);
    -o-filter: blur(4px);
    -ms-filter: blur(4px);
    filter: blur(4px);
    filter: url("https://gist.githubusercontent.com/amitabhaghosh197/b7865b409e835b5a43b5/raw/1a255b551091924971e7dee8935fd38a7fdf7311/blur".svg#blur);
    filter:progid:DXImageTransform.Microsoft.Blur(PixelRadius='4');
}

#webgl_canvas{
    transition: opacity 0.5s linear,0.4s filter linear;

}

.modal-card{
    border:0px solid #eee;
    background-color: #77553322;
    /* -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
    -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
    -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
    box-shadow: 0 5px 15px rgba(0,0,0,0); */

    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
    max-height: 100vh;
}

#modal_body{
    transition: all 0.5s linear;
}
#div_bell_to_ring{
    transition: transform 0.05s linear;
    cursor: pointer;
    margin: 20px 20px 20px 5px;
    color:#F4F4F8; 
    /* background-color:#2AB7CA;  */
    background-color:#777; 
    padding:5px;
    border-radius:5px;

    /* these two go in hand with eachother*/
    z-index: 100;
    position: relative;
}
#div_bell_to_ring:hover{
    background-color:#555;
}

#div_bell_to_ring:active{
    transform:scale(1.15);
}
#div_bell_count{
    transition: transform 0.5s ease-out,opacity 0.5s ease-out;
    display:inline-block;
    background-color:#fed766;
    border-radius:5px;
    color:white;
    padding:2px 8px 2px 8px;
    margin:0;
    z-index: 0;
    font-weight: bold;
}
.animate-hide-bell-count{
    transform:translateX(20px);
    opacity:0;
}
.animate-show-bell-count{
    transform:translateX(0px);
    opacity:1;
}

.animate_scale_the_bell{
    animation-name:keyframe_animate_scale_the_bell;
    animation-duration: 0.3s;
    animation-timing-function: ease-out;
    animation-fill-mode:forwards;
}
@keyframes keyframe_animate_scale_the_bell{
    0%{
        transform:scale(1);
    }
    50%{
        transform:scale(1.2);
    }
    100%{
        transform:scale(1);
    }
}

.animate_the_bell{
    animation-name:keyframe_animate_the_bell;
    animation-duration: 1.0s;
    animation-timing-function: ease-out;
    animation-fill-mode:forwards;
}
@keyframes keyframe_animate_the_bell{
    from{
        transform:rotateZ(0deg);
    }
    to{
        transform:rotateZ(360deg);
    }
}

</style>
@endsection

@section('content2')

<div class="row fullscreen pl-md-5 pl-sm-0">
    <div class="col-md-4 col-sm-12 mt-5 pt-5 ml-md-5 ml-sm-0 pl-5 show-menu align-self-center"  id="main_menu">
        <a href="#" class="modal-trigger" id="a_sieunguoimay" style="font-size: 35px; font-weight:bold;">Sieunguoimay</a><br>
        <a href="#" class="modal-trigger" id="a_game_engine">Game Engine</a><br>
        <a href="#" class="modal-trigger" id="a_coolthings_notes">Notes on Cool Things</a><br>
        <a href="#" class="modal-trigger" id="a_download_cv">Download CV</a><br>
        <a href="#" id="a_fullscreen" >Open Fullscreen</a><br>
    </div>
</div>

<div class="col-md-12 p-0">
    <div class="row-12 text-right p-0">
        <div style="float:right">
            <div id="div_bell_count" class="animate-hide-bell-count">100</div>
            <div id="div_bell_to_ring" class="d-inline-block">
                <i class="far fa-bell" style="font-size:25px;" id="i_bell_to_ring" ></i>
            </div>
            <audio controls id="audio_ring_the_bell" style="display:none">
                <source src="/assets/audios/bell2.wav" type="audio/mpeg">
                    Your browser does not support the audio element.
            </audio>
        </div>
    </div>
</div>


<div class="row hidden visuallyhidden fullscreen justify-content-center" id="main_modal">
    <div class="col-lg-6 col-md-8 col-sm-12 align-self-center">
        <div class="card modal-card" >
            <div class="card-title px-2 pt-2 pb-0 mb-0 text-center border-bottom">
                <div class="container-fluid m-0">

                    <div class="row">
                        <div class="col-1 m-0 p-0 text-left" >
                            <span id="span_btn_back_modal">
                                <button type="button" id="btn_back_modal" class="transparent-button">
                                    <i class="fas fa-arrow-left" style="font-size:15px;color:#765"></i>
                                </button>
                            </span>
                        </div>
                        <div class="col-10 m-0 px-2">
                            <h3 id="modal_title">Cool Technologies</h3>
                        </div>
                        <div class="col-1 m-0 p-0 text-right">
                            <button type="button" id="close_main_modal" class="transparent-button">
                                <i class="fas fa-times" style="font-size:17px;color:#765"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-sm-0.5"  style="overflow-y: auto;">
                <div class="container p-0 m-0" id="modal_body">
                    <div class="row justify-content-center">

                    </div>
                </div>

                <span id="span_loading" class="hidden">
                    <div class="container">
                        <div class="row justify-content-center" >
                            <div class="spinner-border m-5" role="status" id="spinner">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div class="hidden" id="something_went_wrong">
                                <strong>Oops!</strong> Something went wrong. Please try again.
                            </div>
                        </div>
                    </div>
                </span>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script2')
<script>

var DirectoryManager = {
    currentPath:"/home",
    currentPathName:"",
    setCurrentPath(path){
        this.currentPath = path;
        console.log(this.currentPath);

    },
    goInto(name,displayName){
        this.currentPathName = name;
        this.setCurrentPath(this.currentPath+'/'+this.currentPathName);
        console.log(this.currentPathName);
        setDisplayName(displayName);
        ClientDataCollector.collectClick(this.currentPath);
    },
    back(){
        if(this.currentPath!="/home"){
            var pos = this.currentPath.lastIndexOf('/');
            this.setCurrentPath(this.currentPath.slice(0,pos));
            pos = this.currentPath.lastIndexOf('/');
            this.currentPathName = this.currentPath.slice(pos+1,this.currentPath.length);
            
            console.log(this.currentPathName,pos+1);
        }
    },
    gotoRoot(){
        this.setCurrentPath("/home");
        this.currentPathName = ""
        console.log(this.currentPathName);
    },
    isRoot(){
        return (this.currentPath=="/home");
    },
    fetching:false,
    changeDirectory(name){
        var data = {name:name};
        BackgroundPlayer.pause();

        $('#modal_body').hide();
        $('#span_loading').show();
        $('#spinner').show();


        this.fetching = true;
        ClientDataCollector.postRequest('/menu',data,function(response){
            $('#modal_title').html($('#'+data.name).text());
            var html = $("<div>"+response.html+"</div>").hide();
            $('#modal_body').html(html);
            html.fadeIn('slow');
            $('#span_loading').hide();
            $('#spinner').hide();
            $('#modal_body').show();
            this.fetching = false;
        });

    }
};

$('#btn_back_modal').on('click',function(){
    DirectoryManager.back();
    if(!DirectoryManager.isRoot()){
        DirectoryManager.changeDirectory(DirectoryManager.currentPathName);
    }else{
        closeModal();
    }
});

// Get the modal
var modal = document.getElementById('main_modal');
//setupBackButton(false);
showButton(true);

function showButton(show){
    if(show)
        $('#span_btn_back_modal').show();
    else
        $('#span_btn_back_modal').hide();
}
function setDisplayName(displayName){
    $('#modal_title').html(displayName);
}

/*On menu item clicked*/
$('.modal-trigger').on('click',function(){

    if($('#main_menu').hasClass('show-menu')) $('#main_menu').toggleClass('show-menu');
    if(!$('#main_menu').hasClass('hide-menu')) $('#main_menu').toggleClass('hide-menu');
    
    DirectoryManager.goInto($(this).attr('id'),$(this).text());
    showModal();
    DirectoryManager.changeDirectory(DirectoryManager.currentPathName);

});

$('#main_modal').on('transitionend',function(e){
    if(e.target == this){
        var blurring = $('#webgl_canvas').hasClass('blur-effect');
        if(blurring!=modalShowingFlag){
            $('#webgl_canvas').toggleClass('blur-effect');
        }
    }
});
$('#webgl_canvas').on('transitionend',function(e){
    if(e.target == this){
        var blurring = $('#webgl_canvas').hasClass('blur-effect');
        if(!blurring)
            BackgroundPlayer.continue();
    }
});


/*Trigger Close the modal*/
var modalShowingFlag = false;
function closeModal(){
    if(hideElement(modal)){
        if(!$('#main_menu').hasClass('show-menu')) $('#main_menu').toggleClass('show-menu');
        if($('#main_menu').hasClass('hide-menu')) $('#main_menu').toggleClass('hide-menu');

        modalShowingFlag = false;

        if(!DirectoryManager.isRoot()){
            DirectoryManager.gotoRoot();
        }
    }
}
function showModal(){
    if(showElement(modal)){
        modalShowingFlag = true;
        if(!$('#main_modal').hasClass('animation-zoom-out')) $('#main_modal').toggleClass('animation-zoom-out');
    }
}

window.onclick = function(event) {
    if (event.target == modal) {
        closeModal();
    }
}
$('#close_main_modal').on('click',function(){
    closeModal();
});


var fullscreen = false;
$('#a_fullscreen').on('click',function(){
    if(fullscreen){
        closeFullscreen();
        fullscreen = false;
        $('#a_fullscreen').text('Open Fullscreen');
    }
    else{
        fullscreen = true;
        openFullscreen();
        $('#a_fullscreen').text('Close Fullscreen');
    }
});

function showElement(element,callback=null){
    if (element.classList.contains('hidden')) {
        element.classList.remove('hidden');
        setTimeout(function () {
            element.classList.remove('visuallyhidden');
            if(callback)
                callback();
        }, 20);
        return true;
    }
    return false;
}
function hideElement(element,callback=null){
    if (!element.classList.contains('hidden')){

        element.classList.add('visuallyhidden');    
        element.addEventListener('transitionend', function(e) {
            element.classList.add('hidden');
            // $('#main-modal').modal('hide');
            if(callback)
               callback();
        }, {
            capture: false,
            once: true,
            passive: false
        });
        return true;
    }
    return false;
}


$('#div_bell_to_ring').on('click',function(){
    if($('#i_bell_to_ring').hasClass('animate_the_bell'))
        $('#i_bell_to_ring').removeClass('animate_the_bell');
    $('#i_bell_to_ring').addClass('animate_the_bell');

    // if($(this).hasClass('animate_scale_the_bell'))
    //     $(this).removeClass('animate_scale_the_bell');
    
    // $(this).addClass('animate_scale_the_bell');
    $('#audio_ring_the_bell')[0].play();   
    ClientDataCollector.RingTheBell(); 


    $('#div_bell_count').addClass('delay-animation');
    setTimeout(function() { 
        $('#div_bell_count').removeClass('delay-animation'); 
        if(!$('#div_bell_count').is(":hover")){
            $('#div_bell_count').addClass('animate-hide-bell-count');
            $('#div_bell_count').removeClass('animate-show-bell-count');
        }
    }, 2000);
});
$('#div_bell_to_ring').hover(function () {
    $('#div_bell_count').addClass('animate-show-bell-count');
    $('#div_bell_count').removeClass('animate-hide-bell-count');
}, function () {
    if(!$('#div_bell_count').hasClass('delay-animation')){
        $('#div_bell_count').addClass('animate-hide-bell-count');
        $('#div_bell_count').removeClass('animate-show-bell-count');
    }
});

//all the above function is events triggered by user i.e client side

var MainActivtiy = {
    setBellCount(count){
        $('#div_bell_count').html(count);
    }
}






//this is the fucking awesome client that we all rely on. :))))
//it's eventually put into a seperate file . it desires a single palate for it.
ClientDataCollector.setPlatform = function(platform){
    ClientDataCollector.platform = platform;
    this.allSet--;
}
ClientDataCollector.setIpAddress=function(ip){
    this.ipAddress = ip;
    this.allSet--;
}
ClientDataCollector.isAllSet = function(){return this.allSet == 0;}
ClientDataCollector.collectClick = function(what){
    this.clicks.push(what);
    this.length+=what.length;
    console.log(this.clicks,this.length);
}

ClientDataCollector.OnLoad = function(){
    ClientDataCollector.loadingTime = Date.now()-ClientDataCollector.startTime;
    console.log('client ready in',ClientDataCollector.loadingTime,'ms');
    ClientDataCollector.getRequest('/get_data_to_display',null,function(response){
        console.log('got data to display',response);
        if(response.status == "OK"){
            MainActivtiy.setBellCount(response.bell_count);
        }
    });

}
ClientDataCollector.OnUnload = function(){
    ClientDataCollector.visitingTime = Date.now()-ClientDataCollector.startTime;

    if (typeof navigator.sendBeacon !== "undefined") {
        //sending with beacon
        const endpoint = '/collect_client_device_data';
        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('client_data', JSON.stringify(ClientDataCollector.GetDataToSendToServer()));
        navigator.sendBeacon(endpoint, formData);
    }else{
        //sending with ajax incase beacon is not there. but this not properly works on chrome v30
        $.post('/collect_client_device_data',
            {client_data:JSON.stringify(ClientDataCollector.GetDataToSendToServer())});
    }
}

ClientDataCollector.Init = function(){
    this.bellCount = 0;
    this.belled = false;
    this.allSet = 2;
    this.clicks = [];
    this.length = 0;
    MainActivtiy.setBellCount(this.bellCount);    
}


ClientDataCollector.Collect = function(){
    Fingerprint2.getV18(function(result, components){
        ClientDataCollector.fingerprint = result;
    });

    misc_GetClientIpAddress(function(ip){
        ClientDataCollector.setIpAddress(ip.ip);
    });

    this.setPlatform(misc_GetPlatformAndBrowserNames());
    console.log(ClientDataCollector.platform);
}
ClientDataCollector.GetDataToSendToServer = function(){
    return {
        device:{
            ip:this.ipAddress,
            platform:this.platform,
            fingerprint:this.fingerprint,
            belled:this.belled
        },
        visiting_data:{
            visiting_time:this.visitingTime,
            loading_time:this.loadingTime,
            clicks:this.clicks
        }
    };
}
ClientDataCollector.RingTheBell=function(){
    this.postRequest('/ring_the_bell',{fingerprint:this.fingerprint},
        function(response){
            if(response.status=='OK'){
                if(response.bell!="already_belled"){//new bell
                    this.bellCount = response.bell_count;
                    this.belled = true;
                    MainActivtiy.setBellCount(this.bellCount);
                    // console.log(this.bellCount);
                }
            }
        }
    ,'json');
}
ClientDataCollector.postRequest = function(url,data,callback,fail_callback)
{
    console.log("new post request to",url);

    $.post(url,data,
        function(response){
            if(callback)
                callback(response);
        }
    ,"json").fail(
        function(error){
            if(fail_callback)
                fail_callback(error);
        }
    );
}
ClientDataCollector.getRequest = function(url,data,callback){
    $.get(url,data,function(response){
        if(callback)
            callback(response);
    });
}


    
$(window).on('load', function() {
    BackgroundPlayer.Init(function OnWebGLReady(){
        ClientDataCollector.OnLoad();
        ClientDataCollector.Collect();
    });
    ClientDataCollector.Init();
});
$(window).on('unload', function() {
    ClientDataCollector.OnUnload();
});
</script>
@endsection
