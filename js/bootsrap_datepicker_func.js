/***************************************************
 * BY: Randy S. Baker
 * ON: 15-DEC-2018
 * FILE: bootstrap_datepicker_func.js
 * NOTE: BS DatePicker scripts & helpers...
 ***************************************************/

/**************************************
 * Helper scripts...
 **************************************/
const _0x2eca = [
  "getFullYear",
  "getMonth",
  "getDate",
  "changeDate",
  "date",
  "datepicker",
  "setDate",
  "update",
  "focus",
  "#check_out",
  "on",
  "#check_in"
];
const nowTemp = new Date();
const now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
const checkin = $("#check_in")
  .datepicker({
    todayHighlight: true,
    beforeShowDay: function(_0xe23cx6) {
      return _0xe23cx6.valueOf() >= now.valueOf();
    },
    autoclose: true
  })
  .on("changeDate", function(_0xe23cx4) {
    if (_0xe23cx4.date.valueOf() > checkout.datepicker("getDate").valueOf() || !checkout.datepicker("getDate").valueOf())
    {
      const _0xe23cx5 = new Date(_0xe23cx4.date);
      _0xe23cx5.setDate(_0xe23cx5.getDate() + 1);
      checkout.datepicker("update", _0xe23cx5);
    }
    $("#check_out")[0].focus();
  });
const checkout = $("#check_out")
  .datepicker({
    beforeShowDay: function(_0xe23cx6) {
      if (!checkin.datepicker("getDate").valueOf()) {
        return _0xe23cx6.valueOf() >= new Date().valueOf();
      } else {
        return _0xe23cx6.valueOf() > checkin.datepicker("getDate").valueOf();
      }
    },
    autoclose: true
  })
  .on("changeDate", function(_0xe23cx4){});