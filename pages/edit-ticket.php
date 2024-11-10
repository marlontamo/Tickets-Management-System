
<?php
   $ticket_id= $_GET['id'];

   function getTicket($id) {
    global $wpdb;

    $query = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}tickets_system WHERE id = %d", $id);
    $result = $wpdb->get_row($query, ARRAY_A);

    return $result;
   }
$img = getTicket($ticket_id)['profile_image'];
$ticket_name= getTicket($ticket_id)['name'];
$ticket_author= getTicket($ticket_id)['author'];
$ticket_price = getTicket($ticket_id)['ticket_price'];

//print_r(getTicket($ticket_id));
?>
<div class="tms-container">
<h1 style="text-align: center;">Edit Ticket</h1>
<form action="" id="frm-add-book" method="post">
<img src="<?php echo $img;?>" alt="ticket-image" width="200" height="200"/>
<div class="form-input">

            <label for="ticker_name">Ticket Name</label>

            <input type="text"value="<?php echo $ticket_name;?>" required name="ticket_name" id="ticket_name" placeholder="Enter name" class="form-group tms-text-center">
        </div>
        <div class="form-input">

<label for="ticker_name">Author Name</label>

<input type="text"value="<?php echo $ticket_author;?>" required name="author_name" id="author_name" placeholder="Enter name" class="form-group tms-text-center">
</div>
<div class="form-input">

<label for="ticker_name">Price</label>

<input type="text"value="<?php echo $ticket_price;?>" required name="author_name" id="author_name" placeholder="Enter name" class="form-group tms-text-center">
</div>
<button type="submit" name="btn_form_submit" class="btn-update">Update</button>
</form>
</div>
