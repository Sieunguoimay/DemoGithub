

function main(OnReady){
    var canvas = document.getElementById('webgl_canvas');

    if(!$('#webgl_canvas').hasClass('visuallyhidden'))
        $('#webgl_canvas').toggleClass('visuallyhidden');
    // canvas.style.opacity = 0;
    canvas.addEventListener('mousedown',function(e){
        GraphicsManager.OnMouseDown(e.clientX,e.clientY);
    });
    var gl = canvas.getContext("webgl");
    if(!gl){
        console.log('Failed to get the rendering context for WebGL');
        return;
    }

    GraphicsManager.Init(gl,function(){
        // canvas.style.opacity = 1;
        if(!$('#webgl_canvas').hasClass('visuallyvisible'))
            $('#webgl_canvas').toggleClass('visuallyvisible');

        if($('#webgl_canvas').hasClass('visuallyhidden'))
            $('#webgl_canvas').toggleClass('visuallyhidden');

        OnReady();
    });
    window.requestAnimationFrame(step);
}

var BackgroundPlayer = {
    paused:false,
    pause(){
        this.paused = true;
    },
    continue(){
        if(this.paused){
            this.paused = false;
            window.requestAnimationFrame(step);    
        }
    },
    Init(OnReady){
        main(OnReady)
    }

};

var startTime = null;
function step(currentTime){
    if (!startTime) startTime = currentTime;
    var deltaTime = currentTime - startTime;

    resize();

    GraphicsManager.Update(deltaTime);
    GraphicsManager.Render();

    if(!BackgroundPlayer.paused)
        window.requestAnimationFrame(step);
}


function resize() {
    var canvas = GraphicsManager.gl.canvas;
    // Lookup the size the browser is displaying the canvas.
    var displayWidth  = canvas.clientWidth;
    var displayHeight = canvas.clientHeight;

    // Check if the canvas is not the same size.
    if (canvas.width  !== displayWidth ||
        canvas.height !== displayHeight) {

        // Make the canvas the same size
        canvas.width  = displayWidth;
        canvas.height = displayHeight;

        GraphicsManager.OnCanvasResize(displayWidth,displayHeight);
    }
}




