<div class="container-fluid">
    <div class="row">
        <div class="col-4" style="display: flex;align-items: center;flex-wrap: wrap;">
            <a href="#" id="a_profile_image"><img src="/assets/icons/profile_sieunguoimay.png" style="width:100%"/></a>
        </div>
        <div class="col 12">
            <p style="text-align:justify;">
            I'm definitely a game programmer. 
            But I can also play on the field of other programming languages such as Web, Android, 
            Arduino, etc. I believe that the only thing that prevents a programmer from knowing 
            a technology is time. Luckily I have been a college student for 5 years instead of 4.
            That's a lot of spare time to spend on variety of cool things.
            </p>

        </div>
    </div>
    <div class="row">
        <p>That's much I can talk about me. Thank you for reading.
        <a data-toggle="collapse" href="#collapseExample" 
            role="button" aria-expanded="false" aria-controls="collapseExample">
            Want to read more?</a>
        <span class="collapse" id="collapseExample"> You don't.</span>
        </p>
    </div>
</div>
<script>
$('#a_profile_image').on('click',function(e){
    if(!$(this).hasClass('animation-rotate'))
        $(this).toggleClass('animation-rotate');
}).on('animationend',function(){
    if($(this).hasClass('animation-rotate'))
        $(this).toggleClass('animation-rotate');
});
</script>