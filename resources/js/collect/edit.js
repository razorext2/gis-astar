import { quillEditor } from "./func/quillEditor";
import { backCameraStream } from './func/cameraStream';
import { editDataHandler } from "./func/formHandler";
import { zoomImage } from "./func/zoomImage";
import { getLocation } from './func/geoLocation';

$(document).ready(function () {
  $('#have_paid').change(function () {
    const have_paid = $(this).val();
    const have_paid_container = $('#have_paid_container');
    const payment_amount_container = $('#payment_amount_container');
    const payment_type_container = $('#payment_type_container');
    const payment_amount = $('#payment_amount');
    const payment_type = $('#payment_type');
    const no_giro_container = $('#no_giro_container');

    if (have_paid != 1 && have_paid != 2) {

      have_paid_container.removeClass('lg:col-span-1 ');
      payment_amount_container.addClass('hidden');
      payment_type_container.addClass('hidden');
      no_giro_container.addClass('hidden');

      payment_amount.val('0');
      payment_type.val('0');
      $('#no_giro').val('0');

    } else {
      have_paid_container.addClass('lg:col-span-1 ');
      payment_amount_container.removeClass('hidden');
      payment_type_container.removeClass('hidden');
    }
  });

  $('#payment_type').on('change', function () {
    const payment_type = $(this).val();
    const no_giro_container = $('#no_giro_container');

    if (payment_type == 3) {
      no_giro_container.removeClass('hidden');
    } else {
      no_giro_container.addClass('hidden');
      $('#no_giro').val('0');
    }
  });

  quillEditor(data, true);
  backCameraStream();
  editDataHandler();
  zoomImage();
  getLocation();
});