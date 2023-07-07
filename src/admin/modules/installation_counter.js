;(function ($) {
  function bkbm_dabp_installation_counter() {
    return $.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        action: "bkbm_dabp_installation_counter", // this is the name of our WP AJAX function that we'll set up next
        product_id: BkbmDabpAdminData.product_id,
      },
      dataType: "JSON",
    })
  }

  if (typeof BkbmDabpAdminData.installation != "undefined" && BkbmDabpAdminData.installation != 1) {
    $.when(bkbm_dabp_installation_counter()).done(function (response_data) {
      console.log(response_data)
    })
  }
})(jQuery)
