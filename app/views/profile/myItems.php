
<body>
<div>
<table style=" width: 100%;"class="table-bordered">
    <thead>
    <th scope="col">Id</th>
    <th scope="col">Name</th>
    <th scope="col">Description</th>
    <th scope="col">Grossprice</th>
    <th scope="col">Image</th>
    <th scope="col">Stock</th>
    <th scope="col">Saleprice</th>
    <th scope="col">SEO name</th>
    <th scope="col">SEO description</th>
    <th scope="col">OG image</th>
    <th scope="col">Buyable?</th>
    </thead>
    <tbody><?php
    foreach($itemArray as $items => $itemObject) {
        echo "<tr>";
        foreach ($itemObject as $item => $value) {
            switch($item) {
                case "item_ogimage":
                {
                    if ($value != "") {
                        $image = $imageSource . $value;
                        echo "<td><img src=$image style='width:150px;height:150px'></td>";
                        break;
                    } else {
                        echo "<td></td>";
                        break;
                    }
                }
                case "item_image" :
                {
                    $image = $imageSource . $value;
                    echo "<td><img src=$image style='width:150px;height:150px'></td>";
                    break;
                }
                case  "user_id" :
                    break;
                case "item_is_buyable":{
                    echo " <td>";
                    if($value==true){
                        echo "Item is buyable";
                    }
                    elseif ($value==false){
                        echo "Item is not buyable";
                    }
                    echo "
                    <form action='setBuyable' method='post'>
                    <input type='hidden' name='item_id' value='$itemObject->item_id'>
                    <input type='hidden' name='buyable' value='$value'>
                    <input type='hidden' name='currentPage' value='$currentPage'>
                    <button  type='submit' class='btn btn-primary' >Change state</button>
                    </form>
                    </td>";
                    break;
                }
                default :
                {
                    echo "<td>$value</td>";
                    break;
                }
            }
        }
        echo "</tr>";
    }
        ?>
    </tbody>
</table>
</div>
<div>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item">
                <a href="myOrders?page=<?= ($currentPage-1<=0) ? $currentPage : $currentPage-1 ; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo; Previous</span>
                </a>
            </li>
            <?php for($i = 1; $i<= $pages; $i++) : ?>
                <li class="page-item"><a href="myOrders?page=<?= $i; ?>"><?= $i; ?></a></li>
            <?php endfor; ?>
            <li class="page-item">
                <a href="myOrders?page=<?= ($currentPage+1>$pages) ? $currentPage:$currentPage+1; ?>" aria-label="Next">
                    <span aria-hidden="true">Next &raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
</body>

