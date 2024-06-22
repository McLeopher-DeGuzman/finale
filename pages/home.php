

<div class="app-main__outer">
    <div id="refreshData">
        <div class="app-main__inner">
        <?php
// Start the session


// Assuming you have established a database connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "exam";
$conn = null;

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Assuming you have a session with the examinee's ID stored as $exmneId
    // Replace this with your actual session handling code
    if (isset($_SESSION['examineeSession']['exmne_id'])) {
        $exmneId = $_SESSION['examineeSession']['exmne_id'];

        // Select Data for the logged-in examinee
        $stmt = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_id='$exmneId'");
        $selExmneeData = $stmt->fetch(PDO::FETCH_ASSOC);
        $exmneCourse = $selExmneeData['exmne_course'];
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

        <!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            text-align: center;
            margin-top: 100px;
        }

        .message {
            background-color: #FF7377;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">

            <h1>Hello!  <!-- Chat messages will be displayed here -->
            <?php 
            if(isset($selExmneeData)){
                echo '<div class="chat-message bot-message">' . strtoupper($selExmneeData["exmne_fullname"]) . '</div>';
            }
            ?></h1>
            <p>This is the Career Advice Consultation.</p>
            <!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {box-sizing: border-box}
body {font-family: Verdana, sans-serif; margin:0}
.mySlides {display: none}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Next & previous buttons */
.next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  
}
.prev {
  cursor: pointer;
  position: absolute;
  top: 50%;
  left: 0; /* Change left position to 0 */
  
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}


/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active, .dot:hover {
  background-color: #717171;
}

/* Fading animation */
.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .prev, .next,.text {font-size: 11px}
}
</style>
</head>
<body>

<div class="slideshow-container">

<div class="mySlides">
  <div class="numbertext">1 / 4</div>
  <img src="assets/images/1.png" style="width:100%">
  <div class="text">Page 1</div>
</div>

<div class="mySlides">
  <div class="numbertext">2 / 4</div>
  <img src="assets/images/2.png" style="width:100%">
  <div class="text">Page 2</div>
</div>

<div class="mySlides">
  <div class="numbertext">3 / 4</div>
  <img src="assets/images/4.png" style="width:100%">
  <div class="text">Page 3</div>
</div>

<div class="mySlides">
  <div class="numbertext">4 / 4</div>
  <img src="assets/images/3.png" style="width:100%">
  <div class="text">Page 4</div>
</div>

<a class="prev" onclick="plusSlides(-1)">❮</a>
<a class="next" onclick="plusSlides(1)">❯</a>

</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
  <span class="dot" onclick="currentSlide(4)"></span>
</div>

<script>
    let slideIndex = 0; // Start from the first slide
    showSlides();

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides() {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");

        // Reset all slides to be hidden and dots to be inactive
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }

        // If we've reached the end, start from the beginning
        if (slideIndex >= slides.length) {
            slideIndex = 0;
        }

        // Display the current slide and activate its corresponding dot
        slides[slideIndex].style.display = "block";
        dots[slideIndex].className += " active";

        // Move to the next slide
        slideIndex++;

        // Call showSlides() again after 5 seconds (5000 milliseconds)
        setTimeout(showSlides, 5000); // Change 5000 to the desired duration in milliseconds
    }
</script>



</body>
</html> 

        </div>
    </div>
</body>
</html>

    </div>
    </div>
