<body>
<div class="form-group">
    <form action="/forgotPassword" method="post">
        <label>Type in your email address</label>
        <input type="text" name="email" class="form-control" >
        <?php if(isset($email)){echo "<p style='color: red'>$email </p>";} ?>
</div>
        <button type="submit" class="btn btn-primary">Send new password</button>
    </form>
</body>

