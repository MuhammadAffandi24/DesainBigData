let clickCount = 0;
let isParagraphVisible = true;
let itemCounter = 2;

function changeHeading() {
  clickCount++;
  const heading = document.getElementById("h1");
  const message = [
    "You clicked me!",
    "You clicked me again!",
    "You really like clicking me, don't you?",
    "Okay, that's enough clicking for now.",
    "Seriously, stop clicking!",
    "Fine, you win. Click me again if you dare.",
  ];
  heading.textContent = message[clickCount % message.length];
  heading.style.color = "hsl(" + ((clickCount * 137.5) % 360) + ", 100%, 50%)";
}

function addStyles() {
  const heading = document.getElementById("h1");
  heading.style.fontFamily = "Arial, sans-serif";
  heading.style.textAlign = "center";
  heading.style.marginTop = "50px";
  heading.style.color = "hsl(0, 100%, 50%)";
}

document.addEventListener("DOMContentLoaded", function () {
  console.log("Demo Loaded Sucessfully");

  addStyles();

  document.querySelector("h1").addEventListener("click", changeHeading);
  document.querySelector("h1").style.cursor = "pointer";
  document.querySelector("h1").title = "Click me!";
});
