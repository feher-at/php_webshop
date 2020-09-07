<div class="container">
    <div class="row justify-content-center">
        <h1> Welcome to the php webshop!</h1>
    </div>

</div>


<div class='text-center mt-5' >

    <?php

    foreach ($allItem as $key)
    {
        $image = !empty($key->item_image) ? $key->item_image : $key->item_ogimage;
        $price = $key->item_saleprice != 0 ? $key->item_saleprice : $key->item_grossprice;
        $imageSource = "/Pictures/ItemPictures/". $image;


        echo "
              <div class='align-content-center row pt-4'>
                  <div class='col-7 text-right pl-1 '>
                    <img src= $imageSource style='width:300px;height:300px'>
                  </div>
                  <div class='col-5  pb-5 text-left'>
                    <h3 class=>$key->item_name</h3>
                    <div class='pl-3 row'>
                        <p>Price: $price</p>
                        <div class='pl-3'>
                          <form action ='/item/itemUpload' method='get'>
                                <button style='height:25px;padding-top:0px'type='submit' class='btn btn-primary'>Buy</button>
                          </form>
                        </div>
                    </div>
                    <p>Description: $key->item_description</p>
                    
                  </div> 
                  
              </div>";
    }
    ?>
</div>
