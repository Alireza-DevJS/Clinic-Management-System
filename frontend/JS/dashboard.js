const currentDate = document.getElementById("dashboardCurrentDate");

const today = new Date();

const formatter = new Intl.DateTimeFormat("fa-IR-u-ca-persian", {
  weekday: "long",
  day: "numeric",
  month: "long",
  year: "numeric",
  timeZone: "Asia/Tehran",
});

const parts = formatter.formatToParts(today);

const weekday = parts.find(part => part.type === "weekday").value;
const day = parts.find(part => part.type === "day").value;
const month = parts.find(part => part.type === "month").value;
const year = parts.find(part => part.type === "year").value;

currentDate.textContent = `${weekday}، ${day} ${month} ${year}`;