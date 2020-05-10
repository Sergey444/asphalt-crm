$(document).ready(function () {

    /**
     * Counts sum of count and price
     * @param {string}
     */
    var Calculate = function ($attr) {

        this.form = $($attr);
        this.count = $(this.form).find('[data-name="count"]');
        this.price = $(this.form).find('[data-name="price"]');
        this.sum = $(this.form).find('[data-name="sum"]');

        var self = this;

        $(this.count).on('input', function (evt) {
            self.setSum();
        });

        $(this.price).on('input', function (evt) {
            self.setSum();
        });
    }

    Calculate.prototype.setSum = function () {
        var sum = $(this.price).val() * $(this.count).val();
        return $(this.sum).val(sum.toFixed(2));
    }

    new Calculate('[data-name="count-form"]');
});