function validateUploadModel() {
    let form = document.forms["upload_model"];
    let modelFile = form["model_file"];
    let filename = modelFile.files[0].name;
    if(filename.substr(filename.lastIndexOf('.') + 1, filename.length) != "obj") {
        alert('model file only supports .obj format.');
        return false;
    }
    return true;
}

document.forms["upload_model"].onsubmit = validateUploadModel;