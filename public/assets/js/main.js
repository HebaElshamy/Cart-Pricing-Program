(function ($) {
    // Counter to track the number of added rows
    // Function to add a new table row when a product is selected
    function addTableRow(productId, productName,stock,price,qty) {
        const tableRow = `<tr>
                <td class="text-center"><div><p style="line-height: 3;" product_id=${productId}>${productName}</p></div></td>
                <td class="text-center"><div><p style="line-height: 3;">${price}</p></div></td>

                <td class="text-center">
                    <div class="quantity text-center">
                        <div class="pro-qty text-center">
                            <span class="dec qtybtn up">-</span>
                            <input type="number" value="1" max="${stock}" onkeydown="return false" product_id=${productId} >
                            <span class="inc qtybtn up">+</span>
                        </div>
                    </div>
                </td>

                <td class="text-center remove-row" style="line-height: 3; cursor: pointer;" product_id=${productId} product_name="${productName}">✕</td>
            </tr>`;
        $('#tableBody').append(tableRow);
    }
    // Function to enable a product option in the select input
    function enableProductOption(productName) {
        $('#inputGroupSelect01 option:contains(' + productName + ')').prop('disabled', false);
    }
    // Function to update the value of the select input
    function updateSelect() {
        $('#inputGroupSelect01').val('').find('option').prop('selected', false);
        $('#inputGroupSelect01 option:first').prop('selected', true).prop('disabled', false);
    }
    // Event handler for the change event on the select input
    $('#inputGroupSelect01').on('change', function () {
        const productId = $(this).val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $(this).find('option:selected').prop('disabled', true);
        const productName = $('option:selected', this).attr('product_name');
        const stock = $('option:selected', this).attr('stock');
        const price= $('option:selected', this).attr('price');
        console.log(price);
        addTableRow(productId, productName,stock,price,1);
        updateSelect();
        callAjaxToADD(csrfToken,productId,1);
    });

    // Event handler for quantity buttons within the table
    $('#tableBody').on('click', '.qtybtn', function () {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        const $button = $(this);
        const oldValue = $button.siblings('input').val();
        const mx_stock = parseInt($button.siblings('input').attr('max'), 10);
        const productId = $button.siblings('input').attr('product_id');
        let newVal = oldValue;

        if ($button.hasClass('inc') && oldValue < mx_stock) {
            newVal = parseFloat(oldValue) + 1;
        } else if ($button.hasClass('dec') && oldValue > 1) {
            newVal = parseFloat(oldValue) - 1;
        }
        $button.siblings('input').val(newVal);
        callAjaxToADD(csrfToken,productId,newVal);
        if(newVal == mx_stock){
            alert('Max Stock');
        }
    });
    function callAjaxToADD(csrfToken,productId,newVal){
        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                _token: csrfToken,
                product_id: productId,
                quantity: newVal
            },
            success: function(response) {
                $('.qtyTotal').html(response.totalQuantity);
                var total = response.total
                AddTotal(total)

            },
            error: function(error) {

                alert('FAILED');
            }
        });
    }
    $('#tableBody').on('click', '.remove-row', function () {
        const productName = $(this).attr('product_name');
        const productId = $(this).attr('product_id');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        callAjaxToDelete(csrfToken, productId, productName);
    });

    function callAjaxToDelete(csrfToken, productId, productName) {

        $.ajax({
            type: 'POST',
            url: '/cart/remove/' + productId,
            data: {
                _token: csrfToken,
            },
            success: function(response) {
                $('.qtyTotal').html(response.totalQuantity);
                enableProductOption(productName);
                updateSelect();
                $('.remove-row[product_id="' + productId + '"]').closest('tr').remove();
                $('.qtyTotal').html(response.totalQuantity);
                var total = response.total
                AddTotal(total)


            },
            error: function(error) {
                alert('FAILED');
            }
        });
    }
    function AddTotal(total){
        $('.shipping').html('$ '+parseFloat(total.shipping).toFixed(3));
        $('.subtotal').html('$ '+parseFloat(total.subtotal).toFixed(3));
        $('.vat').html('$ '+parseFloat(total.vat).toFixed(3));
        $('.total').html('$ '+parseFloat(total.total).toFixed(3));
        var discounts=total.discounts;
        var divDiscount="";
        for (var key in discounts) {
            if (discounts.hasOwnProperty(key)) {
                if(key=='total')
                {continue;}
                divDiscount +=`
                <div class="row">
                <div class="col ">${key }</div>
                <div class="col text-right">- $ ${parseFloat(discounts[key]).toFixed(3)}</div>
            </div>
                `;
            }
        }
        $('#discounts').html(divDiscount);
    }
})(jQuery);
