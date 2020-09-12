<script type="text/javascript" src="../js/test.js"

></script>


<div class="container mb-5">
    <div class="row justify-content-center">
        <h1>Order</h1>
    </div>

</div>

<form action ="" method="post">

    <div class="form-group row">
        <div class="col-xs-6 mr-4" >
            <label >First Name*</label>
        </div>
        <div class="col-xs-6 ml-3">
            <input type="text" name="first_name" class="form-control" >
            <?php if(isset($error['first_name_error'])){echo "<p style='color: #ff0000'>".$error['first_name_error']." </p>";} ?>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-4" >
            <label >Last Name*</label>
        </div>
        <div class="col-xs-6 ml-3">
            <input type="text" name="last_name" class="form-control" >
            <?php if(isset($error['second_name_error'])){echo "<p style='color: red'>".$error['second_name_error']." </p>";} ?>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-5">
            <label >Address*</label>
        </div>
        <div class="ml-2">
            <label>
                <input  type="text" name="customer_shipping_address" class="form-control">
                <?php if(isset($error['address_error'])){echo "<p style='color: #ff0000'>".$error['address_error']." </p>";} ?>
            </label>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-2">
            <label >Billing Address*</label>
        </div>
        <div>
            <label>
                <input type="text" name="customer_billing_address" class="form-control">
                <?php if(isset($error['billing_address_error'])){echo "<p style='color: red'>".$error['billing_address_error']." </p>";} ?>
            </label>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-2">
            <label>Email address *</label>
        </div>
        <div>
            <input  type="email" name="customer_email" class="form-control">
            <?php if(isset($error['email_error'])){echo "<p style='color: red'>".$error['email_error']." </p>";} ?>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-2">
            <label>Phone number </label>
        </div>
        <div class="ml-1">
            <label>
                <input type="text" name="customer_phone" class="form-control" placeholder="+362088840">
                <?php if(isset($error['phone_number_error'])){echo "<p style='color: red'>".$error['phone_number_error']." </p>";} ?>
            </label>
        </div>
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
                <?php if(isset($error['quantity_number_error']['error'])){echo "<p style='color: red'>".$error['quantity_number_error']['error']." </p>";} ?>
            </label>
        </div>
    </div>
    <div class="form_group row mb-4">
        <div class="col-xs-6 mr-5">
            <label> Couriers  </label>
        </div>
        <select class="ml-2"name="couriers" id="couriers">
            <?php
            foreach ($couriers as $courier)
            {   $courierName = str_replace("_"," ",$courier['courier_name']);
                echo "<option value=".$courier['courier_name'].">".$courierName.",  Cost: ".$courier['shipping_price']." FT </option>";
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
                    $paymentMethodName = str_replace("_"," ",$payment['payment_method_name']);
                    echo "<option  value=".$payment['payment_method_name'].">".$paymentMethodName.",  Cost: ".$payment['payment_handlingfee']." FT </option>";
                }
            ?>
        </select>
    </div>
    <div id="card_data" class="container justify-content-center row mb-5">
        <div id='branch_label_div' class='mr-3'>
            <label>Bank</label>
        </div>
        <div id='branch_bank_div' class='align-content-center'>
            <select name='branch_bank' id='branch_bank' class='mr-5' disabled>
                <option value='Otp' id='otpOption'>Otp</option>
                <option value='Erste' id='ersteOption'>Erste</option>
                <option value='Cib' id='cibOption'>Cib</option>
            </select>
        </div>

        <div id='number_label_div' class='mr-5'>
            <label>Bank number</label>
        </div>
        <div id='number_input_div' class='mr-5'>
            <input id='number_input' name='bank_number_input' disabled>
            <?php if(isset($error['bank_number_error'])){echo "<p style='color: red'>".$error['bank_number_error']." </p>";} ?>
        </div>

        <div id='recipient_label_div' class='mr-3'>
            <label>Recipient</label>
        </div>
        <div id='recipient_input_div' class='mr-3' >
            <input  id='recipient_input' name='recipient_input' disabled/>
            <?php if(isset($error['recipient_error'])){echo "<p style='color: red'>".$error['recipient_error']." </p>";} ?>
        </div>

    </div>

    <div class="col text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</form>

