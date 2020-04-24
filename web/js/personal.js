$("#add-photo-input").change(function() {
    var urlCreator = window.URL || window.webkitURL;
    var imageUrl = urlCreator.createObjectURL(this.files[0]);
    document.querySelector("#img-preview").src = imageUrl;
});