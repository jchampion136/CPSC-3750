// Jackson Champion
// 2025-06-14
// CPSC 3750
// Program Exam #1 
// Completed Grade Level B

//Creates list of Prime and Non-Prime numbers
function createList() {
    prime = document.getElementById("primeList");
    nonPrime = document.getElementById("nonPrimeList");
    userInput = document.getElementById("number").value;

    if (userInput < 1 || userInput > 50) {
        alert("Please enter a number between 1 and 50.");
        return; 
    }
    
    //clears the list when a new number is entered
    prime.innerHTML = "";
    nonPrime.innerHTML = "";

    //Loops through numbers one through the entered value
    for (let i = 1; i <= userInput; i++) {
        li = document.createElement("li");
        li.textContent = i;
        
        //Creates a list of each number and adds to prime or non-prime list
        if (isPrime(i)) {
            prime.appendChild(li);
        } 
        else {
            nonPrime.appendChild(li);
        }
    }  
}

//Finds if number is prime or not
function isPrime(num) {
    if (num == 1) {
        return false;
    }
    for (i = 2; i <= Math.sqrt(num); i++) {
        if (num % i == 0) {
            return false;
        }
    }
    return true;
}
