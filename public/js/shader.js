var Shader = {
    initShaderProgram:function(gl, vsSource, fsSource) {
        this.gl = gl;
        const vertexShader = this.loadShader(gl, gl.VERTEX_SHADER, vsSource);
        const fragmentShader = this.loadShader(gl, gl.FRAGMENT_SHADER, fsSource);

        // Create the shader program

        const shaderProgram = gl.createProgram();
        gl.attachShader(shaderProgram, vertexShader);
        gl.attachShader(shaderProgram, fragmentShader);
        gl.linkProgram(shaderProgram);

        // If creating the shader program failed, alert

        if (!gl.getProgramParameter(shaderProgram, gl.LINK_STATUS)) {
            alert('Unable to initialize the shader program: ' + gl.getProgramInfoLog(shaderProgram));
            return null;
        }
        return shaderProgram;
    },
    //
    // creates a shader of the given type, uploads the source and
    // compiles it.
    //
    loadShader:function (gl, type, source) {
        const shader = gl.createShader(type);
        // Send the source to the shader object
        gl.shaderSource(shader, source);
        // Compile the shader program
        gl.compileShader(shader);
        // See if it compiled successfully
        if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
            alert('An error occurred compiling the shaders: ' + gl.getShaderInfoLog(shader));
            gl.deleteShader(shader);
            return null;
        }
        return shader;
    }
    ,CreatePhongLightingShader:function(gl,vs,fs){
        const shaderProgram = this.initShaderProgram(gl,Utils.getShader(vs),Utils.getShader(fs));
        const shader = {
            program: shaderProgram,
            attribLocations: {
                posLoc: this.gl.getAttribLocation(shaderProgram, 'aPos'),
                uvLoc: this.gl.getAttribLocation(shaderProgram, 'aUv'),
                normLoc: this.gl.getAttribLocation(shaderProgram, 'aNorm'),
            },
            uniformLocations: {
                projMatrixLoc: this.gl.getUniformLocation(shaderProgram, 'uProj'),
                modelMatrixLoc: this.gl.getUniformLocation(shaderProgram, 'uModel'),
                viewMatrixLoc: this.gl.getUniformLocation(shaderProgram, 'uView'),
                texture0Loc: this.gl.getUniformLocation(shaderProgram, 'texture0'),
            },
        };
        return shader;
    }
};
