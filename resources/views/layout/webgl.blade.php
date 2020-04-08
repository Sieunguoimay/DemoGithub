@extends('layout.mainlayout')

@section('style')
<style>
.wrapper{
    position: relative;    
}
canvas.big-canvas{
    display: block;  /* prevents scrollbar */
    width: 100%;
    height: 100vh;

}
#front-html{
    position: absolute;
    top:0;
}

</style>
@yield('style2')

@endsection

@section('content')
<div class="wrapper">
    <div class="row overflow-auto m-0 p-0">
        <div class="col overflow-auto m-0 p-0">
            <canvas id="webgl_canvas" class="big-canvas">Sorry! Your browser suck.</canvas>
        </div>
    </div>
    <div id="front-html" class="container-fluid">
        @yield('content2')
    </div>
</div>
@endsection

@section('script')

{{-- Load all shaders and place them here.--}}
@foreach($shaders as $shader)
<span id='{{$shader["name"]}}' style="display:none;">{{$shader['content']}}</span>
@endforeach

<script src="{{ URL::asset('js/gl-matrix.js') }}"></script>
<script src="{{ URL::asset('js/utils.js') }}"></script>
<script src="{{ URL::asset('js/shader.js') }}"></script>
<script src="{{ URL::asset('js/lib/webgl-obj-loader.min.js') }}"></script>
<script src="{{ URL::asset('js/Loaders.js') }}"></script>
<script src="{{ URL::asset('js/GraphicsManager.js') }}"></script>
<script src="{{ URL::asset('js/main.js') }}"></script>

@yield('script2')

@endsection
