<?php

ob_start(); // Enables output buffering and helps in redirection to some other link

session_start(); // enables storing data securely in the $_SESSION[] global array
//session_destroy();



$connection = new mysqli("localhost","root",""); 

$sql ="CREATE DATABASE IF NOT EXISTS dabax";
query($sql);
mysqli_select_db($connection, "dabax");
//Connects with the database created via phpmyadmin


defined("DS") ? null : define("DS",DIRECTORY_SEPARATOR);
//echo __DIR__;   //__DIR__ is magic costant means root of the file

defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__ . DS . "templates/front");
defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__ . DS . "templates/back");
defined("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY", __DIR__ . DS . "uploads");

//Used to redirect to certain pages
function redirect($location){  
	header("Location: $location ");
}

//Used to connect query to the database
function query($sql){
	global $connection;
	return mysqli_query($connection, $sql);
}

//Used when the query exception catcher
function confirm($result){
	global $connection;
	if(!$result){
		die("QUERY FAILURE " . mysqli_error($connection));
	}
}

//Used to prevent SQL Injections
function escape_string($string){
	global $connection;
	return mysqli_real_escape_string($connection, $string);
}

//Used for fetching the Queries as an array from the database
function fetch_array($result){
	return mysqli_fetch_array($result);
}

//Used to display any message into the DOM
function set_msg($msg){
	if(!empty($msg)){
		$_SESSION['message'] = $msg;
	} else{
		$msg = "";
	}
}

function display_msg(){
	if(isset($_SESSION['message'])){ //Checks if the variable is set or not
       echo $_SESSION['message'];
       unset($_SESSION['message']);
	}
}

//Used on menus table
function get_menu(){  
$query = query("SELECT * FROM menus");
confirm($query);
while ($row = fetch_array($query)) {
		
$menu = <<<DELIMETER
  <div class="col-sm-4 col-lg-4 col-md-4">
  <form method="post" action="thank_you.php?action=add&id={$row['menu_title']}">
  <div class="thumbnail">
  <img src="../resources/uploads/{$row['menu_image']}" width=""200" height="100"></a>
   <div class="caption">
   <h4 class="pull-right">₹ {$row['menu_price']}</h4>
   <h4>{$row['menu_title']}</a>
   </h4>
   <h5>Available from: {$row['menu_restaurant']}</h5>
   <h5>Item Type: {$row['menu_type']}</h5>
   <input type="hidden" name="hidden_title" value="{$row['menu_title']}">
   <input type="hidden" name="hidden_price" value="{$row['menu_price']}">
   <input type="hidden" name="hidden_restaurant" value="{$row['menu_restaurant']}">
   <input type="submit" name="order_now" class="btn btn-primary btn-lg" value="Order Now">
    </div>
    </div>
    </form>
 </div>
 
DELIMETER;

echo $menu;

	}
}

//Used to Enter Items into the temp shopping cart
function fill_orders(){
  if(isset($_POST["order_now"]))  
 {  
      if(isset($_SESSION["order_table"]))  
      {  
           $item_array_id = array_column($_SESSION["order_table"], "item_id");  
           if(!in_array($_GET["id"], $item_array_id))  
           {  
                $count = count($_SESSION["order_table"]);  
                $item_array = array(  
                     'item_id'               =>     $_GET["id"],  
                     'item_title'               =>     $_POST["hidden_title"],
                     'item_price'              =>    $_POST["hidden_price"],
                     'item_rest'              =>      $_POST["hidden_restaurant"]
                );  
                $_SESSION["order_table"][$count] = $item_array;  
           }  
           else  
           {  
                echo '<script>alert("Item Already Added")</script>';  
                echo '<script>window.location="index.php"</script>';  
           }  
      }  
      else  
      {  
           $item_array = array(  
                'item_id'               =>     $_GET["id"],  
                'item_title'               =>     $_POST["hidden_title"],
                'item_price'              =>    $_POST["hidden_price"],
                'item_rest'              =>      $_POST["hidden_restaurant"]   
           );  
           $_SESSION["order_table"][0] = $item_array;  
      }  
 }  
}


//Sending recieved order to database
function get_order(){
  if(!empty($_SESSION["order_table"]))  
{
           
foreach($_SESSION["order_table"] as $keys => $values)  
{
$food_title = $values["item_title"];
$food_price = $values["item_price"];
$food_rest  = $values["item_rest"];
$food_customer = $_SESSION['username'];

}
    
}
$query1 = "CREATE TABLE IF NOT EXISTS orders(order_name varchar(20), order_price int(3), order_rest varchar(20), order_customer varchar(20))";
query($query1);
$query= query("INSERT INTO orders (order_name, order_price, order_rest, order_customer) 
  VALUES ('{$food_title}','{$food_price}','{$food_rest}','{$food_customer}' )");
  confirm($query);
  
}  

//Used To Show orders table from the Database into the DOM
function show_order(){
  $current_rest = $_SESSION['rest_name'];
  $query = query("SELECT * FROM orders");
  confirm($query);
  while($row = fetch_array($query)){
  if($current_rest == $row['order_rest']){
$show_order_table = <<<DELIMETER
<tr>
<td>{$row['order_name']}</td>
<td>{$row['order_price']}</td>
<td>{$row['order_rest']}</td>
<td>{$row['order_customer']}</td>
</tr>
DELIMETER;

echo $show_order_table;

    }
  }
}

//Used to get categories from Category Table
function get_categories(){
global $query2;
$query2 = "SELECT * FROM categories"; //Selecting from the categories table from food.db
query($query2);
while($row = fetch_array($query2)){ //Treating the above query as an Array
$category_links = <<<DELIMETER
 <a href='menu.php?type={$row['cat_title']}' class='list-group-item'>{$row['cat_title']}</a>
DELIMETER;
 
echo $category_links;
  }
}

//Used to Register the Restaurants
function register_rest(){

   if(isset($_POST['submit'])){
   
   $username = escape_string($_POST['username']);
   $email = escape_string($_POST['email']);
   $address = escape_string($_POST['address']);
   $password = escape_string($_POST['password']);

   $query2 = "CREATE TABLE IF NOT EXISTS restaurants(rest_name varchar(20), rest_email varchar(20), rest_addr varchar(20), rest_pass varchar(20))";
   query($query2);
   $query1 = query("INSERT INTO restaurants (rest_name, rest_email, rest_addr, rest_pass) 
    VALUES
    ('{$username}', '{$email}', '{$address}', '{$password}')");
   confirm($query1);
    set_msg("Registration Successfull!");
   }
}

//Used to Register the Customers
function register_custom(){

   if(isset($_POST['submit'])){
   
   $firstname = escape_string($_POST['firstname']);
   $lastname = escape_string($_POST['lastname']);
   $username = escape_string($_POST['username']);
   $address = escape_string($_POST['address']);
   $email = escape_string($_POST['email']);
   $prefer = escape_string($_POST['prefer']);
   $password = escape_string($_POST['password']);
   

   
   $query1 = "CREATE TABLE IF NOT EXISTS customers(first_name varchar(30), last_name varchar(30), username varchar(30), address varchar(30), email varchar(30), preference varchar(30), password varchar(10))";
   query($query1);
   $query = query("INSERT INTO customers (first_name, last_name, username, address, email, preference, password) 
    VALUES
    ('{$firstname}', '{$lastname}', '{$username}', '{$address}', '{$email}', '{$prefer}', '{$password}')");
   confirm($query);
    set_msg("Registration Successfull!");
   }
}

//Used to Login the Customers
function login_customer(){

   if(isset($_POST['submit'])){
    $username = escape_string($_POST['username']);
    $password = escape_string($_POST['password']);

  $query1 = "SELECT * FROM customers WHERE username = '{$username}' AND password = '{$password}'";
  $query2=query($query1);
   if(mysqli_num_rows($query2) == 0){ //In case the query returns nothing then the redirect back to login page
   	redirect("login_customer.php");
   	set_msg("Wrong Password/Username");
   } 
   else{
   while ($row = fetch_array($query2)) {
   $_SESSION['username'] = $username;
   // set_msg("Welcome {$username}");
   	
   redirect("index.php?id={$row['customer_id']}");
   }
     }
        }
           }
           

//Used to Login the Restaurants
function login_rest(){

   if(isset($_POST['submit'])){
    $rest_name = escape_string($_POST['rest_name']);
    $rest_pass = escape_string($_POST['rest_pass']);

  $query = query("SELECT * FROM restaurants WHERE rest_name = '{$rest_name}' AND rest_pass = '{$rest_pass}'");
  confirm($query);
  

   if(mysqli_num_rows($query) == 0){ //In case the query returns nothing then the redirect back to login page
   	redirect("login_rest.php");
   	set_msg("Wrong Password/Username");
   } 
   else{
   	while ($row = fetch_array($query)) {

   $_SESSION['rest_name'] = $rest_name;
   // set_msg("Welcome {$rest_name}");
   redirect("restaurant/index.php?id={$row['rest_id']}");
   }
     }
        }
           }

//Doesn't allow non restaurant users to access the Admin Dashboard            
function login_check_customer(){ 
if(!isset($_SESSION['username'])){
redirect("login_customer.php");
}
  }


function get_admin_content(){
   global $connection;
   $query1 = "SELECT * FROM restaurants";
   $query2 = query($query1);
   while ($row = fetch_array($query2)) {
   if($_SERVER['REQUEST_URI'] == "/foodapp/public/restaurant/" || $_SERVER['REQUEST_URI'] == "/foodapp/public/restaurant/?id={$row['rest_name']}" || $_SERVER['REQUEST_URI'] == "/foodapp/public/restaurant/index.php?id={$row['rest_name']}" ){
   include(TEMPLATE_BACK . "/admin_content.php");
  } 

      }
    if(isset($_GET['orders'])){
    include(TEMPLATE_BACK . "/orders.php");
    }
    if(isset($_GET['add_product'])){
    include(TEMPLATE_BACK . "/add_product.php");
    }
    
  }

//Doesn't allow non restaurant users to access the Admin Dashboard


function login_check_rest(){ 
if(!isset($_SESSION['rest_name'])){
redirect("../../public/login_rest.php");
}
  }

//Used to Add Menu items to the menu page in the index.php
function add_menu_item(){
   if(isset($_POST['submit'])){
   $product_title = escape_string($_POST['product_title']);
   $product_restaurant =  $_SESSION['rest_name'];
   $product_price = escape_string($_POST['product_price']);
   $product_category = escape_string($_POST['product_category']);
   $product_image = $_FILES['image']['name'];
   $product_image_temp = $_FILES['image']['tmp_name'];

   move_uploaded_file($product_image_temp , UPLOAD_DIRECTORY . DS . $product_image);
   $query1 = "CREATE TABLE IF NOT EXISTS menus(menu_title varchar(30) primary key, menu_restaurant varchar(30), menu_price int(5), menu_type varchar(30), menu_image varchar(50))";
   query($query1); 

   $query = query("INSERT INTO menus (menu_title, menu_restaurant, menu_price, menu_type, menu_image) 
    VALUES('{$product_title}', '{$product_restaurant}', '{$product_price}', '{$product_category}', '{$product_image}')");
   query($query);
    set_msg("Items Added Successfully!");
}
  }
?>