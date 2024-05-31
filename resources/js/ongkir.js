$('select[name="province_origin"]').on("change", function () {
    let provinceId = $(this).val();

    // panggil kota berdasarkan provinceId yang dipilih dengan ajax
    if (provinceId) {
        jQuery.ajax({
            url: "/api/province/" + provinceId + "/cities",
            tyle: "GET",
            dataType: "JSON",
            success: function (data) {
                $('select[name="city_origin"]').empty();
                $.each(data, function (key, value) {
                    $('select[name="city_origin"]').append(`
                    <option value="${key}">${value}</option>
                    `);
                });
            },
        });
    } else {
        $('select[name="city_origin"]').empty();
    }
});
