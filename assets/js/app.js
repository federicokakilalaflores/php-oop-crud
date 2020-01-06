$(document).ready(function(){

    // deleting product records
    $('.del-btn').on('click', function(ev){
        ev.preventDefault();

        var id = $(this).attr("data-id");
        bootbox.confirm({
            message: '<h4 class="text-dark">Are you sure?</h4>',
            buttons: {
                confirm: {
                    label: '<i class="fa fa-check"></i> Yes',
                    className: 'btn btn-success'
                },
                cancel: {
                    label: '<i class="fa fa-times"></i> No',
                    className: 'btn btn-danger'
                }
            },

            callback: function(result){ 

                if(result){
                    $.post(
                        "includes/product/delete.php",
                        {id: id},
                        function(response){
                            location.reload();
                        }
                    ).fail(function(){
                        alert("Unable to delete!"); 
                    });
                }

            }
        })
    });

});