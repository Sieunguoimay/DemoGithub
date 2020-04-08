var Utils = {
    include:function(file) { 
  
        var script  = document.createElement('script'); 
        script.src  = file;
        script.type = 'text/javascript'; 
        script.defer = true; 
        
        document.getElementById('scripts-placeholder').appendChild(script); 
    },
    getShader:function(file){
        console.log(file);
        return document.getElementById(file).innerHTML; 
    }
    // Read a file
    ,readFile(fileName,callback) {
        var request = new XMLHttpRequest();
        
        request.onreadystatechange = function() {
            if (request.readyState === 4 && request.status !== 404) {
                callback(request.responseText,fileName);
            }
        }
        request.open('GET', fileName, true); // Create a request to get file
        request.send(); // Send the request
    },
    
}
