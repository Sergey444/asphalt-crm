$(document).ready(function () {
    $('[data-name="status"]').on('change', function(evt) {
        
        $(this).prop("disabled", true);
        $.ajax({
            type: "post",
            url: "/order/change-status",
            data: "id=" + $(this).data('id'),
            success: function(msg){
                if (!msg) {
                    $(evt.target).prop('checked', !$(evt.target).prop('checked'));
                    alert('Произошла ошибка изменения статуса, попробуйте ещё раз или обратитесь к администратору')
                }
                $(evt.target).prop("disabled", false);
            }
        });
    });
});