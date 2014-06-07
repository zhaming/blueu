$().ready(function() {
    $('#district').change(function() {
        var selected = $(this).val();
        $.getJSON('/admin/merchantshop/district', {
            pid: selected
        }, function(items) {
            $('#district_sec option').remove();
            for (var i in items) {
                console.log(items[i]);
                $('#district_sec').append("<option value='" + (items[i]).id + "'>" + (items[i]).district + "</option>");
            }
        })
    });
    $('#category').change(function() {
        var selected = $(this).val();
        $.getJSON('/admin/merchantshop/category', {
            pid: selected
        }, function(items) {
            $('#category_sec option').remove();
            for (var i in items) {
                console.log(items[i]);
                $('#category_sec').append("<option value='" + (items[i]).id + "'>" + (items[i]).name + "</option>");
            }
        })
    });
});
