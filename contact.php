<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - GLOWGENIC</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Raleway:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Contact Page Specific Styles */
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #fffafd;
            margin: 0;
            padding: 0;
        }

        .contact-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
            display: flex;
            gap: 40px;
        }

        .contact-info {
            flex: 1;
            background: linear-gradient(145deg, #f9f0ff, #fff0f5);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(138, 79, 255, 0.1);
        }

        .contact-form {
            flex: 1;
        }

        .contact-info h2, .contact-form h2 {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            margin-bottom: 20px;
            color: #8a4fff;
            position: relative;
            padding-bottom: 10px;
        }

        .contact-info h2::after, .contact-form h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #ff8db7, #fbb1ff);
            border-radius: 3px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
            background: rgba(255, 255, 255, 0.8);
            padding: 15px;
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .info-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(138, 79, 255, 0.2);
        }

        .info-icon {
            font-size: 20px;
            background: linear-gradient(90deg, #ff8db7, #fbb1ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-right: 15px;
            margin-top: 5px;
        }

        .info-content h4 {
            font-weight: 600;
            margin-bottom: 5px;
            color: #6b4d6d;
            font-size: 18px;
        }

        .info-content p, .info-content a {
            color: #666;
            text-decoration: none;
            transition: color 0.3s;
        }

        .info-content a:hover {
            color: #ff4f9d;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #6b4d6d;
            font-size: 15px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0c6ff;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #8a4fff;
            box-shadow: 0 0 0 3px rgba(138, 79, 255, 0.2);
        }

        .form-group textarea {
            height: 120px;
            resize: vertical;
        }

        .submit-btn {
            background: linear-gradient(90deg, #ff8db7, #fbb1ff);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(255, 157, 187, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 157, 187, 0.4);
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(90deg, #ff8db7, #fbb1ff);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s;
        }

        .social-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 157, 187, 0.4);
        }

        .map-container {
            margin-top: 30px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(138, 79, 255, 0.2);
            height: 250px;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        @media (max-width: 768px) {
            .contact-container {
                flex-direction: column;
            }

            .map-container {
                height: 200px;
            }
        }
    </style>
</head>
<body>

<?php include 'nav.php'; ?>

<!-- Main Contact Content -->
<div class="contact-container">
    <div class="contact-info">
        <h2>Contact Information</h2>

        <div class="info-item">
            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div class="info-content">
                <h4>Our Location</h4>
                <p>Jln Selabaya, Kalimanah, Purbalingga, Central Java, Indonesia</p>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon"><i class="fas fa-envelope"></i></div>
            <div class="info-content">
                <h4>Email Address</h4>
                <a href="mailto:glowgenic@gmail.com">glowgenic@gmail.com</a>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
            <div class="info-content">
                <h4>Phone Number</h4>
                <a href="tel:+6281234567890">089506019709</a>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon"><i class="fas fa-clock"></i></div>
            <div class="info-content">
                <h4>Working Hours</h4>
                <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                <p>Saturday: 10:00 AM - 4:00 PM</p>
            </div>
        </div>

        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.116234578052!2d109.36498477504837!3d-7.553417374482808!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6541403fc43b6b%3A0x8e1d54ecf19d2332!2sSMKN%201%20Purbalingga!5e0!3m2!1sid!2sid!4v1715499482576!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="social-links">
            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
        </div>
    </div>

    <div class="contact-form">
        <h2>Get In Touch</h2>
        <form id="contactForm">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required>
            </div>

            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" required></textarea>
            </div>

            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </div>
</div>

<?php include 'footer.html'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('contactForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;

            alert(`Thank you, ${name}! Your message has been received. We'll contact you at ${email} soon.`);
            this.reset();
        });
    });
</script>

</body>
</html>