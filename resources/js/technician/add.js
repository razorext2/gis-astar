import { fetchDataHandler } from "./func/fetchData";
import { submitHandler } from "./func/submitHandler";

$(function () {
  fetchDataHandler();
  submitHandler();
})