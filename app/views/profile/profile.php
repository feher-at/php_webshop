<style type="text/css">
    td {
        font-size: 15px;
    }
    table {
        width : 80%
    }

</style>
<head>


</head>
<body>
<h1>Profile</h1>
<div>
    <table class="table table-sm" style="width:30%">
        <tr >
            <td>Your id:</td>
            <td><?php echo "$user_id"?></td>
        </tr>
        <tr>
            <td>Your email:</td>
            <td><?php echo "$user_email"?></td>
        </tr>
        <tr>
            <td>Your tax number:</td>
            <td><?php echo "$user_taxnum"?></td>
        </tr>
    </table>
    <nav class="nav nav-pills">
    <a class="nav-item nav-link active" href="profileUpdate" style="margin-right:2em">Update your profile</a>
        <a action="/profileDelete" class="nav-item nav-link active" href="profileDelete">Delete your profile</a>
        <a action="/myOrders" class="nav-item nav-link active" href="myOrders?page=1">Your orders</a>

    </nav>

</div>

</body>