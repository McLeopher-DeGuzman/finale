<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "exam";

$conn = null;

try {
    // Establish database connection
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if user is logged in
    if (isset($_SESSION['examineeSession']['exmne_id'])) {
        $exmneId = $_SESSION['examineeSession']['exmne_id'];

        // Select examinee's data using prepared statement
        $stmt = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_id=:exmneId");
        $stmt->bindParam(':exmneId', $exmneId);
        $stmt->execute();
        $selExmneeData = $stmt->fetch(PDO::FETCH_ASSOC);
        $exmneCourse = $selExmneeData['exmne_course'];
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 
  <title>Chatbot</title>
  <link rel="stylesheet" href="styles.css">
  <link rel = "shortcut icon" href = "../login-ui/images/UCS-removebg-preview.png">
</head>
<body>
  <div id="bot">
    <div id="container">
      <div id="header">
      <img src="ucs.png" alt="Chatbot Logo" class="logo" width="50">
        Career Advice Chat

      </div>

      <div id="body">
        <!-- This section will be dynamically inserted from JavaScript -->
        <div class="bot-reply messages" >
        <?php 
          if(isset($selExmneeData)){
            echo 'Congratulations, ' . strtoupper($selExmneeData["exmne_fullname"]) . '';
          }
        ?>
        </div>
      </div>

      <div id="inputArea">
        <input type="text" name="messages" id="userInput" placeholder="Please enter your message here" required>
        <button id="send">Send</button>
      </div>
    </div>
  </div>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
      // Function to send message
      function sendMessage() {
        let userMessage = document.querySelector("#userInput").value.trim();
        if (userMessage !== '') {
          let userHtml = '<div class="userSection">'+'<div class="messages user-message">'+userMessage+'</div>'+
          '<div class="seperator"></div>'+'</div>';
          document.querySelector('#body').innerHTML += userHtml;

          let xhr = new XMLHttpRequest();
          xhr.open("POST", "query.php");
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.send(`messageValue=${userMessage}`);

          xhr.onload = function () {
              if (xhr.status === 200) {
                  let botResponse = this.responseText;
                  let botHtml = '<div class="botSection">'+'<div class="messages bot-reply">'+botResponse+'</div>'+
                  '<div class="seperator"></div>'+'</div>';
                  document.querySelector('#body').innerHTML += botHtml;

                  // Add event listeners to clickable bot replies
                  let clickableBotReplies = document.querySelectorAll('.bot-reply');
                  clickableBotReplies.forEach(reply => {
                    reply.addEventListener('click', function(event) {
                      event.preventDefault(); // Prevent default link behavior
                      // Handle click action here
                      alert("You clicked on: " + this.textContent);
                    });
                  });
              } else {
                  console.error('Request failed: ' + xhr.status);
              }
          }
          // Clear input after sending message
          document.querySelector("#userInput").value = '';
        }
      }

      // Event listener for pressing Enter key
      document.querySelector("#userInput").addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
          sendMessage();
        }
      });

      // Event listener for clicking on the send button
      document.querySelector("#send").addEventListener("click", function() {
        sendMessage();
      });
    });
</script>
</body>
</html>
