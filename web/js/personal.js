$(document).ready(function() {
    $("#add-photo-input").change(function() {
        var urlCreator = window.URL || window.webkitURL;
        var imageUrl = urlCreator.createObjectURL(this.files[0]);
        if (imageUrl) {
            var img = $('<img src="'+ imageUrl +'">');
            $("#img-preview").children().replaceWith(img);
        }
    });
});