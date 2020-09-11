<script type="text/javascript" src="../js/test.js"

></script>


<div class="container mb-5">
    <div class="row justify-content-center">
        <h1>Order</h1>
    </div>

</div>

<form action ="/finished_order" method="post">

    <div class="form-group row">
        <div class="col-xs-6 mr-4" >
            <label >First Name*</label>
        </div>
        <div class="col-xs-6 ml-3">
            <input type="text" name="first_name" class="form-control" >
            <?php if(isset($item_name_error)){echo "<p style='color: #ff0000'>$item_name_error </p>";} ?>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-4" >
            <label >Last Name*</label>
        </div>
        <div class="col-xs-6 ml-3">
            <input type="text" name="last_name" class="form-control" >
            <?php if(isset($item_name_error)){echo "<p style='color: red'>$item_name_error </p>";} ?>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-5">
            <label >Address*</label>
        </div>
        <div class="ml-2">
            <label>
                <input  type="text" name="customer_shipping_address" class="form-control">
            </label>
        </div>
        <?php if(isset($item_description_error)){echo "<p style='color: #ff0000'>$item_description_error </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-2">
            <label >Billing Address*</label>
        </div>
        <div>
            <label>
                <input type="text" name="customer_billing_address" class="form-control">
            </label>
        </div>
        <?php if(isset($item_price_error)){echo "<p style='color: red'>$item_price_error </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-2">
            <label>Email address *</label>
        </div>
        <div>
            <input  type="text" name="customer_email" class="form-control">
        </div>
        <?php if(isset($item_image_error)){echo "<p style='color: red'>$item_image_error </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-2">
            <label>Phone number </label>
        </div>
        <div class="ml-1">
            <label>
                <input type="text" name="customer_phone" class="form-control" placeholder="+362088840">
            </label>
        </div>

        <?php if(isset($item_saleprice_error)){echo "<p style='color: red'>$item_saleprice_error </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-5">
            <label> Quantity  </label>
        </div>
        <div class="ml-2">
            <label>
                <input type="text" name="item_quantity" class="form-control"  value='1' placeholder="1">
                <?php echo "<input type='hidden' name='item_id' value='$item_id'/>" ?>
                <?php echo "<input type='hidden' name='price' value='$price'/>" ?>
            </label>
        </div>
        <?php if(isset($item_stock_error)){echo "<p style='color: red'>$item_stock_error </p>";} ?>
    </div>
    <div class="form_group row mb-4">
        <div class="col-xs-6 mr-5">
            <label> Couriers  </label>
        </div>
        <select class="ml-2"name="couriers" id="couriers">
            <?php
            foreach ($couriers as $courier)
            {
                echo "<option value=".$courier['courier_name'].">".$courier['courier_name'].",  Cost: ".$courier['shipping_price']." FT </option>";
            }
            ?>
        </select>
    </div>
    <div class="form_group row mb-5">
        <div class="col-xs-6 mr-5">
            <label> Payment  </label>
        </div>
        <select class="ml-2"name="payments" id="payments">
            <?php
                foreach ($payments as $payment)
                {
                    $paymentMethodName = str_replace(" ","_",$payment['payment_method_name']);
                    echo "<option  value=".$paymentMethodName.">".$payment['payment_method_name'].",  Cost: ".$payment['payment_handlingfee']." FT </option>";
                }
            ?>
        </select>
    </div>
    <div id="card_data" class="container justify-content-center row mb-5">

    </div>
    <div class="col text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</form>

