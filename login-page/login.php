<?php
session_start();

// Store errors and active form before clearing session
$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login'; // Default to 'login'

// Now clear session errors
unset($_SESSION['login_error'], $_SESSION['register_error'], $_SESSION['active_form']);

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration</title>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <link rel="stylesheet" href="styles-login.css" />
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto+Mono:wght@400;700&family=IBM+Plex+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
       /* Import Modern Fonts */
       @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto+Mono:wght@400;700&family=IBM+Plex+Sans:wght@400;700&display=swap');

       /* Global Styles */
       * {
           margin: 0;
           padding: 0;
           box-sizing: border-box;
           font-family: 'IBM Plex Sans', sans-serif;
       }

       body {
           display: flex;
           justify-content: center;
           align-items: center;
           height: 100vh;
           background: linear-gradient(135deg, #000000, #000000);
           color: white;
           overflow: hidden;
       }

       /* Transparent & Neon Navbar */
       .navbar {
           width: 100%;
           display: flex;
           height: 80px;
           justify-content: space-between;
           align-items: center;
           padding: 15px 40px;
           background: rgba(0, 0, 0, 0.3);
           backdrop-filter: blur(10px);
           position: absolute;
           top: 0;
           left: 0;
           z-index: 100;
       }

       .navbar img {
           padding: 5px;
           height: 50px;
           transition: transform 0.3s ease;
           margin-right: 20px;
           /* Added right margin for spacing */
       }

       .navbar img:hover {
           transform: scale(1.1);
       }

       .auth-buttons a {
           color: white;
           text-decoration: none;
           font-weight: bold;
           font-family: 'Roboto Mono', monospace;
           padding: 10px 15px;
           transition: color 0.3s ease-in-out, text-shadow 0.3s ease-in-out;
       }

       .auth-buttons a:hover {
           color: #8300fe;
           text-shadow: 0 0 10px #8300fe, 0 0 20px #8300fe;
       }

       .auth-buttons .login-btn {
           color: white;
           background: transparent;
           border: 2px solid #8300fe;
           padding: 10px 20px;
           border-radius: 5px;
           cursor: pointer;
           font-size: 14px;
           font-weight: bold;
           font-family: 'Orbitron', sans-serif;
           transition: background 0.3s, box-shadow 0.3s ease-in-out;
       }

       .auth-buttons .login-btn:hover {
           background: #8300fe;
           box-shadow: 0 0 10px #8300fe, 0 0 20px #8300fe;
       }

       /* Container with Neon Effect */
       .container {
           display: flex;
           width: 800px;
           height: 350px;
           background: transparent;
           /* Very transparent */
           border-radius: 15px;
           box-shadow: 0 5px 15px rgba(131, 0, 254, 0.3);
           overflow: hidden;
           position: relative;
           border: 2px solid rgba(0, 0, 0, 0.1);
           flex-direction: row;
           align-items: stretch;
           backdrop-filter: blur(3px);
           /* Softer blur */
           animation: neonGlow 4s linear infinite alternate;
       }

       .container::before {
           content: '';
           position: absolute;
           top: -2px;
           left: -2px;
           right: -2px;
           bottom: -2px;
           background: transparent;
           z-index: -1;
           border-radius: 15px;
           animation: neonGlow 4s linear infinite alternate;
       }

       .form-container {
           flex: 1;
           padding: 40px;
           text-align: center;
           background: rgba(0, 0, 0, 0.1);
           /* More transparent */
           transition: opacity 0.3s ease;
           backdrop-filter: blur(3px);
       }

       .form-container.hidden {
           display: none;
           opacity: 0;
       }

       .form-container.fade-in {
           opacity: 1;
       }

       .form-container.fade-slide-out {
           opacity: 0;
           transform: translateY(10px);
       }

       .switch-container {
           flex: 1;
           background: transparent;
           /* More transparent */
           color: white;
           display: flex;
           align-items: center;
           justify-content: center;
           flex-direction: column;
           padding: 40px;
           transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
       }

       .switch-container.slide-left {
           transform: translateX(-100%);
           opacity: 0;
       }

       .switch-container.slide-right {
           transform: translateX(100%);
           opacity: 0;
       }

       .switch-container h2 {
           font-size: 22px;
           margin-bottom: 15px;
       }

       /* Inputs and Buttons */
       input {
           width: 100%;
           padding: 12px;
           margin: 10px 0;
           border: 1px solid #555;
           border-radius: 5px;
           background: #222;
           color: white;
       }

       .login-btn-custom {
           width: 100%;
           padding: 12px;
           margin-top: 10px;
           background: #8300fe;
           /* Green */
           color: white;
           border: none;
           border-radius: 5px;
           cursor: pointer;
           transition: background 0.3s, transform 0.3s ease-in-out;
       }

       .login-btn-custom:hover {
           background: #45a049;
           transform: scale(1.05);
       }

       .register-btn-custom {
           width: 100%;
           padding: 12px;
           margin-top: 10px;
           background: #8300fe;
           /* Blue */
           color: white;
           border: none;
           border-radius: 5px;
           cursor: pointer;
           transition: background 0.3s, transform 0.3s ease-in-out;
       }

       .register-btn-custom:hover {
           background: #45a049;
           transform: scale(1.05);
       }

       .toggle-btn {
           width: 100%;
           padding: 12px;
           margin-top: 10px;
           background: #8300fe;
           color: white;
           border: none;
           border-radius: 5px;
           cursor: pointer;
           transition: background 0.3s, transform 0.3s ease-in-out;
       }

       .toggle-btn:hover {
           background: #000000;
           transform: scale(1.05);
       }

       .forgot-password {
           display: block;
           text-align: right;
           font-size: 14px;
           color: #ff5722;
           text-decoration: none;
       }

       #particles-js {
           position: absolute;
           width: 100%;
           height: 100%;
           z-index: -1;
       }

       /* Animations */
       .fade-slide-in {
           animation: fadeSlideIn 0.5s ease-out forwards;
       }

       .fade-slide-out {
           animation: fadeSlideOut 0.5s ease-out forwards;
       }

       @keyframes fadeSlideIn {
           from {
               opacity: 0;
               transform: translateY(10px);
           }

           to {
               opacity: 1;
               transform: translateY(0);
           }
       }

       @keyframes fadeSlideOut {
           from {
               opacity: 1;
               transform: translateY(0);
           }

           to {
               opacity: 0;
               transform: translateY(10px);
       }
       }

       @keyframes neonGlow {
           from {
               box-shadow: 0 0 10px #8300fe, 0 0 20px #7BD3EA;
           }

           to {
               box-shadow: 0 0 20px #7BD3EA, 0 0 40px #8300fe;
           }
       }

       /* Responsive Design */
       @media (max-width: 768px) {
           .container {
               width: 90%;
               flex-direction: column;
           }

           .switch-container {
               display: none;
           }
       }

       .hidden {
           display: none;
       }

       .error-message{
        padding: 12px;
        background: #f8d7da;
        border-radius: 6px;
        color: #a42834;
        text-align: center;
        margin-bottom: 20px
       }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.html">
            <img src="logo1.png" alt="Civic Eye Logo">
        </a>
        <div class="auth-buttons">
            <a href="index.html">Home</a>
            <a href="download">Download</a>
            <a href="team">Team</a>
            <a href="contact-us">Contact Us</a>
            <a href="login.html">
                <button class="login-btn">LOGIN / SIGNUP</button>
            </a>
        </div>

    </div>

    <div id="particles-js"></div>

    <div class="container">
        <div class="form-container fade-in <?= isActiveForm('login', $activeForm); ?>" id="login-form">  
        <form action="login_register.php" method="post">
                <h2>Login</h2>
                <?= showError($errors['login']);?>
                <input type="text" name="email" placeholder="email" required>
                <input type="password" name="password" placeholder="Password" required>
                <a href="contact-us.html" class="forgot-password">Forgot password?</a>
                <button class="login-btn-custom" type="submit">Login</button>
                <input type="hidden" name="form_type" value="login">
            </form>
        </div>
        <div class="switch-container" id="switchContainer">
            <h2>Welcome!</h2>
            <p id="switchText">Don't have an account? </p>  <button class="toggle-btn" id="showRegister">Register</button>  </div>
        <div class="form-container hidden  <?= isActiveForm('register', $activeForm); ?>" id="register-form">  
        <form action="login_register.php" method="post">
                <h2>Register</h2>
                <?= showError($errors['register']);?>
                <input type="text" name="name" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="register-btn-custom" type="submit">Register</button>
                <input type="hidden" name="form_type" value="register">
            </form>
        </div>
    </div>
    
    <script>
        

        function showForm(formId){
    document.querySelectorAll(".form").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active");
}
  document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("login-form");
    const registerForm = document.getElementById("register-form");
    const switchContainer = document.getElementById("switchContainer");

    function showRegister() {
        loginForm.classList.add("fade-slide-out");
        registerForm.classList.remove("hidden");
        registerForm.classList.add("fade-slide-in");
        switchContainer.classList.add("slide-left");

        setTimeout(() => {
            loginForm.classList.add("hidden");
            loginForm.classList.remove("fade-slide-out");
            switchContainer.classList.remove("slide-left");
            switchContainer.innerHTML = `
                Already have an account?
                <button class="toggle-btn" id="showLogin">Back to Login</button>
            `;
            attachEventListeners(); // Re-attach event listeners
        }, 500);
    }

    function showLogin() {
        registerForm.classList.add("fade-slide-out");
        loginForm.classList.remove("hidden");
        loginForm.classList.add("fade-slide-in");
        switchContainer.classList.add("slide-right");

        setTimeout(() => {
            registerForm.classList.add("hidden");
            registerForm.classList.remove("fade-slide-out");
            switchContainer.classList.remove("slide-right");
            switchContainer.innerHTML = `
                Don't have an account?
                <button class="toggle-btn" id="showRegister">Register</button>
            `;
            attachEventListeners(); // Re-attach event listeners
        }, 500);
    }

    function attachEventListeners() {
        document.getElementById("showRegister")?.addEventListener("click", showRegister);
        document.getElementById("showLogin")?.addEventListener("click", showLogin);
    }

    // Initial event listeners
    attachEventListeners();
});

    // particles.js configuration
    particlesJS('particles-js', {
        particles: {
            number: {
                value: 80,
                density: {
                    enable: true,
                    value_area: 800
                }
            },
            color: {
                value: "#7BD3EA"
            },
            shape: {
                type: "circle"
            },
            opacity: {
                value: 0.5,
                random: true,
                anim: {
                    enable: true,
                    speed: 1,
                    opacity_min: 0.1,
                    sync: false
                }
            },
            size: {
                value: 3,
                random: true,
                anim: {
                    enable: true,
                    speed: 0.5,
                    size_min: 0.1,
                    sync: false
                }
            },
            line_linked: {
                enable: true,
                distance: 150,
                color: "#7BD3EA",
                opacity: 0.4,
                width: 1
            },
            move: {
                enable: true,
                speed: 3,
                direction: "none",
                random: false,
                straight: false,
                out_mode: "out",
                bounce: false
            }
        },
        interactivity: {
            detect_on: "canvas",
            events: {
                onhover: {
                    enable: true,
                    mode: "repulse"
                },
                onclick: {
                    enable: true,
                    mode: "push"
                },
                resize: true
            },
            modes: {
                repulse: {
                    distance: 120,
                    duration: 0.4
                },
                push: {
                    particles_nb: 4
                }
            }
        },
        retina_detect: true
    });

    // Mouse repel effect
    document.addEventListener('mousemove', (event) => {
        let x = (event.clientX / window.innerWidth) * 2 - 1;
        let y = (event.clientY / window.innerHeight) * 2 - 1 - y;
        let particles = window.pJSDom[0].pJS.particles.array;

        particles.forEach(particle => {
            let dx = particle.x / window.innerWidth * 2 - 1 - x;
            let dy = particle.y / window.innerHeight * 2 - 1 - y;
            let distance = Math.sqrt(dx * dx + dy * dy);

            if (distance < 0.2) {
                particle.vx = dx * 5;
                particle.vy = dy * 5;
            }
        });
    });
    </script>
</body>
</html>