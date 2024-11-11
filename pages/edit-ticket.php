
<?php
 $ticket_id="";
 $img="";
 $ticket_name="";
 $ticket_price="";
 $ticket_author="";
   function getTicket($id) {
    global $wpdb;

    $query = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}tickets_system WHERE id = %d", $id);
    $result = $wpdb->get_row($query, ARRAY_A);

    return $result;
   }
   if(isset($_GET['id'])){
    $ticket_id = $_GET['id'];

    $img = getTicket($ticket_id)['profile_image'];
    $ticket_name= getTicket($ticket_id)['name'];
    $ticket_author= getTicket($ticket_id)['author'];
    $ticket_price = getTicket($ticket_id)['ticket_price'];
   }
?>
<div class="tms-container">
<h1 style="text-align: center;">Edit Ticket</h1>
<?php
if(!empty($response)){

    ?>
<p id="save-response"> <?php echo $response; ?> </p>
<?php
 }?>
<form action="" id="frm-add-book" method="post">
    <input type="hidden" name="ticket_id" value="<?php echo $ticket_id;?>">
<img src="<?php echo $img;?>" alt="ticket-image" width="200" height="200"/>
<div class="form-input">

            <label for="ticker_name">Ticket Name</label>

            <input type="text"value="<?php echo $ticket_name;?>" required name="ticket_name" id="ticket_name" placeholder="Enter Ticket name" class="form-group tms-text-center">
        </div>
        <div class="form-input">

<label for="ticker_name">Author Name</label>

<input type="text"value="<?php echo $ticket_author;?>" required name="author_name" id="author_name" placeholder="Enter Author name" class="form-group tms-text-center">
</div>
<div class="form-input">

<label for="ticker_name">Price</label>

<input type="text"value="<?php echo $ticket_price;?>" required name="ticket_price" id="author_name" placeholder="Enter Ticket Price" class="form-group tms-text-center">
</div>
<div class="form-input">

            <label for="">Current Image</label>
             <img src="<?php echo $img;?>" id="" alt="" width="100" height="100">
             <input type="text" value="<?php echo $img;?>" placeholder="" name="cover_image" id="cover_image-input" class="form-group" readonly > 
            <label for="">New Image</label>
            <img src="" id="cover_image" alt="" width="100" height="100">
            <button class="btn" id="btn-upload-cover" type="button">Upload Cover Image</button>
        </div>
<button type="submit" name="btn_form_submit" class="btn-update">Update</button>
</form>
</div>
