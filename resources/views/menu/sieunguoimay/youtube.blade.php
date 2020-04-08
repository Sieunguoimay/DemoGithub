<style>
@media only screen and (max-width: 750px){
    .youtube-iframe-container{
        width:100%;
        height:0;
        padding-bottom:56.25%
    }
    
}
@media only screen and (min-width: 750px){
    .youtube-iframe-container{
        width:100%;
        height:0;
        padding-bottom:28.125%
    }
}
</style>
<div class="container">
    <div class="row">
        <h4><a href="https://www.youtube.com/channel/UCFAKMz9lrOy0be078UZeOng" style="color:#222">Sieu Nguoi May Channel <i class="fas fa-share" style="font-size:14px;"></i></a></h4>
    </div>
    <div class="row my-2 ">
        <div class="col-md-6 col-sm-12 youtube-iframe-container">   
            <iframe   src="https://www.youtube.com/embed/eZ5So0d1l5E?version=3&rel=0&fs=0&showinfo=0" 
                frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen style="position:absolute;left:0;top:0;width:100%;height:100%">
            </iframe>        
        </div>
        <div class="col-md-6 col-sm-12 py-2">  
            <h6><a style="color:#222" href="https://www.youtube.com/eZ5So0d1l5E"><strong>T</strong>his is my lastest uploaded video on youtube.</a></h6>
        </div>
    </div>
    <div class="row m-2">
        <div class="col-6">
            {{-- <p><a href="https://www.youtube.com/channel/UCFAKMz9lrOy0be078UZeOng">Visit Facebook Profile <i class="fas fa-share" style="font-size:10px"></i></a></p> --}}
            {{-- <h4><a href="https://www.youtube.com/channel/UCFAKMz9lrOy0be078UZeOng" style="color:#222">Sieu Nguoi May Channel <i class="fas fa-share" style="font-size:14px;"></i></a></h4> --}}
        </div>
        <div class="col-6 p-0 text-right">
            <a type="button" data-toggle="collapse" data-target="#div_featured_videos" class="btn_toggle_dropdown">
                Featured videos <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </div>

    <div class="row collapse"  id="div_featured_videos" class="collapse">
<div class="container">

        <div class="row my-2 ">
            <div class="col-md-6 col-sm-12 youtube-iframe-container">   
                <iframe   src="https://www.youtube.com/embed/rJA6_Q-4JIA?version=3&rel=0&fs=0&showinfo=0" 
                    frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen style="position:absolute;left:0;top:0;width:100%;height:100%">
                </iframe>        
            </div>
            <div class="col-md-6 col-sm-12 py-2">  
                <h6><a  style="color:#222" href="https://www.youtube.com/eZ5So0d1l5E"><strong>T</strong>he most-viewed video.</a></h6>        
            </div>
        </div>
    </div>
</div>



</div>

<script>

    $('.btn_toggle_dropdown').on('click',function(){
        var elem = $(this).children().first();
        elem.toggleClass('fa-chevron-down');
        elem.toggleClass('fa-chevron-up');
    });

</script>