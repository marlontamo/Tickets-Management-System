<?php

if(!class_exists("BooksListTable")){

    include_once TMS_PLUGIN_PATH . 'classes/TicketsListTable.php';
}

$bookListTableObject = new TicketsListTable();

echo "<h1>List Tickets</h1>";

// To run all logics
$bookListTableObject->prepare_items();

?>

<form id="frm_serch" method="get">

   <input type="hidden" name="page" value="list-books">

   <?php 

       // To add search box
       $bookListTableObject->search_box("Search Ticket", "search_ticket");

       // To display table
       $bookListTableObject->display();

   ?>

</form>