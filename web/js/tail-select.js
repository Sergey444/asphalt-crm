var initTail = function () {
    tail.select("#partner-select", { 
        animate: false,
        classNames: 'custom-select-sm',
        locale: "ru",
        search: true,
    });
}


$(document).ready(function(){
    initTail();
    $(document).ajaxSuccess(function() {
         initTail();
     });
});