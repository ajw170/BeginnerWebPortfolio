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

//Pass a productName and an HTML ID to displayGame, and it will
//insert that game's info into the corresponding element
//Pass the string "displayAll" and it will display all games in that element.
function displayGame(productID, divID) {

    var xmlhttp = new XMLHttpRequest();
  
      xmlhttp.onreadystatechange = function() {
  
          if(this.readyState == 4 && this.status == 200) {
              
              document.getElementById(divID).innerHTML = this.responseText;
  
          }
      };

      xmlhttp.open("GET", "../browse/showall.php?productID=" + productID, true);
      xmlhttp.send();
}

function searchGames(string, divID) {

  if(string.length == 0) {

      //Display nothing? Or just return
      //document.getElementById(divID).innerHTML = "";

      return;
  }
  
  else {

      var xmlhttp = new XMLHttpRequest();
  
      xmlhttp.onreadystatechange = function() {
  
          if(this.readyState == 4 && this.status == 200) {
              
              document.getElementById(divID).innerHTML = this.responseText;
  
          }
      };

      xmlhttp.open("GET", "../home/search.php?in1=" + string, true);
      xmlhttp.send();
  }
}

function addToCart(name,buttonNum)
{
    //alert(name);
    //alert(buttonNum);
    //might need a closure here to preserve value...
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
        var responseText = this.responseText;
      document.getElementById("cartButton" + buttonNum).innerHTML = responseText;
        }
    };
    xhttp.open("GET","./addToCart.php?productID=" + name + "&buttonNum=" + buttonNum, true); //asyncronous
    xhttp.send();
}

function removeFromCart(productID,buttonNum)
{
    //alert(productID);
    //alert(buttonNum);
    var productID = productID;
    var buttonNum = buttonNum;
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("cartButton" + buttonNum).innerHTML = this.responseText;
    }};
    xhttp.open("GET","./removeFromCart.php?productID=" + productID + "&buttonNum=" + buttonNum, true);
    xhttp.send();
    
    
}

function getGamesForSale()
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("gamesForSale").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","./getGamesForSale.php", true); //asyncronous
    xhttp.send();
}

function markForSale(productID,buttonNum)
{
    //alert(productID + buttonNum);
    var xhttp;
    xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("saleButtonProdID" + buttonNum).innerHTML = this.responseText;
        }
    };
    
    xhttp.open("GET","./markForSale.php?productID=" + productID + "&buttonNum=" + buttonNum,true);
    xhttp.send();
}

function unMarkForSale(productID,buttonNum)
{
    //alert(productID + buttonNum);
    var xhttp;
    xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("saleButtonProdID" + buttonNum).innerHTML = this.responseText;
        }
    };
    
    xhttp.open("GET","./unMarkForSale.php?productID=" + productID + "&buttonNum=" + buttonNum,true);
    xhttp.send();
}