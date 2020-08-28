<div class="container">
    <div class="row justify-content-center">
        <h1> Registration</h1>
    </div>

</div>

<form action ="" method="post">


    <div class="form-group">
        <label >Email address</label>
        <input type="email" name="email" class="form-control">
        <?php if(isset($email)){echo "<p style='color: red'>$email </p>";} ?>
    </div>
    <div class="form-group">
        <label >Tax Number</label>
        <input type="text" name="taxNumber" class="form-control">
        <?php if(isset($taxNumber)){echo "<p style='color: red'>$taxNumber </p>";} ?>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
        <?php if(isset($password)){echo "<p style='color: red'>$password </p>";} ?>
    </div>
    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="confirmPassword" class="form-control">
        <?php if(isset($confirmPassword)){echo "<p style='color: red'>$confirmPassword </p>";} ?>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<a href="/" style="color: white">Submit</a>