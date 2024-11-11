<div class="tms-container">

    <h1 style="text-align: center;">Add Ticket</h1>

    <?php 
      if(!empty($response)){

         ?>
    <p id="save-response"> <?php echo $response; ?> </p>
    <?php
      }
   ?>

    <form action="<?php echo admin_url('admin.php?page=tickets-system'); ?>" id="frm-add-book" method="post">

        <div class="form-input">

            <label for="ticker_name">Ticket Name</label>

            <input type="text" required name="ticket_name" id="ticket_name" placeholder="Enter name" class="form-group">
        </div>

        <div class="form-input">

            <label for="author_name">Author Name</label>

            <input type="text" required name="author_name" id="author_name" placeholder="Enter Author name"
                class="form-group">
        </div>

        <div class="form-input">

            <label for="ticket_price">Ticket Price</label>

            <input type="text" name="ticket_price" id="ticket_price" placeholder="Enter price" class="form-group">
        </div>

        <div class="form-input">

            <label for="">Cover Image</label>

            <input type="text" name="cover_image" id="cover_image-input" class="form-group" readonly>

            <button class="btn" id="btn-upload-cover" type="button">Upload Cover Image</button>
        </div>

        <button type="submit" name="btn_form_submit" class="btn">Submit</button>

    </form>

</div>