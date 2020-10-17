window.initPlusMinusBox = function () {
    /*----------------------------
    	Cart Plus Minus Button
    ------------------------------ */
    var CartPlusMinus = $('.cart-plus-minus');
    CartPlusMinus.prepend('<div class="dec qtybutton">-</div>');
    CartPlusMinus.append('<div class="inc qtybutton">+</div>');
    $(".qtybutton").on("click", function () {
        var newVal;
        var $button = $(this);
        var oldValue = parseFloat( $button.parent().find("input").val() );

        // console.log($button.text() === "+" ? "increment" : "decrement")
        // Don't allow decrementing to zero
        if ($button.text() === "+") {
             newVal = oldValue + 1;
             if (newVal < 1) newVal = 1;
        }
        else
            newVal = oldValue > 1 ? oldValue - 1 : 1;

        $button.parent().find("input").val(newVal).trigger("change")//.request();
    });
};

(function ($) {
    initPlusMinusBox();
})(jQuery);
