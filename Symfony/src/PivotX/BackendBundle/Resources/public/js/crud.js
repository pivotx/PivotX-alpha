
var crud_tables = {};
var crud_last_toggle = -1;


/**
 * Activate the right text and update the count
 */
function updateTriSelect(el, value)
{
    switch (value) {
        case 0:
            $('.tri-1, .tri-x').hide();
            $('.tri-0').show();
            break;
        case 1:
            $('.tri-0, .tri-x').hide();
            $('.tri-1').show();
            break;
        default:
            $('.tri-0, .tri-1').hide();
            $('.tri-x .count').html(value);
            $('.tri-x').show();
            break;
    }
}

/**
 * Update the CRUD Meta information part
 * Update the toggle-checkbox
 */
function updateCrudMeta(crud_id)
{
    $('.crud-meta[data-crud-table="'+crud_id+'"]').each(function(){
        updateTriSelect($('.crud-selection .triselect'), crud_tables[crud_id].selection.length);

        if (crud_tables[crud_id].selection.length > 0) {
            $('.crud-selection a.btn').removeClass('disabled');
        }
        else {
            $('.crud-selection a.btn').removeClass('disabled').addClass('disabled');
        }
    });

    $('table[data-crud-table="'+crud_id+'"]').each(function(){
        if (crud_tables[crud_id].selection.length == $(this).attr('data-crud-page-length')) {
            $('thead th.select-checkbox input').attr('checked',true);
        }
        else {
            $('thead th.select-checkbox input').attr('checked',false);
        }
    });
}

$(function(){
    // Handler for .ready() called.

    $('table.crud').each(function(){
        var table_el = this;
        var crud_id = $(this).attr('data-crud-table');
        crud_tables[crud_id] = {
            selection: [],
            last_toggle: -1
        }

        // clear all (for browsers that 'cache' this)
        $('td.select-checkbox input',this).attr('checked',false);

        // count all
        var length = $('td.select-checkbox input',this).length;
        $(this).attr('data-crud-page-length',length);

        $('thead th.select-checkbox input',this).on('click',function(e){
            var checked = $(this).is(':checked');

            crud_tables[crud_id].selection = [];
            $('tbody td.select-checkbox input',table_el).each(function(){
                var id = $(this).attr('data-id');
                $(this).attr('checked', checked);
                if (checked) {
                    crud_tables[crud_id].selection.push(id);
                }
            });
            updateCrudMeta(crud_id);
        });

        $('tbody td.select-checkbox input',this).on('click',function(e){
            var id = $(this).attr('data-id');
            if ($(this).is(':checked')) {
                crud_tables[crud_id].selection.push(id);
            }
            else {
                var idx = -1;
                for(var i=0; i < crud_tables[crud_id].selection.length; i++) {
                    if (crud_tables[crud_id].selection[i] == id) {
                        idx = i;
                        break;
                    }
                }
                if (idx >= 0) {
                    crud_tables[crud_id].selection.splice(idx,1);
                }
            }

            updateCrudMeta(crud_id);

            crud_tables[crud_id].last_toggle = id;
        });

        updateCrudMeta(crud_id);

        $('a.crud-delete', this).on('click', function(e){
            var delete_el = this;

            e.preventDefault();

            modalDelete('Delete', '<p>Something about what we are about to delete</p>', function(){
                // @todo we should add feedback here

                modalProgressOpen('Deleting', '<p>Deleting the following item(s)..</p>');
                modalProgressUpdate(20,80,3000);

                $.ajax({
                    type: 'DELETE',
                    url: $(delete_el).attr('href'),
                    dataType: 'json',
                    success: function(data, textStatus, jqXHR){
                        if (data.code == 200) {
                            $('#default-modal div.modal-body').html('<p>'+data.message+'</p>');
                            modalProgressUpdate(80, 100, 1500);
                            if (typeof data.location != 'undefined') {
                                setTimeout('document.location = "' + data.location + '"', 1500);
                            }
                            else {
                                setTimeout('document.location = document.location', 1500);
                            }
                        }
                        else {
                            modalProgressClose();
                            modalMessageError('Error', data.message);
                        }
                    },
                    error: function(data, textStatus, jqXHR){
                        modalProgressClose();
                        modalMessageError('Error', '<p>Something unexpected went wrong.</p>');
                    }
                });
            });
        });
    });
});
