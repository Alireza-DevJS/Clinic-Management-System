console.log("datePicker loaded");
$("#datePicker").pDatepicker({
  format: "YYYY/MM/DD",
  initialValue: false,
  autoClose: true,
  calendar: {
    persian: {
      locale: "fa",
    },
  },

  minDate: new persianDate().valueOf(),
  onSelect: function () {
    const date = $("#datePicker").val();

    console.log(date);
  },
});

