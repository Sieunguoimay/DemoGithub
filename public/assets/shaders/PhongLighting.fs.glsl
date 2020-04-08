#version 100
precision mediump float;
uniform sampler2D texture0;
varying vec2 fsUv;
varying vec3 fsPos;
varying vec3 fsNorm;
uniform mat4 uView; //4x16

vec3 nNormal, nEyeCoord,lightDir, nLightVec, V,R,ambient,diffuse,specular;
float sIntensity,cosAngle;
float ambientStrength = 0.47;
float diffuseStrength = 0.5;
float specularStrength = 0.2;
vec3 PhongShading(int index,vec3 norm);

vec3 u_lightPos[1];
vec3 u_lightCoefficients[1];
vec4 u_lightColor[1];
float u_lightNum = 1.0;

void main() {
    u_lightPos[0]= vec3(0.0,1.0,1.0);
    u_lightCoefficients[0]= vec3(0.65, 0.09, 0.032);
    //u_lightColor[0]= vec4(1.0,1.0,1.0,1.0);
    u_lightColor[0]= vec4(0.984,0.85,0.752,1.0);

    vec4 textureColor = texture2D(texture0,fsUv);
    vec3 normal = fsNorm;

    gl_FragColor = textureColor;//vec4(textureColor, 1.0);

    vec3 multipleLightColor = vec3(0.0);
    //Phong Shading
    multipleLightColor=PhongShading(0,normal);
    gl_FragColor = gl_FragColor*vec4(multipleLightColor,1.0);
}


vec3 PhongShading(int index,vec3 norm){


    //directional light
    //nLightVec = u_lightPos[0];//normalized
    //nLightVec = normalize(u_lightPos[0]-fsPos)*fsTangentSpace;
    //point light u_lightPos[0]
	lightDir = vec3(uView*vec4(u_lightPos[0],1.0))-fsPos;

    nLightVec = normalize(lightDir);
    nNormal = normalize(norm);
    nEyeCoord = normalize(fsPos);

    vec3 lightColor = vec3(u_lightColor[0]);
    float shininess = u_lightColor[0].w;

    //diffuse intensity
    cosAngle = max(dot(nNormal,nLightVec),0.0);

    //specular intensity
    V = -nEyeCoord;
    R = reflect(-nLightVec,nNormal);
    sIntensity = pow(max(dot(R,V),0.0),shininess);

    ambient = ambientStrength*lightColor;
    diffuse = cosAngle*diffuseStrength*lightColor;
    specular = sIntensity*specularStrength*lightColor;

	//attenuation
	float distance	= length(lightDir);
	float constant	= u_lightCoefficients[0].x;
	float linear	= u_lightCoefficients[0].y;
	float quadratic = u_lightCoefficients[0].z;
	float attenuation = 1.0/(constant+linear*distance+quadratic*distance*distance);

    return (ambient+diffuse+specular);//*attenuation;
}

