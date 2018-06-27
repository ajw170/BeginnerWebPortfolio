/* JavaScript for Group 1 Project - Summer 2018 - COP4813 */


function getMyGames(){
  var xhttp;
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      document.getElementById("myGamesArea").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET","./getMyGames.php", true); //asyncronous
  xhttp.send();
}