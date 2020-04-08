<style>
.facebook-profile p, label{
    margin-bottom: 0px;
}
</style>
<div class="container facebook-profile">

    <div class="row mb-3">
        <div class="col-md-3 col-sm-3 col-xs-12 p-0 justify-content-center text-center">
            <img src="{{$fbAccount['picture']['data']['url']}}" style="width:100%; max-width:200px; border-radius:5px"/>
        </div>
        <div class="col-md-9 col-sm-9 col-xs-12 mt-xs-2">
            <h3>Facebook Profile</h3>
            <p><strong>User Name:</strong> {{$fbAccount['name']}}</p>
            <p><strong>User Id:</strong> {{$fbAccount['id']}}</p>
            <p><strong>Email:</strong> {{$fbAccount['email']}}</p>
            @isset($fbAccount['birthday'])
            <p><strong>Birthday:</strong> {{$fbAccount['birthday']}}</p>
            @endisset
            @isset($fbAccount['birthday'])
            <p><strong>Hometown:</strong> {{$fbAccount['hometown']['name']}}</p>
            @endisset
            <div class="row mt-2">
                <div class="col-6">
                    <p><a href="https://facebook.com/sieunguoimay">Visit Facebook Profile <i class="fas fa-share" style="font-size:10px"></i></a></p>
                </div>
                <div class="col-6 p-0 text-right">
                    <a type="button" data-toggle="collapse" data-target="#div_pages" class="btn_toggle_dropdown">
                        Pages <i class="fas fa-chevron-down"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row collapse"  id="div_pages" class="collapse">
        <div class="container facebook-profile">
            @foreach($fbAccount['accounts']['data'] as $page)
            <div class="row mb-3">
                <div class="col-md-3 col-sm-3 col-xs-12 p-0 justify-content-center text-center">
                    <img src="{{$page['picture']['data']['url']}}" style="width:100%; max-width:200px;border-radius:5px"/>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12 mt-xs-2">
                    <h3>Facebook Page</h3>
                    <p><strong>Page Name:</strong> {{$page['name']}}</p>
                    <p><strong>Page Id:</strong> {{$page['id']}}</p>
                    <p><strong>Category:</strong> {{$page['category']}}</p>
                    @isset($page['birthday'])
                    <p><strong>Birthday:</strong> {{$page['birthday']}}</p>
                    @endisset
    
                    <div class="row mt-2">
                        <div class="col-6">
                            <p><a href="{{$page['link']}}">Visit Facebook Page <i class="fas fa-share" style="font-size:10px"></i></a></p>
                        </div>
                        <div class="col-6 p-0 text-right">
                            <a type="button" data-toggle="collapse" data-target="#div_new_feeds" class="btn_toggle_dropdown">
                                New Feeds <i class="fas fa-chevron-down"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row collapse"  id="div_new_feeds" class="collapse">
                <div class="col m-0 p-0 justify-content-center">
                @foreach($page['feed']['data'] as $feed)

                <div class="card my-2">

                    <div class="container pb-2 px-3 pt-3">
                        <div class="row-12">
                            @if($feed['from']['name']==$page['name'])
                                <img class="mb-2" src="{{$page['picture']['data']['url']}}" style="width:50px; border-radius:25px"/>
                                <div class="ml-1 d-inline-block">
                                    <div>
                                        <a href="{{$page['link']}}"><h6 class="mb-0">{{$page['name']}}</h6></a>
                                        <a class="link-style" href="{{$feed['permalink_url']}}"><small>{{$feed['created_time']}}</small></a>
                                    </div>
                                </div>
                            @else
                            <div class="col-1">
                                <img src="{{$fbAccount['picture']['data']['url']}}" style="width:50px; border-radius:25px"/>
                            </div>
                            <div class="col-10 justify-content-center-col ml-1 d-inline">
                                <div>
                                    <a href="https://facebook.com/sieunguoimay"><h6 class="mb-0">{{$fbAccount['name']}}</h6></a>
                                    <a class="link-style" href="{{$feed['permalink_url']}}"><small>{{$feed['created_time']}}</small></a>
                                </div>
                            </div>
                            @endif
                        </div>

                        @isset($feed['message'])
                        <div class="row-12">
                            <p>{{$feed['message']}}</p>
                        </div>                
                        @endisset
                    </div>

                    @isset($feed['full_picture'])
                    <div class="row-12">
                        <a href="{{$feed['permalink_url']}}" target="_blank"><img src="{{$feed['full_picture']}}" style="width:100%;"/></a>
                    </div>
                    @endisset
                    <div class="card-body text-center p-2 border-top">
                        <button class="transparent-button" style="color:#777;font-weight:bold"><i class="fas fa-share"></i> Share</button>
                    </div>

                </div>


                @endforeach
                </div>
            </div>
            @endforeach
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