<style>
.github-repos p, label{
    margin-bottom: 0px;
}
.github-repos .card a{
    color:#b55;
}
.github-repos .card{
    background-color:#ffffff77;
    border:0;
}
.github-repos .card:hover{
    background-color:#ffffffcc;
}
</style>
<div class="container-fluid github-repos">
    <div class="row mb-3">
        <div class="col-md-3 col-sm-3 col-xs-12 p-0 justify-content-center text-center">
            <img src="{{$userData['avatar_url']}}" style="width:100%; max-width:200px;border-radius:5px"/>
        </div>
        <div class="col-md-9 col-sm-9 col-xs-12 mt-xs-2">
            <h3>Github Profile</h3>
            <p><strong>Display Name:</strong> {{$userData['login']}}</p>
            <p><strong>User Name:</strong> {{$userData['name']}}</p>
            <p><strong>Bio:</strong> {{$userData['bio']}}</p>
            <p><strong>Blog:</strong> <a href="{{$userData['blog']}}">{{$userData['blog']}}</a></p>
            <div class="row">
                <div class="col-6">
                    <p><a href="https://github.com/sieunguoimay">Visit Github <i class="fas fa-share" style="font-size:10px"></i></a></p>
                </div>
                <div class="col-6 p-0 text-right">
                    <a type="button" data-toggle="collapse" data-target="#div_repos" class="btn_toggle_dropdown">
                        Repositories <i class="fas fa-chevron-down"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row collapse"  id="div_repos" class="collapse">
        <div class="col m-0 p-0">
            @foreach($reposData as $repo)
            <div class="col-12  m-0 p-0">
                <div class="card mb-2 m-0">
                    <div class="card-title px-3 pt-4 mb-0">
                        <h4><a href="{{$repo['html_url']}}">{{$repo['name']}}</a></h4>
                    </div>
                    <div class="card-body m-0 pt-0">

                        @if($repo['description']!=null)
                            <p><strong>Description: </strong> {{$repo['description']}}</p>
                        @endif
                        <p style="text-overflow:ellipsis;overflow: hidden;"><label>Clone URL: <label> <a href="{{$repo['clone_url']}}">{{$repo['clone_url']}}</a></p>
                        <p><label>Created at: <label> {{$repo['created_at']}}</p>
                        <p><label>Pushed at: <label> {{$repo['pushed_at']}}</p>
                        <p><label>Default branch: <label> {{$repo['default_branch']}}</p>
                        <p><label>Size: <label> {{$repo['size']}}kB</p>
                        <p><label>Language : <label> {{$repo['language']}}</p>
                    </div>
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