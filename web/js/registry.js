$(document).ready(function() {

    $('body').on('click', '#registry', function(evt) {

        var param = $('meta[name="csrf-param"]').attr("content");
        var token = $('meta[name="csrf-token"]').attr("content");
        var partner = $('[name="partner"]').val();

        if (!partner) {
            return alert('Необходимо выбрать партнёра.');
        }

        var mapForm = $('#filter-form').clone()[0];
            mapForm.target = "create";
            mapForm.method = "POST";
            mapForm.action = "/report/create-pdf-report";
            mapForm.partner.value = partner;

        var mapInput = document.createElement("input");
            mapInput.name = param;
            mapInput.value = token;

            mapForm.appendChild(mapInput);
    
            document.body.appendChild(mapForm);
    
            map = window.open("", "create", "status=0,title=0,height=600,width=800,scrollbars=1");
    
        if (map) {
            mapForm.submit();
        } else {
            alert('Для правильной работы необходимо разрешить всплывающие окна.');
        }
        document.body.removeChild(mapForm);
    });
});