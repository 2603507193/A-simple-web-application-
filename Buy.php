<?php
    session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Solar Energy Sharing</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0">
    <link rel="stylesheet" href="indexStyle.css">
    <link rel="stylesheet" href="bootstrap.min.css">
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
                      </form>
                  ';
              }
           ?>
        </div>
      </nav>
    </header>
    <main>
      <?php
        $product_ids = array();
        if (filter_input(INPUT_POST, 'add_to_cart')){
          if(!(isset($_SESSION['u_email'])))
          {
             echo "	<div class='alert alert-danger' role='alert'>
  				 	  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  				 	  <strong>Hey there!</strong> Sign in to buy Electricity!
				      </div>";
            }else {
              if(isset($_SESSION['shopping_cart']))
              {
                $count = count($_SESSION['shopping_cart']);
                $product_ids = array_column($_SESSION['shopping_cart'],'id');
                if(!in_array(filter_input(INPUT_POST,'id'),$product_ids)){
                  $_SESSION['shopping_cart'][$count] = array(
                    'id' => filter_input(INPUT_POST,'Sell_id'),
                    'begin' => filter_input(INPUT_POST,'begin'),
                    'end' => filter_input(INPUT_POST,'end'),
                    'price' => filter_input(INPUT_POST,'price')
                  );
                }
              }else {
                  $_SESSION['shopping_cart'][0] = array(
                    'id' => filter_input(INPUT_POST,'Sell_id'),
                    'begin' => filter_input(INPUT_POST,'begin'),
                    'end' => filter_input(INPUT_POST,'end'),
                    'price' => filter_input(INPUT_POST,'price')
                  );
              }
            }
        }

      if(filter_input(INPUT_GET, 'action')=='delete')
      {
        foreach ($_SESSION['shopping_cart'] as $key => $product)
        {
          if ($product['id'] == filter_input(INPUT_GET,'id'))
          {
            unset($_SESSION['shopping_cart'][$key]);
          }
        }
        $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
      }
       ?>
      <div class="container">
          <?php
             $connect = mysqli_connect('localhost', 'root','','loginsystem');
             $query = 'SELECT * FROM sell_information ORDER by sell_id ASC';
             $result = mysqli_query($connect, $query);

             if ($result){
               if(mysqli_num_rows($result)>0){
                 while ($product = mysqli_fetch_assoc($result)) {
                  ?>
                  <div style="float: left;
                  margin-left: 10px;
                  width: 25%; margin-top:20px;">
                    <form  action="Buy.php?action=add&id=<?php echo $product['sell_id'] ?>" method="post">
                          <div style="border: 1px solid #333;
                            background-color: #f1f1f1;
                            border-radius: 5px;
                            padding: 16px;
                            margin-bottom: 20px;
                            padding: 15px;">
                            <p class ="text-info" >Time of Begining to Buy Solar Power:  <?php echo $product['transaction_begin']; ?></p>
                            <p class = "text-info"> Transaction End Time: <?php echo $product['transaction_end']; ?></p>
                            <h4> Price <?php echo $product['price']; ?>$</h4>
                            <input type="hidden" name="Sell_id" value="<?php echo $product['sell_id'];?>">
                            <input type="hidden" name="begin" value="<?php echo $product['transaction_begin'];?>">
                            <input type="hidden" name="end" value="<?php echo $product['transaction_end']; ?>">
                            <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-info"  value="Add to Cart">
                          </div>
                    </form>
                  </div>
                  <?php
                 }
               }
             }
           ?>
        <div style="clear:both"></div>
        <br />
        <div class="table-responsive">
          <table  class="table">
            <tr>
              <th colspan ="5"><h3>Order Details</h3></th>
            </tr>
            <tr>
              <th width="30%">Transaction Start Time</th>
              <th width="30%">Transaction End Time</th>
              <th width="20%">Price</th>
              <th width="10%">Action</th>
            </tr>
            <?php
             if(!empty($_SESSION['shopping_cart'])):
               $total = 0;
              foreach ($_SESSION['shopping_cart'] as $key => $product):
             ?>
             <tr>
               <td ><?php echo $product['begin'];?></td>
               <td ><?php echo $product['end']; ?></td>
               <td >$<?php echo $product['price']; ?></td>
               <td >
                  <a href="Buy.php?action=delete&id= <?php echo $product['id']; ?>">
                  <div class="btn-danger"> Remove </div>
                  </a>
               </td>
             </tr>
            <?php
                 $total=$total + $product['price'];
                 endforeach;
            ?>
            <tr>
              <td colspan="3" align = "right">Total</td>
              <td align = "right">$ <?php echo number_format($total,2);  ?></td>
              <td></td>
            </tr>
            <td colspan="5">
            <?php
              if(isset($_SESSION['shopping_cart'])):
              if(count($_SESSION['shopping_cart']) > 0):
             ?>
             <a href="Payment.php"  class="button">Checkout</a>
           <?php endif; endif; ?>
            </td>
          <?php endif; ?>
          </table>
        </div>
       </div>
    </main>
  </body>
</html>
