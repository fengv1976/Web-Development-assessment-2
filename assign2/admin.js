function createRequest() {
  var xhr = false;
  if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
  }
  return xhr;
}

var xhr = createRequest();

function getData(dataSource, divID, input) {
  if (xhr) {
    var place = document.getElementById(divID);
    var requestbody = "&input=" + encodeURIComponent(input);
    xhr.open("POST", dataSource, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      alert(xhr.readyState);
      if (xhr.readyState == 4 && xhr.status == 200) {
        place.innerHTML = xhr.responseText;
      }
    };
    xhr.send(requestbody);
  }
}
