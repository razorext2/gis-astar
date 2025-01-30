import { addDataHandler } from "./func/formHandler";
import { searchDataHandler } from './func/searchHandler';

$(document).ready(function () {
  searchDataHandler();
  addDataHandler();

  // $('#remaining_bill, #remaining_bill_bsi, #total_bill')
  //   .addClass('cursor-not-allowed')
  //   .prop('readonly', true);
});
