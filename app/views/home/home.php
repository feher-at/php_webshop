<h1>Home</h1>
<?php
if(isset($_COOKIE["type"])){
    echo"logged in";
}
else{
    echo "not logged in";
}?>
