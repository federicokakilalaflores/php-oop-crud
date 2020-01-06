<?php 

     // pagination variables
    if(isset($_GET['page']) && is_numeric($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = 1;
    }
    $record_per_page = 2;
    $page_start_num = ($record_per_page * $page) - $record_per_page;
    $total_pages = ceil($total_row / $record_per_page);
    $range = 2;
    $initial_num = $page - $range;
    $trailing_num = ($page + $range) + 1;

?>    