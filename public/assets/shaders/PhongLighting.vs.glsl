#version 100
precision mediump float;
attribute vec3 aPos;
attribute vec2 aUv;
attribute vec3 aNorm;

uniform mat4 uModel;
uniform mat4 uView;
uniform mat4 uProj;

varying vec2 fsUv;
varying vec3 fsNorm;
varying vec3 fsPos;

void main() {
    gl_Position = uProj * uView* uModel * vec4(aPos,1.0);
    fsUv = aUv;
    mat4 modelView = uView* uModel;
    mat4 normalMatrix = mat4(modelView[0],modelView[1],modelView[2],modelView[3]);
    fsNorm = normalize(mat3(normalMatrix)*aNorm);
}