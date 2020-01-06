<ul class="pagination">
   <?php
        if($page > 1){
            echo '<li class="page-item"><a class="page-link" href="'.$page_url.'">First</a></li>';
            echo '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.($page - 1).'">&lt;</a></li>'; 
        }

        for($x = $initial_num; $x < $trailing_num; $x++){
            if($x > 0 && $x <= $total_pages){
                if($x == $page){
                    echo '<li class="page-item active"><a class="page-link" href="'.$page_url.'page='.$x.'">'.$x.'</a></li>';
                }else{
                    echo '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.$x.'">'.$x.'</a></li>';
                }
            }
        }

        if($page < $total_pages){
            echo '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.($page + 1).'">&gt;</a></li>'; 
            echo '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.$total_pages.'">Last</a></li>';
        }
   
   ?>
</ul>    