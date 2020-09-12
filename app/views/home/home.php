<div class="container">
    <div class="row justify-content-center">
        <h1> Welcome to the php webshop!</h1>
    </div>

</div>


<div class='text-center mt-5' >

    <?php
    if(!empty($items))
    {

    foreach ($items as $key)
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
                          <form action ='/item/order' method='get'>
                                <button style='height:25px;padding-top:0px'type='submit' class='btn btn-primary'>Buy</button>
                                <input type='hidden' name='item_id' value='$key->item_id'/>
                          </form>
                        </div>
                    </div>
                    <p>Description: $key->item_description</p>
                    
                  </div> 
                  
              </div>";
    }


        $previousPaginate =  ($current_page-1<=0) ? $current_page : $current_page-1 ;
        $nextPaginate = ($current_page+1>$pages) ? $current_page:$current_page+1;
       echo " <nav aria-label='Page navigation' class='navbar justify-content-center'>
            <ul class='pagination'>
                <li class='page-item'>
                    <a href='home?page=".$previousPaginate."' aria-label='Previous'>
                        <span aria-hidden='true'>&laquo; Previous</span>
                    </a>
                </li>";
                for($i = 1; $i<= $pages; $i++)
                {


                    echo"<li class='page-item'><a href='home?page=$i'> $i; </a></li>";
                }
               echo" <li class='page-item'>
                    <a href='home?page=".$nextPaginate."' aria-label='Next'>
                        <span aria-hidden='true'>Next &raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>";
    }
    else
    {
        echo" <div class='row justify-content-center'>
                <h1> The shop is now empty!</h1>
              </div>";
    }
    ?>


