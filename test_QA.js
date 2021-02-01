var colorArray = ["#5A9C6E", "#A8BF5A", "#FAC46E", "#FAD5BB", "#F2FEFF"]; 
var i = 0; 

function changeColor(){
    document.body.style.background = colorArray[i]; 
    i++;
    if( i > colorArray.length - 1){
        i = 0;
    }
}