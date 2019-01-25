<?php
    session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Solar Energy Sharing</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="indexStyle.css">
  </head>
  <body>
  <header>
    <nav>
      <div class=" main-wrapper">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="Buy.php">Buy</a></li>
          <li><a href="Sell.php">Sell</a></li>
        </ul>
      </div>
        <div class="nav-login">
          <?php
              if (isset($_SESSION['u_email'])) {
                echo '<form  action="include/logout.inc.php" method="post">
                       <button type="submit" name="submit">Logout</button>
                      </form>';
              }else {
                echo '<form  action="include/login.inc.php" method="POST">
                        <input name="Email" type="text" placeholder="E-mail">
                        <input name ="pwd" type="password"  placeholder="password">
                        <button type="submit" name="submit">Login</button>
                      </form>';
              }
           ?>
        </div>
      </nav>
    </header>
      <div class="container">
        <?php
              $connect = mysqli_connect('localhost', 'root','', 'loginsystem');
              $query = 'SELECT * FROM sell_information ORDER by sell_id ASC';
              $result = mysqli_query($connect, $query);

              if ($result){
                if(mysqli_num_rows($result)>0){
                  while ($product = mysqli_fetch_assoc($result))
                  {
        ?>
        <div style="float: left;
        margin-left: 10px;
        width: 25%; margin-top:100px;">
          <form class="responsive"  action=" Cancel.php?id =<?php echo $product['sell_id'] ?>" method="post">
                <div style="border: 1px solid #333;
                  background-color: #f1f1f1;
                  border-radius: 5px;
                  padding: 16px;
                  margin-bottom: 20px;
                  padding: 15px;">
                  <p class ="text-info" >Start Time:  <?php echo $product['transaction_begin']; ?></p><br>
                  <p class = "text-info">End Time: <?php echo $product['transaction_end']; ?></p>
                  <h4> Price <?php echo $product['price']; echo "$"; ?></h4>
                  <input type="hidden" name="id" value="<?php echo $product['sell_id']; ?>">
                  <input type="submit" name="delete" style="margin-top:5px;" class="btn btn-info"  value="Cancel sell Electricity">
                </div>
          </form>
        </div>
      <?php
                  }
                }
              }
        ?>
<?php
    if (filter_input(INPUT_POST,'delete')) {
        $Id = $_REQUEST['id'];
        $sql = "DELETE FROM sell_information WHERE sell_id = $Id";
        if ($connect->query($sql) === TRUE) {
            echo "
             <div class='alert alert-danger' role='alert'>
             <a href='Cancel.php'>Refresh</a>
             <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
             <strong>Hey there!</strong> Successfully Cancel the Transaction!
             </div>
             ";
        } else {
            echo "Error deleting record: " . $connect->error;
        }
      $connect->close();
      }
 ?>
  </body>
</html>
