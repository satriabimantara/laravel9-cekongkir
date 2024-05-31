/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/ongkir.js ***!
  \********************************/
$(function () {
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
            $('select[name="city_origin"]').append("\n                        <option value=\"".concat(key, "\">").concat(value, "</option>\n                        "));
          });
        }
      });
    } else {
      $('select[name="city_origin"]').empty();
    }
  });
  $("#city_destination").select2({
    ajax: {
      url: "/api/cities",
      type: "POST",
      dataType: "JSON",
      delay: 150,
      data: function data(params) {
        return {
          _token: $('meta[name="csrf-token"]').attr("content"),
          search: params.term
        };
      },
      processResults: function processResults(response) {
        return {
          results: response
        };
      },
      cache: true
    }
  });
});
/******/ })()
;