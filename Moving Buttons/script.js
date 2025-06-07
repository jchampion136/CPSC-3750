/*
  File: script.js
  Author: Jackson Champion
  Date: 2025-06-07
  Course: CPSC 3750 – Web Application Development
  Purpose: Adds function to generate buttons and change color on screen
  Notes: Creates Functions implemented in buttonmove.html
*/

var startbtn = document.getElementById("makeBtn"); 
startbtn.addEventListener("click", generateBtn);
var numBtn = 0;

function generateBtn() {
    var color = document.getElementById("colorSelect").value;
    var btn = document.createElement("button");

    btn.innerHTML = Math.floor(Math.random() * 10);
    btn.style.position = "absolute";
    var x_pos = Math.floor(Math.random() * 700);
    var y_pos = Math.floor(Math.random() * 400);
    btn.style.left = x_pos + 'px';
    btn.style.top = y_pos + 'px';
    btn.style.backgroundColor = color;
    btn.style.color = "black";
    btn.className = "btn btn-secondary";
    btn.id = numBtn++;

    document.querySelector(".viewingArea").appendChild(btn);

    btn.onclick = function () {
        console.log(this.id);
        this.innerHTML = Math.floor(Math.random() * 888) + 100;
        var currentColor = document.getElementById("colorSelect").value;
        this.style.backgroundColor = currentColor;
    };
}
