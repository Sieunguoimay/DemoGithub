var Instance = function(pos,scale,rotation,angle){
    this.position = pos;
    this.scale = scale;
    this.rotation = rotation;
    this.angle = angle;
    this.updateMatrix();
}
Instance.prototype.updateMatrix = function(){
    this.transformation = mat4.create();
    mat4.translate(this.transformation,this.transformation,this.position);
    mat4.rotate(this.transformation,this.transformation,this.angle,this.rotation);
    mat4.scale(this.transformation,this.transformation,this.scale);
}

var GraphicsManager ={

    Init:function(gl,callback){
        this.gl = gl;
        this.callback = callback;
        this.getRequestCount = 0;
        console.log("GraphicsManager::Init");
        this.PhongLightingShader = Shader.CreatePhongLightingShader(gl,'PhongLighting.vs.glsl','PhongLighting.fs.glsl');
        this.mesh = OBJLoader.loadObj(gl,'/assets/models/suzan2.obj',this.GetRequestCallback);
        this.getRequestCount++;
        // this.meshSuzan = OBJLoader.loadObj(gl,'/assets/models/suzan2.obj');
        // console.log(this.mesh);
        // this.texture = TextureLoader.loadTexture(gl,'/assets/textures/demo.png');
        // this.getRequestCount++;
        this.texture = TextureLoader.createTexture(gl,1,1);
        this.instances = [
            new Instance([1.5,-1.3,-2.0],[1.0,1.0,1.0],[0.0,1.0,0.0],0.0),
            new Instance([-3.0,2.0,-5.0],[1.0,1.0,1.0],[0.0,1.0,0.0],0.0),
            new Instance([3.0,2.0,-10.0],[1.0,1.0,1.0],[0.0,1.0,0.0],0.0),
            new Instance([-2.0,-2.0,-15.0],[1.0,1.0,1.0],[0.0,1.0,0.0],0.0),
            new Instance([-9.0,-7.0,-25.0],[1.0,1.0,1.0],[0.0,1.0,0.0],0.0),
            new Instance([-9.0,10.0,-45.0],[1.0,1.0,1.0],[0.0,1.0,0.0],0.0),
            new Instance([15.0,1.0,-40.0],[2.0,2.0,2.0],[0.0,1.0,0.0],0.0),
        ];
        for(var i = 0; i<this.instances.length; i++)
            this.instances[i].angle = Math.random()*3.1415*2;

        this.camera = {
            projectionMatrix:mat4.create(),
            viewMatrix:mat4.create()
        };

    }
    ,OnCanvasResize(w,h){
        const fieldOfView = 45 * Math.PI / 180;   // in radians
        const aspect = this.gl.canvas.clientWidth/ this.gl.canvas.clientHeight;//w /h;//
        const zNear = 0.1;
        const zFar = 100.0;
        mat4.perspective(this.camera.projectionMatrix,fieldOfView,aspect,zNear,zFar);
    }
    ,Update(deltaTime){
        // if( typeof angle == 'undefined' ) {angle = 0.0;}
        // if(angle>2*3.1415)angle = 0.0;
        // angle+=0.01;
        for(var i = 0; i<this.instances.length; i++)
        {
            if(this.instances[i].angle>2*3.1415) this.instances[i].angle = 0.0;
            this.instances[i].angle += 0.001;
            this.instances[i].updateMatrix();
    
        }
    }
    ,Render(){
        
        this.gl.viewport(0.0,0.0,this.gl.canvas.width, this.gl.canvas.height);
        this.gl.clearColor(1.0, 1.0, 1.0, 1.0);  // Clear to black, fully opaque
        this.gl.clearDepth(1.0);                 // Clear everything
        this.gl.enable(this.gl.DEPTH_TEST);           // Enable depth testing
        this.gl.depthFunc(this.gl.LEQUAL);            // Near things obscure far things
        // Clear the canvas before we start drawing on it.
        this.gl.clear(this.gl.COLOR_BUFFER_BIT);//|gl.DEPTH_BUFFER_BIT|gl.STENCIL_BUFFER_BIT


        for(var i = 0; i<this.instances.length; i++)
            this.render(this.gl,this.PhongLightingShader,this.mesh,this.texture,this.instances[i],this.camera);
        // this.render(this.gl,this.PhongLightingShader,this.meshSuzan,this.texture,this.instances[this.instances.length-1],this.camera);
    }
    ,render:function(gl,shader,mesh,texture,instance,camera){




        // Tell WebGL how to pull out the positions from the position
        // buffer into the vertexPosition attribute.
        {
            // pull out 2 values per iteration
            // the data in the buffer is 32bit floats
            // don't normalize
            // how many bytes to get from one set of values to the next
            // 0 = use type and numComponents above
            // how many bytes inside the buffer to start from
            if(!mesh.loaded) return;
            gl.bindBuffer(gl.ARRAY_BUFFER, mesh.vbo);
            gl.vertexAttribPointer(shader.attribLocations.posLoc,3,gl.FLOAT,false,32,0);
            gl.enableVertexAttribArray(shader.attribLocations.posLoc);
            gl.vertexAttribPointer(shader.attribLocations.uvLoc,2,gl.FLOAT,false,32,12);
            gl.enableVertexAttribArray(shader.attribLocations.uvLoc);
            gl.vertexAttribPointer(shader.attribLocations.normLoc,3,gl.FLOAT,false,32,20);
            gl.enableVertexAttribArray(shader.attribLocations.normLoc);
            gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, mesh.ebo);
        }
        // Tell WebGL to use our program when drawing
        gl.useProgram(shader.program);

        if(texture.loaded){
            // Tell WebGL we want to affect texture unit 0
            gl.activeTexture(gl.TEXTURE0);
            // Bind the texture to texture unit 0
            gl.bindTexture(gl.TEXTURE_2D, texture.textureId);
            // Tell the shader we bound the texture to texture unit 0
            gl.uniform1i(shader.uniformLocations.texture0Loc, 0);
        }

    
        // Set the shader uniforms
        gl.uniformMatrix4fv(shader.uniformLocations.projMatrixLoc,false,this.camera.projectionMatrix);
        gl.uniformMatrix4fv(shader.uniformLocations.viewMatrixLoc,false,this.camera.viewMatrix);
        gl.uniformMatrix4fv(shader.uniformLocations.modelMatrixLoc,false,instance.transformation);
    
        // gl.drawArrays(gl.TRIANGLE_STRIP, 0, buffers.vertexCount);
        gl.drawElements(gl.TRIANGLES, mesh.indexCount, gl.UNSIGNED_SHORT, 0);
    }
    ,GetRequestCallback(){
        if(GraphicsManager.getRequestCount>0){
            GraphicsManager.getRequestCount--;
        }
        if(GraphicsManager.getRequestCount==0){
            GraphicsManager.callback();
            GraphicsManager.getRequestCount = -1;
        }
    }
};