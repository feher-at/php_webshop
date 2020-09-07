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
            <?php if(isset($item_name_error)){echo "<p style='color: red'>$item_name_error </p>";} ?>
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
        <?php if(isset($item_description_error)){echo "<p style='color: #ff0000'>$item_description_error </p>";} ?>
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
        <?php if(isset($item_price_error)){echo "<p style='color: red'>$item_price_error </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-3">
            <label>Item Picture *</label>
        </div>
        <div>
            <input style="border:none" type="file" name="item_image" class="form-control">
        </div>
        <?php if(isset($item_image_error)){echo "<p style='color: red'>$item_image_error </p>";} ?>
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

        <?php if(isset($item_saleprice_error)){echo "<p style='color: red'>$item_saleprice_error </p>";} ?>
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
        <?php if(isset($item_stock_error)){echo "<p style='color: red'>$item_stock_error </p>";} ?>
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
                <?php if(isset($gls)){ echo"<p style='color: red' align='left'> $gls[courier_required_error] </p>";} ?>
            </div>

            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='gls_price' placeholder='Price...'>
                <?php if(isset($gls)){ echo"<p style='color: red' align='right'> $gls[courier_price_error] </p>";} ?>
            </div>
            <div class= 'col-6'>
                <input  type='checkbox' name='dpd' value='2'/>DPD
                <?php if(isset($dpd)){ echo"<p style='color: red' align='left'> $dpd[courier_required_error] </p>";} ?>
            </div>
            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='dpd_price' placeholder='Price...'>
                <?php if(isset($dpd)){ echo"<p style='color: red' align='left'> $dpd[courier_required_error] </p>";} ?>
            </div>
            <div class= 'col-6'>
                <input  type='checkbox' name='personal_receive' value='3'/>Personal receive
                <?php if(isset($personal_receive)){ echo"<p style='color: red' align='left'> $personal_receive[courier_required_error] </p>";} ?>
            </div>
            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='personal_receive_price' placeholder='Price...'>
                <?php if(isset($personal_receive)){ echo"<p style='color: red' align='left'> $personal_receive[courier_required_error] </p>";} ?>
            </div>
            <div class= 'col-6'>
                <input  type='checkbox' name='magyar_posta' value='4'/>Magyar Posta
                <?php if(isset($magyar_posta)){ echo"<p style='color: red' align='left'> $magyar_posta[courier_required_error] </p>";} ?>
            </div>
            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='magyar_posta_price' placeholder='Price...'>
                <?php if(isset($magyar_posta)){ echo"<p style='color: red' align='left'> $magyar_posta[courier_required_error] </p>";} ?>
            </div>
            <div class= 'col-6'>
                <input  type='checkbox' name='fox_post' value='5'/>FoxPost
                <?php if(isset($fox_post)){ echo"<p style='color: red' align='left'> $fox_post[courier_required_error] </p>";} ?>

            </div>
            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='fox_post_price' placeholder='Price...'>
                <?php if(isset($fox_post)){ echo"<p style='color: red' align='left'> $fox_post[courier_required_error] </p>";} ?>

            </div>

        </div>
        <?php if(isset($noCouriers)){ echo"<p style='color: red' align='center'> $noCouriers </p>";} ?>


    </div>


    </div>

    <div class="col text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</form>

