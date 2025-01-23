import {showDatatables} from "./func/showData";
import {addDataHandler} from "./func/formHandler";
import {changeState} from "./func/changeState";
import {deleteData} from "./func/delete";

$(document).ready(function () {
  showDatatables();
  addDataHandler();
  changeState();
  deleteData();

  $('body').on('click', '#edit-btn', function () {
    let id = $(this).data('id');
    console.log('tombol edit diklik');
  });

});