$().ready(function() {
    ajaxDropDownList('/admin/merchantshop/category', $('#category').select().val(), '#category_sec')
    $('#category').change(function() {
        ajaxDropDownList('/admin/merchantshop/category', $(this).val(), '#category_sec')
    });

    ajaxDropDownList('/admin/merchantshop/district', $('#district').select().val(), '#district_sec')
    $('#district').change(function() {
        ajaxDropDownList('/admin/merchantshop/district', $(this).val(), '#district_sec')
    });
});

function ajaxDropDownList(url, id, dom) {
    $.getJSON(url, {pid: id}, function(items) {
        $(dom + ' option').remove();
        for (var i in items) {
            $(dom).append("<option value='" + (items[i]).k + "'>" + (items[i]).v + "</option>");
        }
    })
}

function districtDropDownList(selected) {
    $.getJSON('/admin/merchantshop/district', {
        pid: selected
    }, function(items) {
        $('#district_sec option').remove();
        for (var i in items) {
            //console.log(items[i]);
            $('#district_sec').append("<option value='" + (items[i]).id + "'>" + (items[i]).district + "</option>");
        }
    })
}

function categoryDropDownList(selected) {
    $.getJSON('/admin/merchantshop/category', {
        pid: selected
    }, function(items) {
        $('#category_sec option').remove();
        for (var i in items) {
            //console.log(items[i]);
            $('#category_sec').append("<option value='" + (items[i]).id + "'>" + (items[i]).name + "</option>");
        }
    })
}
