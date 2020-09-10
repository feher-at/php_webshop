<div class="container">
    <div class="row justify-content-center">
        <h1> Thank you for your order! We will send you an email with the details!</h1>
    </div>

</div>
<?php
    if(isset($data))
    {
        echo "<div class='align-content-center'>
                    <label> Your transaction data:</label>
             </div>
             <div class='align-content-center'>
                    <label> Bank: ".$data['branch_bank']."</label>
             </div>
             <div class='align-content-center'>
                    <label>  Bank number: ".$data['bank_number_input']."</label>
             </div>
             <div class='align-content-center'>
                    <label> recipient: ".$data['recipient_input']."</label>
             </div>";
    }
?>

