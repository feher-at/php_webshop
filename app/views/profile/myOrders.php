<style type="text/css">
    button{
        padding: 0;
        border: none;
        background: none;
        float: left;

    }

</style>
<head>
    <h2>Your orders</h2>
</head>
<body>
<div >
   <table style=" width: 100%;"class="table-bordered">
        <thead >
        <th scope="col">Id</th>
        <th scope="col">Customer name</th>
        <th scope="col">Shipping address</th>
        <th scope="col">Billing address</th>
        <th scope="col">Phone</th>
        <th scope="col">Email</th>
        <th scope="col">Item id</th>
        <th scope="col">Price</th>
        <th scope="col">Quantity</th>
        <th scope="col">Status</th>
        <th scope="col"></th>
        </thead>
        <tbody>
        <?php
        foreach($orderArray as $orders => $order) {
            echo "<tr>";
            foreach($order as $item => $value){
                echo "<td>$value</td>";
            }
            echo "<td style='width:150px' >
                  <form action='/order' method='get'>
                  <input type='hidden' name='order_id' value='$order->order_id'>
                  <button type='submit' title='Show order page' >&#128065</button>
                  </form>
                  <form action='/setToUnderProcess' method='post'>
                  <input type='hidden' name='order_id' value='$order->order_id'>
                  <input type='hidden' name='currentPage' value='$currentPage'>
                  <button type='submit' title='Set status to under process'>&#8987</button>
                   </form>
                   <form action='/setToDelivery' method='post'>
                   <input type='hidden' name='order_id' value='$order->order_id'>
                   <input type='hidden' name='currentPage' value='$currentPage'>
                  <button title='Set status to delivery'>&#9951</button>
                  </form>
                  <form action='/setToDelivered' method='post'>
                  <input type='hidden' name='order_id' value='$order->order_id'>
                  <input type='hidden' name='currentPage' value='$currentPage'>
                  <button title='Set status to delivered'>&#10003</button>
                  </form>
                  <form action='/setToDeleted' method='post'>
                  <input type='hidden' name='order_id' value='$order->order_id'>
                  <input type='hidden' name='currentPage' value='$currentPage'>
                  <button title='Set status to deleted'>&#128465</button>
                  </form></td>";
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
