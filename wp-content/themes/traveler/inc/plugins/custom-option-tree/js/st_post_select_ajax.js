/**
 * Created by me664 on 11/24/14.
 */
jQuery(function($){
    $('.st_post_select_ajax').each(function(){
        var me=$(this);
        $(this).select2({
            placeholder: me.data('placeholder'),
            minimumInputLength:2,
            allowClear: true,
            width: '100%',
            ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                url: ajaxurl,
                dataType: 'json',
                quietMillis: 250,
                data: function (term, page) {
                    return {
                        q: term, // search term,
                        action:'st_post_select_ajax',
                        post_type:me.data('post-type')
                    };
                },
                processResults: function (data, params) {
                    return {
                      results: $.map(data.items, function(obj) {
                        return {
                          id: obj.id,
                          text: obj.name
                        };
                      })
                    };
                },
                cache: true
            },
            escapeMarkup: function(m) { return m; }
        });
    });
});
