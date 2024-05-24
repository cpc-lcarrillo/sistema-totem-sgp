function getUrl() {
  const streaming= document.getElementById("stream")
  fetch('/SGT/public/get-json-data')
    .then(response => response.json())
    .then(jsonData => {
      // Now you can use the jsonData variable in your JavaScript code
      console.log(jsonData);
      var link = "https://www.youtube.com/embed/" + jsonData.link.split("=")[1] + "?autoplay=1&mute=0";
      console.log('Link: ' + link);
      streaming.src = link;
    })
    .catch(error => {
      console.error('Error loading JSON data: ' + error);
    });
}
document.addEventListener("DOMContentLoaded", function() {
  // Tu función aquí
  getUrl();
});