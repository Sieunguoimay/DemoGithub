var OBJLoader = {
loadObj(gl,filename,callback) {

    var mesh = {
        vbo: 0,
        ebo: 0,
        vertexCount: 0,
        indexCount: 0,
        loaded:false,
        vertices:[],
        indices:[],
        filename:filename
    };

    Utils.readFile(filename,function(data){
        OBJLoader.onReadOBJFile(gl,data,mesh);
        
        mesh.vbo = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, mesh.vbo);
        gl.bufferData(gl.ARRAY_BUFFER,new Float32Array(mesh.vertices), gl.STATIC_DRAW);

        mesh.ebo = gl.createBuffer();
        gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, mesh.ebo);
        gl.bufferData(gl.ELEMENT_ARRAY_BUFFER,new Uint16Array(mesh.indices), gl.STATIC_DRAW);
        
        mesh.loaded = true;

        // console.log(mesh);
        callback();
    });

    return mesh;
},

// OBJ file has been read
onReadOBJFile(gl,fileString,mesh) {
    var _mesh = new OBJ.Mesh(fileString);
    OBJ.initMeshBuffers(gl, _mesh);
    mesh.vertexCount = _mesh.vertices.length/3;
    mesh.indexCount = _mesh.indices.length;
    mesh.indices = _mesh.indices;
    for(var i = 0; i<mesh.vertexCount; i++){
        mesh.vertices.push(_mesh.vertices[i*3]);
        mesh.vertices.push(_mesh.vertices[i*3+1]);
        mesh.vertices.push(_mesh.vertices[i*3+2]);

        mesh.vertices.push(_mesh.textures[i*2]);
        mesh.vertices.push(_mesh.textures[i*2+1]);

        mesh.vertices.push(_mesh.vertexNormals[i*3]);
        mesh.vertices.push(_mesh.vertexNormals[i*3+1]);
        mesh.vertices.push(_mesh.vertexNormals[i*3+2]);
    }
} 
};


    
var TextureLoader = {
    loadTexture(gl, url,callback) {
        const texture = {
            textureId:gl.createTexture(),
            width:0,
            height:0,
            loaded:false
        }
        gl.bindTexture(gl.TEXTURE_2D, texture.textureId);

        // Because images have to be download over the internet
        // they might take a moment until they are ready.
        // Until then put a single pixel in the texture so we can
        // use it immediately. When the image has finished downloading
        // we'll update the texture with the contents of the image.
        const level = 0;
        const internalFormat = gl.RGBA;
        const width = 1;
        const height = 1;
        const border = 0;
        const srcFormat = gl.RGBA;
        const srcType = gl.UNSIGNED_BYTE;
        const pixel = new Uint8Array([255, 255, 255, 255]);  // opaque blue
        gl.texImage2D(gl.TEXTURE_2D, level, internalFormat,
                        width, height, border, srcFormat, srcType,
                        pixel);

        const image = new Image();
        image.onload = function() {

            gl.bindTexture(gl.TEXTURE_2D, texture.textureId);
            gl.texImage2D(gl.TEXTURE_2D, level, internalFormat,
                        srcFormat, srcType, image);

            // WebGL1 has different requirements for power of 2 images
            // vs non power of 2 images so check if the image is a
            // power of 2 in both dimensions.
            if (TextureLoader.isPowerOf2(image.width) && TextureLoader.isPowerOf2(image.height)) {
                // Yes, it's a power of 2. Generate mips.
                gl.generateMipmap(gl.TEXTURE_2D);
            } else {
                // No, it's not a power of 2. Turn off mips and set
                // wrapping to clamp to edge
                gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
                gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
                gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
            }
            texture.width = image.width;
            texture.height = image.height;
            texture.loaded = true;
            callback();
        };
        image.src = url;

        return texture;
    }
    ,createTexture(gl, width,height,pixel) {
        const texture = {
            textureId:gl.createTexture(),
            width:0,
            height:0,
            loaded:false
        }
        gl.bindTexture(gl.TEXTURE_2D, texture.textureId);

        // Because images have to be download over the internet
        // they might take a moment until they are ready.
        // Until then put a single pixel in the texture so we can
        // use it immediately. When the image has finished downloading
        // we'll update the texture with the contents of the image.
        const level = 0;
        const internalFormat = gl.RGBA;
         width = 1;
         height = 1;
        const border = 0;
        const srcFormat = gl.RGBA;
        const srcType = gl.UNSIGNED_BYTE;
        if(pixel==null)
            pixel = new Uint8Array([255, 255, 255, 255]);  // opaque blue
        gl.bindTexture(gl.TEXTURE_2D, texture.textureId);
        gl.texImage2D(gl.TEXTURE_2D, level, internalFormat,
                        width, height, border, srcFormat, srcType,
                        pixel);
        gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
        gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
        gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
        texture.width = width;
        texture.height = height;
        texture.loaded = true;

        return texture;
    }
    ,isPowerOf2:function(value) {
        return (value & (value - 1)) == 0;
    }

};