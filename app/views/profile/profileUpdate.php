
<form action ="" method="post">

<h1>Update your profile info</h1>
    <p>Type inside the bracket of the information you want to change.</p>
    <br>
    <div class="form-group">
        <label >New email address</label>
        <input type="email" name="email" class="form-control" placeholder=<?php echo (!empty($user_email)) ? $user_email:"";?>>
        <?php if(isset($email)){echo "<p style='color: red'>$email </p>";} ?>
    </div>
    <div class="form-group">
        <label >New tax Number</label>
        <input type="text" name="taxNumber" class="form-control" placeholder= <?php echo (!empty($user_taxnum)) ? $user_taxnum:"";?>>
        <?php if(isset($taxNumber)){echo "<p style='color: #ff0000'>$taxNumber </p>";} ?>
    </div>
    <div class="form-group">
        <label>New password</label>
        <input type="password" name="password" class="form-control">
        <?php if(isset($password)){echo "<p style='color: red'>$password </p>";} ?>
    </div>
    <div class="form-group">
        <label>Confirm new Password</label>
        <input type="password" name="confirmPassword" class="form-control">
        <?php if(isset($confirmPassword)){echo "<p style='color: red'>$confirmPassword </p>";} ?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>