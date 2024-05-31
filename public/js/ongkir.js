/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/ongkir.js ***!
  \********************************/
$('select[name="province_origin"]').on("change", function () {
  var provinceId = $(this).val();

  // panggil kota berdasarkan provinceId yang dipilih dengan ajax
  if (provinceId) {
    jQuery.ajax({
      url: "/api/province/" + provinceId + "/cities",
      tyle: "GET",
      dataType: "JSON",
      success: function success(data) {
        $('select[name="city_origin"]').empty();
        $.each(data, function (key, value) {
          $('select[name="city_origin"]').append("\n                    <option value=\"".concat(key, "\">").concat(value, "</option>\n                    "));
        });
      }
    });
  } else {
    $('select[name="city_origin"]').empty();
  }
});
/******/ })()
;