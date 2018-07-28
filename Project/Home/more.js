function showResults() {
    jQuery("#overlay").fadeIn(100);
    //document.getElementById("overlay").style.display = "block";
}

function hideResults() {
    jQuery("#overlay").fadeOut(100);
    //document.getElementById("overlay").style.display = "none";
}

function getCategories(category, divID) {

    if(category == "allCats") {
        catInputs();
    }
    
    var xmlhttp = new XMLHttpRequest();
  
      xmlhttp.onreadystatechange = function() {
  
          if(this.readyState == 4 && this.status == 200) {
              
              document.getElementById(divID).innerHTML = this.responseText;
  
          }
      };

      xmlhttp.open("GET", "../categories/cats.php?category=" + category, true);
      xmlhttp.send();
}

function catInputs() {

    var xmlhttp = new XMLHttpRequest();
  
      xmlhttp.onreadystatechange = function() {
  
          if(this.readyState == 4 && this.status == 200) {
              
              document.getElementById("filter").innerHTML = this.responseText;
  
          }
      };

      xmlhttp.open("GET", "../categories/cats.php?category=listGenres", true);
      xmlhttp.send();
}