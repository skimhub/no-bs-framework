var moveProductCategory = function(category_id, move){
    var row = jQuery('#row_' + category_id);
    if (move == -1) {
        row.insertBefore(row.prev());
    } else {
        row.insertAfter(row.next());
    }

	jQuery.post("ajax/move_product_category.php", {
		category_id: category_id,
		move: move
	}, function(resp){

	});
}

var deleteProductCategory = function(category_id){
	var res = confirm("Are you sure you want to delete this category?");
	if (res){
		jQuery.post("ajax/delete_product_category.php", {
			category_id: category_id
		}, function(resp){
			jQuery('#row_' + category_id).fadeOut("fast");
		})
	}
}

var moveAddonCategory = function(category_id, move){
    var row = jQuery('#row_' + category_id);
    if (move == -1) {
        row.insertBefore(row.prev());
    } else {
        row.insertAfter(row.next());
    }

    jQuery.post("ajax/move_addon_category.php", {
        category_id: category_id,
        move: move
    }, function(resp){

    });
}

var deleteAddonCategory = function(category_id){
    var res = confirm("Are you sure you want to delete this category?");
    if (res){
        jQuery.post("ajax/delete_addon_category.php", {
            category_id: category_id
        }, function(resp){
            jQuery('#row_' + category_id).fadeOut("fast");
        })
    }
}

var ajaxUpload = function(field_name, path, url_prefix){
    var button = jQuery('#upload_' + field_name);
    new AjaxUpload(button,{
        action: 'ajax/thumbnail_upload.php', 
        data: {
        	path: path
        },
        name: 'userfile',
        onSubmit : function(file, ext){    
            this.disable();
        },
        onComplete: function(file, response){
        	response = eval("(" + response + ")");
        	console.log(response);

            if (response.status == 0){
                alert(response.message);
            } else {

                jQuery('#upload_' + field_name).attr("src", url_prefix + "/" + response.message);
                jQuery('#' + field_name).val(response.message);
            }
            
            this.enable();
        }
    });
}