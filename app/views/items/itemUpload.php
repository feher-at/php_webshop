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
            <input type="text" name="item_name" class="form-control">
        </div>

        <?php if(isset($email)){echo "<p style='color: red'>$email </p>";} ?>

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
        <?php if(isset($taxNumber)){echo "<p style='color: #ff0000'>$taxNumber </p>";} ?>
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
        <?php if(isset($password)){echo "<p style='color: red'>$password </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-3">
            <label>Item Picture *</label>
        </div>
        <div>
            <input style="border:none" type="file" name="item_image" class="form-control">
        </div>
        <?php if(isset($confirmPassword)){echo "<p style='color: red'>$confirmPassword </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-3">
            <label>Item Sale Price </label>
        </div>
        <div class="ml-1">
            <label>
                <input type="text" name="item_saleprice" class="form-control">
            </label>
        </div>

        <?php if(isset($confirmPassword)){echo "<p style='color: red'>$confirmPassword </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-5">
            <label> Stock(s)  </label>
        </div>
        <div class="ml-3">
            <label>
                <input type="text" name="item_stock" class="form-control">
            </label>
        </div>
        <?php if(isset($confirmPassword)){echo "<p style='color: red'>$confirmPassword </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-2">
            <label>SEO Item Name</label>
        </div>
        <div>
            <label>
                <input type="text" name="item_seoname" class="form-control">
            </label>
        </div>
        <?php if(isset($confirmPassword)){echo "<p style='color: red'>$confirmPassword </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-1">
            <label>SEO Description</label>
        </div>
        <div>
            <label>
                <textarea cols="75" type="text" name="item_seodescription" class="form-control"></textarea>
            </label>
        </div>
        <?php if(isset($confirmPassword)){echo "<p style='color: red'>$confirmPassword </p>";} ?>
    </div>
    <div class="form-group row">
        <div class="col-xs-6 mr-4">
            <label>OG Picture</label>
        </div>
        <div class="ml-1">

            <input style="border:none" type="file" name="item_ogpicture" class="form-control">

        </div>
        <?php if(isset($confirmPassword)){echo "<p style='color: red'>$confirmPassword </p>";} ?>
    </div>
    <div class="form-group">
        <div class=>
            <label class="">Couriers </label>
        </div>
        <div class="row">
            <div class= 'col-6'>
                <input  type='checkbox' name='gls' value='1'/>GLS
            </div>
            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='gls_price' placeholder='Price...'>
            </div>
            <div class= 'col-6'>
                <input  type='checkbox' name='dpd' value='2'/>DPD
            </div>
            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='dpd_price' placeholder='Price...'>
            </div>
            <div class= 'col-6'>
                <input  type='checkbox' name='personal_receive' value='3'/>Personal receive
            </div>
            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='personal_receive_price' placeholder='Price...'>
            </div>
            <div class= 'col-6'>
                <input  type='checkbox' name='magyar_posta' value='4'/>Magyar Posta
            </div>
            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='magyar_posta_price' placeholder='Price...'>
            </div>
            <div class= 'col-6'>
                <input  type='checkbox' name='fox_post' value='5'/>FoxPost
            </div>
            <div>
                <input class='ml-5 mb-1 align-text-top' type='text' name='fox_post_price' placeholder='Price...'>
            </div>

        </div>


    </div>


    </div>

    <div class="col text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</form>

