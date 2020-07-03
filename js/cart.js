window.onload = function() {
    var cartSubtotal =  document.getElementsByClassName('cart-subtotal');

      var textDisplay;
      var min_amount = parseInt(delivery.sum);

    if ( cartSubtotal.length != 0 ) {

        var cartSubtotalText = cartSubtotal[0].getElementsByClassName('woocommerce-Price-amount')[0].innerText;
        var cartSubtotalNumb = parseInt(cartSubtotal[0].getElementsByClassName('woocommerce-Price-amount')[0].innerText.replace(/,/g,''));

        var childElem = document.getElementsByClassName("woocommerce-notices-wrapper");

        displayTextShippinf(min_amount);

    }
    jQuery( document.body ).on( 'updated_cart_totals', function() {
        cartSubtotalNumb = parseInt(cartSubtotal[0].getElementsByClassName('woocommerce-Price-amount')[0].innerText.replace(/,/g,''));

        displayTextShippinf(min_amount);

    });


    if ( document.getElementsByName('update_cart').length != 0 ) {
        var button = document.getElementsByName('update_cart')[0];
        button.onclick = function(){

        };
    }

    function displayTextShippinf(min_amount) {
        if ( cartSubtotalNumb < min_amount ) {
            var leftMoney = min_amount - cartSubtotalNumb;
            textDisplay = "<h4 class=\'free-shipping-notice\'>До бесплатной доставки осталось " + leftMoney + ' грн</h4>';
            childElem[0].innerHTML = textDisplay;
        } else {
            textDisplay = "<h4 class=\'free-shipping-notice success-ship\'>Бесплатная доставка</h4>";
            childElem[0].innerHTML = textDisplay;

        }
    }

};
