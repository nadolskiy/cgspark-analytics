function update_redirection_table() {
  asyncCall({
      action: "get",
      error: "Can't get the list of all redirects",
    },
    "db"
  );
}

function update_counters() {
  asyncCall({
      action: "counter",
      error: "Can't get the list of all redirects",
    },
    "db"
  );
}


// [AJAX] Async Call
function asyncCall(argsObject, php_file_name) {
  // Check for arguments
  if (argsObject && typeof argsObject != "object") {
    console.log("This function get only arguments object.");
    return;
  } // [x] if (argsObject && typeof argsObject != "object") { ... }

  // AJAX
  $.ajax({
    url: document.location.origin +
      "/wp-content/plugins/page-redirection/functions/" +
      php_file_name +
      ".php",
    method: "GET",
    contentType: "application/json; charset=utf-8",
    data: argsObject,

    // Succes
    success: (data) => {
      // console.log(data);

      if (argsObject.action === 'get') {

        $('#rp-list').html(data);

        // On Remove Button Clicked
        $('.pr-button--remove').on('click', (e) => {

          const popup = new PopUp('', $(e.target).attr("data-source"), $(e.target).attr("data-target"));
          popup.delete();

        });

      } else if (argsObject.action === 'add') {
        update_redirection_table();
      } else if (argsObject.action === 'remove') {
        update_redirection_table();
      } else if (argsObject.action === 'counter') {

        let counter = data.split('~[N]~');

        const
          period24h = document.getElementById("value-24h-change"),
          period1w = document.getElementById("value-1w-change"),
          period1m = document.getElementById("value-1m-change"),
          period1y = document.getElementById("value-1y-change"),
          periodAll = document.getElementById("value-all-change");

        animateValue(period24h, 0, parseInt(counter[0]), getDurationSpeed(counter[0]));
        animateValue(period1w, 0, parseInt(counter[1]), getDurationSpeed(counter[1]));
        animateValue(period1m, 0, parseInt(counter[2]), getDurationSpeed(counter[2]));
        animateValue(period1y, 0, parseInt(counter[3]), getDurationSpeed(counter[3]));
        animateValue(periodAll, 0, parseInt(counter[4]), getDurationSpeed(counter[4]));
      }


    }, // success

    // Error
    error: () => {
      // Show error msg if exist
      if (argsObject.error) {

      } // [x] if (argsObject.error) { ... }

      console.error("Something wrong in asyncCall() function. 😔");
    }, // [x] error
  }); // [x] ajax
} // [x] function asyncCall(argsObject, php_file_name) { ... }

function animateValue(obj, start, end, duration) {
  let startTimestamp = null;
  const step = (timestamp) => {
    if (!startTimestamp) startTimestamp = timestamp;
    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
    obj.innerHTML = Math.floor(progress * (end - start) + start);
    if (progress < 1) {
      window.requestAnimationFrame(step);
    }
  };
  window.requestAnimationFrame(step);
}


// 10
function getDurationSpeed(count) {
  if (count < 10) return 1000;
  else if (count < 100) return 2000;
  else if (count < 500) return 3000;
  else if (count < 750) return 4000;
  else return 5000;
}