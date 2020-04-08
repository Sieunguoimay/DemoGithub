<style>
.snm-icon{
    font-size:60px;
    filter:drop-shadow(0px 0px 10px #ffffff);
    padding-left: 0px;
    padding-right: 0px;
}
.snm-icon p{
    font-size:20px;
}
.snm-icon img{
    height:65px;
    transform: translateY(-12px);
}
.snm-icon a{
    text-decoration: none;
    color: #212529;
}
.snm-icon a:hover{
    filter:drop-shadow(0px 0px 20px #ffffff);
}
.snm-icon a:hover p{
    color: #b55;
}
.snm-icon:hover{
    transition:transform 0.1s linear;
    transform: scale(1.1);
}
#div_sieunguoimay_menu, #span_display_panel{
    transition:opacity 0.3s linear;
}
</style>
<div class="container-fluid p-0" id="div_sieunguoimay_menu">
    <div class="row p-0 m-0" >
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center snm-icon">
            <a href="#" class="sieunguoimay" id="a_sieunguoimay_github">
                <div>
                <i class="fab fa-github-square"></i> 
                <p>Projects</p>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center snm-icon">
            <a href="#" class="sieunguoimay" id="a_sieunguoimay_facebook">
                <div>
                    <i class="fab fa-facebook-square"></i>
                    <p>Profile</p>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center snm-icon">
            <a href="#" class="sieunguoimay" id="a_sieunguoimay_youtube">
                <i class="fab fa-youtube "></i> 
                <p>Channel</p>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center snm-icon">
            <a href="#" class="sieunguoimay" id="a_sieunguoimay_about_me">
                <img src="/assets/icons/profile_sieunguoimay.png"/>
                <p>About Me</p>
            </a>
        </div>
    </div>
</div>

<span id="span_display_panel"></span>

<script>
var snmMenu = document.getElementById('div_sieunguoimay_menu');
var spanLoading = document.getElementById('span_loading');

var fetching = false;

$('.sieunguoimay').on('click',function(){
    hideElement(snmMenu,function(){
        if($('#spinner').is(':hidden')&&fetching){
            $('#span_loading').show();
            $('#spinner').show();
            if(!$('#something_went_wrong').is(':hidden'))
                $('#something_went_wrong').hide();
        }
    });
    fetching = true;
    var data = {name:$(this).attr('id'),displayName:$(this).text()};
    ClientDataCollector.postRequest('/menu',data,function(response){
            console.log(response);
            if(response.status="OK"){

                var html = $("<div>"+response.html+"</div>").hide();
                $('#span_display_panel').html(html)
                html.fadeIn('slow');

                if(!$('#span_loading').is(':hidden'))
                    $('#span_loading').hide();
                fetching = false;
            }
            DirectoryManager.goInto(data.name,data.displayName);
        },function(xhr,status,error){
            if($('#something_went_wrong').is(':hidden'))
                $('#something_went_wrong').show();
            if(!$('#spinner').is(':hidden'))
                $('#spinner').hide();
            fetching = false;
            showElement(snmMenu);
        });
});

</script>