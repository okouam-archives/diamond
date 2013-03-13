<?php

    $min_buy_prices = array(
        "0" => "£0.00",
        "100000" => "£100,000",
        "200000" => "£200,000",
        "300000" => "£300,000",
        "400000" => "£400,000",
        "500000" => "£500,000",
        "600000" => "£600,000",
        "700000" => "£700,000",
        "800000" => "£800,000",
        "900000" => "£900,000",
        "1000000" => "£1,000,000"
    );

    $postcodes = array(
        "any" => "Any",
        "W1" => "W1"
    );

    $property_types = array(
        "any" => "Any",
        "flat" => "Flat",
        "house" => "House"
    );

    $min_beds = array(
        "0" => "Studio",
        "1" => "1",
        "2" => "2",
        "3" => "3",
        "4" => "4",
        "5" => "5",
    );

    $max_buy_prices = array(
        "0" => "£0.00",
        "100000" => "£100,000",
        "200000" => "£200,000",
        "300000" => "£300,000",
        "400000" => "£400,000",
        "500000" => "£500,000",
        "600000" => "£600,000",
        "700000" => "£700,000",
        "800000" => "£800,000",
        "900000" => "£900,000",
        "1000000" => "£1,000,000"
    );

    $min_rent_prices = array(
        "0" => "£0.00",
        "100" => "£100 pw",
        "200" => "£200 pw",
        "300" => "£300 pw",
        "400" => "£400 pw",
        "500" => "£500 pw",
        "600" => "£600 pw",
        "700" => "£700 pw",
        "800" => "£800 pw",
        "900" => "£900 pw",
        "1000" => "£1,000 pw",
        "1500" => "£1,500 pw",
        "2000" => "£2,000 pw"
    );

    $max_rent_prices = array(
        "0" => "£0.00",
        "100" => "£100 pw",
        "200" => "£200 pw",
        "300" => "£300 pw",
        "400" => "£400 pw",
        "500" => "£500 pw",
        "600" => "£600 pw",
        "700" => "£700 pw",
        "800" => "£800 pw",
        "900" => "£900 pw",
        "1000" => "£1,000 pw",
        "1500" => "£1,500 pw",
        "2000" => "£2,000 pw"
    );

?>

<div class="grid-12">
    <h2>Find your property</h2>
    <form method="get" action="/index.php/search-results">
        <ul class="nav form-fields clearfix">

            <li class="field-wrap">
                <label for="buy-rent">I want to:</label>
                <div class="switch">
                    <input id="buy" name="buy-rent" type="radio" value="buy" checked>
                    <label for="buy" onclick="">Buy</label>

                    <input id="rent" name="buy-rent" value="rent" type="radio">
                    <label for="rent" onclick="">Rent</label>

                    <span class="slide-button"></span>
                </div>
            </li>

            <li class="field-wrap" id="buy-min" name="buy-min">
                <label for="min-price">Min price:</label>
                <select id="min-price" name="min-price" class="select-box">
                </select>
            </li>

            <li class="field-wrap" id="buy-max">
                <label for="max-price">Max price:</label>
                <select id="max-price" name="max-price" class="select-box">
                </select>
            </li>

            <li class="field-wrap">
                <label for="min-bed">Min Bedrooms:</label>
                <select id="min-bed" class="select-box" name="min-bed">
                    <?php write_options($min_beds, "min-bed"); ?>
                </select>
            </li>

            <li class="field-wrap">
                <label for="prop-type">Property Type:</label>
                <select id="prop-type" class="select-box" name="prop-type">
                    <?php write_options($property_types, "prop-type") ?>
                </select>
            </li>

            <li class="field-wrap">
                <label for="postcode">Post code:</label>
                <select id="postcode" class="select-box" name="postcode">
                    <?php write_options($postcodes, "postcode") ?>
                </select>
            </li>

            <li>
                <button class="pink-btn lrg-btn noise btn">Search <i class="sprite marker">M</i></button>
            </li>

        </ul></form>

    <script type="text/javascript">

        function restoreSelection() {
            var old_max_price = qs('max-price');
            var old_min_price = qs('min-price');
            if (old_max_price) $("#max-price").val(old_max_price);
            if (old_min_price) $("#min-price").val(old_min_price);
        }

        function setupPricing(rentOrBuy) {
            var max_prices = [], min_prices = [];

            if (rentOrBuy == "rent") {
                max_prices = <?php echo json_encode($max_rent_prices) ?>;
                min_prices = <?php echo json_encode($min_rent_prices) ?>;
            } else {
                max_prices = <?php echo json_encode($max_buy_prices) ?>;
                min_prices = <?php echo json_encode($min_buy_prices) ?>;
            }

            var $max_price_el = $("#max-price").empty();
            var $min_price_el = $("#min-price").empty();

            $.each(max_prices, function(key, value) {
                $max_price_el.append("<option value='" + key + "'>" + value + "</option>")
            });

            $.each(min_prices, function(key, value) {
                $min_price_el.append("<option value='" + key + "'>" + value + "</option>")
            });

            $("#buy-min .customSelectInner").text("£0.00");
            $max_price_el.val(0);
            $('#buy-max .customSelectInner').text("£0.00");
            $min_price_el.val(0);
        }

        $(function() {
            var switcher = $('.switch input');

            var switcherChoice = qs("buy-rent");

            switcher.change(function() {
                setupPricing($(this).val());
            })

            if (switcherChoice) {
                if (switcherChoice == "rent") $("#rent").click();
                else $("#buy").click();
            } else {
                switcherChoice = "buy";
            }

            setupPricing(switcherChoice);
            restoreSelection();
        });

    </script>

</div>