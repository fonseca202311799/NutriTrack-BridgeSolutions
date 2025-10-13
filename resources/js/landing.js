import './bootstrap';
import '../css/landing.css';




const tablinks = document.getElementsByClassName("tab-links");
const tabcontents = document.getElementsByClassName("tab-contents");

function openTab(tabName) {

    for (let link of tablinks) {
        link.classList.remove("active-link");

    }
    for (let content of tabcontents) {
        content.classList.remove("active-tab");

        event.currentTarget.classList.add("active-link");
        document.getElementById(tabName).classList.add("active-tab")
    }

}

/*
const greetings = document.getElementById("greetings");
const date = new Date();
const currentTime = date.getHours();
let greetText = "";

const greetingMessage = () => {

let greetText = "";

if (currentTime < 12) {
      greetText = "Good Morning";
    } else if (currentTime < 18) {
      greetText = "Good Afternoon";
    } else {
      greetText = "Good Evening";
    }
    greetings.textContent = greetText;
}

greetingMessage();
*/

document.getElementById("contactForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const name = document.getElementById("name").value.trim();
      const email = document.getElementById("email").value.trim();
      const message = document.getElementById("message").value.trim();

      if (name === "" || email === "" || message === "") {
        alert("All fields are required!");
        return;
      }
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        alert("Enter a valid email.");
        return;
      }
      alert("Message sent successfully!");
      this.reset();
    });
