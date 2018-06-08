/* Captures the list of numbers entered by the user, parses the numbers, and populates
		an array based on the list */
	
//Array to hold numbers

//global variables

//Create global array
var cleanedArray = new Array();

function clearEntries()
{
	var listItems = document.getElementsByClassName("textInput");
	var indItems = document.getElementsByClassName("individualInput");
	
	for (var i=0; i < listItems.length; ++i)
	{
		listItems[i].style.display = "none";
	}
	
	for (var i=0; i < indItems.length; ++i)
	{
		indItems[i].style.display = "none";
	}
	
	document.getElementById("textInputForm").reset();
	removeOptions(document.getElementById("inputSelector"));
}

function removeOptions(selectbox)
{
    var i;
    for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
    {
        selectbox.remove(i);
    }
}

function optionListReset()
{
	removeOptions(document.getElementById("inputSelector"));
}

//using the function:
removeOptions(document.getElementById("mySelectObject"));

function setList()
{
	//alert("list was set");
	clearEntries();
	
	var listItems = document.getElementsByClassName("textInput");
	
	for (var i=0; i < listItems.length; ++i)
	{
		listItems[i].style.display = "block";
	}
}

function setIndividual()
{
	//alert("individual set");
	clearEntries();
	
	var listItems = document.getElementsByClassName("individualInput");
	
	for (var i=0; i < listItems.length; ++i)
	{
		listItems[i].style.display = "block";
	}
}


function parseNumbers()
{
	var numString = document.getElementById("textBoxData").value;
	numString = numString.trim(); //removes leading and trailing white space

	//split the string based on whitespace or comma delimiters
	var regExpr = new RegExp(/[\s,]+/);
	
	//use global array so that it is available outside function scope
	cleanedArray = numString.split(regExpr);
			
	//document.getElementById("answerArea").innerHTML = cleanedArray;
}

function getStats(id)
{
	//if this is the raw text input
	if (id == "buttonTextInput")
	{
		parseNumbers();
		//return N 
 		document.getElementById("numValues").value = cleanedArray.length;
 		//return summation
 		var sum = calculateSum(cleanedArray);
 		document.getElementById("sum").value = sum.toFixed(2);
		//return mean
		var mean = calculateMean(cleanedArray);
		document.getElementById("mean").value = mean.toFixed(2);
		//return median
		var median = calculateMedian(cleanedArray);
		document.getElementById("median").value = median.toFixed(2);
		//return mode
		var mode = calculateMode(cleanedArray);
		document.getElementById("mode").value = mode;
		//return variance
		var variance = calculateVariance(cleanedArray);
		document.getElementById("variance").value = variance.toFixed(2);
		//return std deviation
		var stdDev = calculateStdDev(cleanedArray);
		document.getElementById("stddev").value = stdDev.toFixed(2);
	}
	if (id == "buttonListInput")
	{
			var tempArray= new Array();
			var inputs = document.getElementById("inputSelector");
			for (i = 0; i < inputs.options.length; i++) 
			{
   				tempArray[i] = inputs.options[i].value;
			}
			//set cleaned array here
			cleanedArray = tempArray;
			
			//return N 
 			document.getElementById("numValues").value = cleanedArray.length;
 			//return summation
 			var sum = calculateSum(cleanedArray);
 			document.getElementById("sum").value = sum.toFixed(2);
			//return mean
			var mean = calculateMean(cleanedArray);
			document.getElementById("mean").value = mean.toFixed(2);
			//return median
			var median = calculateMedian(cleanedArray);
			document.getElementById("median").value = median.toFixed(2);
			//return mode
			var mode = calculateMode(cleanedArray);
			document.getElementById("mode").value = mode;
			//return variance
			var variance = calculateVariance(cleanedArray);
			document.getElementById("variance").value = variance.toFixed(2);
			//return std deviation
			var stdDev = calculateStdDev(cleanedArray);
			document.getElementById("stddev").value = stdDev.toFixed(2);
	}
}

function calculateSum(array)
{
	var sum = 0;
	for (var i = 0; i < array.length; ++i)
	{
		sum += parseFloat(array[i]);
	}
	
	return sum;
}
		
function calculateMean(array)
{
	var accum = calculateSum(array);

	var mean = accum / array.length;
	
	return mean;
}

function calculateMedian(array)
{
	//sort the array - note that a custom sort is required
	//the result will remain even after the function terminates
	var median = 0;
	
	//sort the array in ascending order
	array.sort(function numberSort(a,b){ return b - a });
	
	//determine if there is an even number of elements
	if ((array.length % 2) == 0)
	{
		var length = array.length;
		
		var num1 = Math.floor((length / 2)) - 1;  //lower middle
		var num2 = Math.floor((length / 2)); //upper middle
		
		median = ((parseFloat(array[num1]) + parseFloat(array[num2])) / 2);	
	}
	else // there is an odd number of elements
	{
		//integer divide and take lower number
		var middle = Math.floor(array.length / 2);
		
		median = parseFloat(array[middle]);
	}	
	return median;
}

function calculateMode(array)
{	
	//create two arrays - one that holds values and the other that holds the number of 
	//occurrences for each value
	//example:
	//[100 200 300] : value array
	//[ 1   3   4 ] : occurence array
	
	const valueArray = new Array();
	const occurrenceArray = new Array();
	
	for (var i=0; i < array.length; ++i)
	{
		var value = parseFloat(array[i]); //converts array value to Integer
		//determine if the value is already in the valueArray
		var isThere = valueArray.indexOf(value); //will return index if it exists, -1 otherwise
		if (isThere == -1 ) //not found
		{
			valueArray.push(value);
			occurrenceArray.push(1); // add once occurence to occurenceArray
		}
		else //index found
		{
			++occurrenceArray[isThere]; //increment value stored in corresponding occurence array
		}
	}
	
	
	
	//Now loop through the occurenceArray and find the index with the highest value
	var maxIndex = 0;
	var maxValue = 0;
		
	maxValue = Math.max.apply(Math,occurrenceArray); //returns max value in occurence array
	
	//consider the possibility that there is no mode
	if (maxValue == 1)
	{
		return "No Mode";
	}
		
	//now, we need to determine ALL the indexes that have the same value
	var modeIndexes = new Array();
		
	//arguments = (item, index, array)
	const verifyMaxFn = function(item, index)
	{
		if (item == maxValue) //if the occurence item is equal to the 
		{
			this.push(index); //push the index to the array
		}
	}
	
	occurrenceArray.forEach(verifyMaxFn, modeIndexes); //mode index array will now be populated
	
	//alert(modeIndexes);
	
	var modesArray = new Array();
		
	const addValues = function(item)
	{
		this.push(valueArray[item]);
	}
		
	modeIndexes.forEach(addValues, modesArray);
	
	//alert(modesArray);
	
	return modesArray;
}


function calculateVariance(array)
{
	//Variance = (sum(x1^2+x2^2...+xn^2) - sum^2/n) / n-1
	var sumOfSquares = 0;
	
	//calculate first component
	const squareValueSums = function(item)
	{
		sumOfSquares += Math.pow(item, 2);
	}
	
	array.forEach(squareValueSums);
	
	var sum = calculateSum(array);
	
	var sumSquared = Math.pow(sum,2);
	
	var n = array.length;
	
	var variance = (sumOfSquares - (sumSquared / n)) / (n-1);
	
	return variance;
}

function calculateStdDev(array)
{
	var variance = calculateVariance(array);
	
	var stdDev = Math.sqrt(variance);
	
	return stdDev;
}

function addNumber()
{
	var inputBox = document.getElementById('inputBox');
	var inputBoxValue = inputBox.value;
	//prevent empty value entries
	if (!(isNaN(parseFloat(inputBoxValue)))) //if it is a valid number
	{
		var list = document.getElementById('inputSelector');
		var option = document.createElement('option');
		option.text = inputBoxValue;
		list.options.add(option);
		inputBox.value = "";
	}
	else //clear the input Box
	{
		inputBox.value = "";
	}
}

function removeNumber()
{
	var optionList = document.getElementById("inputSelector");
	var indexToRemove = optionList.selectedIndex;
	optionList.remove(indexToRemove);
}

function resetRadios()
{
	document.getElementById("selectMethod").reset();
}