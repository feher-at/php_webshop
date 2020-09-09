<div class="container">
    <div class="row justify-content-center">
        <h1> Upload your items here</h1>
    </div>

</div>

<form action ="" method="post" enctype="multipart/form-data">

    <div class="form-group row">
        <div class="col-xs-6 mr-4" >
            <label >Item Name*</label>
        </div>
        <div class="col-xs-6 ml-3">
            <input type="text" name="item_name" class="form-control" >
            <?php if(isset($errors['item_name_error'])){echo "<p style='color: red'>".$errors['item_name_error']." </p>";} ?>
        </div>



    </div>
    <div class="form-group row">
        <div class="col-xs-6 ">
            <label >Item Description*</label>
        </div>
        <div>
            <label>
                <textarea cols="75" type="text" name="item_description" class="form-control"></textarea>
            </label>
        </div>
        <?php if(isset($errors['item_description_error'])){echo "<p style='color: #ff0000'>".$errors['item_description_error']." </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-5">
            <label >Price (FT) *</label>
        </div>
        <div>
            <label>
                <input type="text" name="item_price" class="form-control">
            </label>
        </div>
        <?php if(isset($errors['item_price_error'])){echo "<p style='color: red'>".$errors['item_price_error']." </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-3">
            <label>Item Picture *</label>
        </div>
        <div>
            <input style="border:none" type="file" name="item_image" class="form-control">
        </div>
        <?php if(isset($errors['item_image_error'])){echo "<p style='color: red'>".$errors['item_image_error']." </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-3">
            <label>Item Sale Price </label>
        </div>
        <div class="ml-1">
            <label>
                <input type="text" name="item_saleprice" class="form-control" placeholder="0">
            </label>
        </div>

        <?php if(isset($errors['$item_saleprice_error'])){echo "<p style='color: red'>".$errors['$item_saleprice_error']." </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-5">
            <label> Stock(s)  </label>
        </div>
        <div class="ml-3">
            <label>
                <input type="text" name="item_stock" class="form-control"  placeholder="0">
            </label>
        </div>
        <?php if(isset($errors['item_stock_error'])){echo "<p style='color: red'>".$errors['item_stock_error']." </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-2">
            <label>SEO Item Name</label>
        </div>
        <div>
            <label>
                <input type="text" name="item_seoname" class="form-control" placeholder="">
            </label>
        </div>

    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-1">
            <label>SEO Description</label>
        </div>
        <div>
            <label>
                <textarea cols="75" type="text" name="item_seodescription" class="form-control"  placeholder=" "></textarea>
            </label>
        </div>

    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-4">
            <label>OG Picture</label>
        </div>
        <div class="ml-1">

            <input style="border:none" type="file" name="item_ogpicture" class="form-control"  placeholder=" ">

        </div>

    </div>
    <div class="form-group">
        <div class=>
            <label class="">Couriers </label>
        </div>
        <div class="row">
            <div class= 'col-6'>
                <input  type='checkbox' name='gls' value='1'/>GLS
                <?php if(isset($errors['gls'])){ echo"<p style='color: red' align='left'> ".$errors['gls']['courier_required_error']." </p>";} ?>
            </div>

            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='gls_price' placeholder='Price...'>
                <?php if(isset($errors['gls'])){ echo"<p style='color: red' align='right'> ".$errors['gls']['courier_price_error']." </p>";} ?>
            </div>
            <div class= 'col-6'>
                <input  type='checkbox' name='dpd' value='2'/>DPD
                <?php if(isset($errors['dpd'])){ echo"<p style='color: red' align='left'> ".$errors['dpd']['courier_required_error']." </p>";} ?>
            </div>
            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='dpd_price' placeholder='Price...'>
                <?php if(isset($errors['dpd'])){ echo"<p style='color: red' align='left'> ".$errors['dpd']['courier_price_error']." </p>";} ?>
            </div>
            <div class= 'col-6'>
                <input  type='checkbox' name='personal_receive' value='3'/>Personal receive
                <?php if(isset($errors['personal_receive'])){ echo"<p style='color: red' align='left'> ".$errors['personal_receive']['courier_required_error']." </p>";} ?>
            </div>
            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='personal_receive_price' placeholder='Price...'>
                <?php if(isset($errors['personal_receive'])){ echo"<p style='color: red' align='left'> ".$errors['personal_receive']['courier_price_error']." </p>";} ?>
            </div>
            <div class= 'col-6'>
                <input  type='checkbox' name='magyar_posta' value='4'/>Magyar Posta
                <?php if(isset($errors['magyar_posta'])){ echo"<p style='color: red' align='left'> ".$errors['magyar_posta']['courier_required_error']." </p>";} ?>
            </div>
            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='magyar_posta_price' placeholder='Price...'>
                <?php if(isset($errors['magyar_posta'])){ echo"<p style='color: red' align='left'> ".$errors['magyar_posta']['courier_price_error']." </p>";} ?>
            </div>
            <div class= 'col-6'>
                <input  type='checkbox' name='fox_post' value='5'/>FoxPost
                <?php if(isset($errors['fox_post'])){ echo"<p style='color: red' align='left'> ".$errors['fox_post']['courier_required_error']." </p>";} ?>

            </div>
            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='fox_post_price' placeholder='Price...'>
                <?php if(isset($errors['fox_post'])){ echo"<p style='color: red' align='left'> ".$errors['fox_post']['courier_price_error']." </p>";} ?>

            </div>

        </div>
        <?php if(isset($errors['noCouriers'])){ echo"<p style='color: red' align='center'>".$errors['noCouriers']."  </p>";} ?>


    </div>
    <div class="form-group">
        <div class=>
            <label class="">Payments </label>
        </div>
        <div class="row">
            <?php
            foreach($payments as $key)
            {
               echo '<div class="col-6">
                        <p>'.$key['payment_method_name'].'</p>
                        <input type="hidden" name='.$key['payment_method_name'].' value='.$key['payment_method_id'].'>
                     </div>
                     <div class="ml-5 mb-1">
                        <input type="text" name="'.$key['payment_method_name'].'_price" value=0 placeholder="Price...">
                     </div>';

            }
            ?>
        </div>
    </div>


    </div>

    <div class="col text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</form>

