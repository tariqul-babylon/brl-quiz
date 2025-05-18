<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skill Shoper - Online Quiz Exam Platform</title>
    <style>
        :root {
            --dark-blue: #101845;
            --medium-purple: #6161e2;
            --light-purple: #6261e2;
            --white: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: var(--dark-blue);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header Styles */
        header {
            background-color: var(--dark-blue);
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            z-index: 1000;
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            color: var(--white);
            font-size: 24px;
            font-weight: 700;
            text-decoration: none;
        }
        
        .logo span {
            color: var(--medium-purple);
        }
        
        .nav-links {
            display: flex;
            list-style: none;
        }
        
        .nav-links li {
            margin-left: 30px;
        }
        
        .nav-links a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: var(--medium-purple);
        }
        
        .btn {
            display: inline-block;
            background-color: var(--medium-purple);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background-color: var(--light-purple);
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--medium-purple);
            margin-left: 15px;
        }
        
        /* Hero Section */
        .hero {
            padding: 150px 0 100px;
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--light-purple) 100%);
            color: var(--white);
            text-align: center;
        }
        
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            font-weight: 800;
        }
        
        .hero p {
            font-size: 20px;
            max-width: 700px;
            margin: 0 auto 40px;
            opacity: 0.9;
        }
        
        .hero-btns {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        
        /* Features Section */
        .features {
            padding: 80px 0;
            background-color: var(--white);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-title h2 {
            font-size: 36px;
            color: var(--dark-blue);
            margin-bottom: 15px;
        }
        
        .section-title p {
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .feature-card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            background-color: rgba(97, 97, 226, 0.1);
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .feature-icon i {
            font-size: 30px;
            color: var(--medium-purple);
        }
        
        .feature-card h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color: var(--dark-blue);
        }
        
        /* Testimonials */
        .testimonials {
            padding: 80px 0;
            background-color: #f8f9fa;
        }
        
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .testimonial-card {
            background-color: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
            color: #555;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        
        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--medium-purple);
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: bold;
        }
        
        .author-info h4 {
            color: var(--dark-blue);
            margin-bottom: 5px;
        }
        
        .author-info p {
            color: #777;
            font-size: 14px;
        }
        
        /* CTA Section */
        .cta {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--medium-purple) 0%, var(--light-purple) 100%);
            color: var(--white);
            text-align: center;
        }
        
        .cta h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        
        .cta p {
            max-width: 700px;
            margin: 0 auto 40px;
            opacity: 0.9;
            font-size: 18px;
        }
        
        /* Footer */
        footer {
            background-color: var(--dark-blue);
            color: var(--white);
            padding: 60px 0 20px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-column h3 {
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--medium-purple);
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column ul li {
            margin-bottom: 10px;
        }
        
        .footer-column ul li a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-column ul li a:hover {
            color: var(--medium-purple);
        }
        
        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #aaa;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero h1 {
                font-size: 36px;
            }
            
            .hero p {
                font-size: 18px;
            }
            
            .hero-btns {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-outline {
                margin-left: 0;
                margin-top: 15px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="#" class="logo">Skill<span>Shoper</span></a>
                <ul class="nav-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Tests</a></li>
                    <li><a href="#">Pricing</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#" class="btn">Sign In</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h1>Master Your Skills with Online Quiz Exams</h1>
            <p>Skill Shoper provides comprehensive online testing solutions to help you assess and improve your knowledge in various domains.</p>
            <div class="hero-btns">
                <a href="#" class="btn">Get Started</a>
                <a href="#" class="btn btn-outline">Sign Up</a>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Skill Shoper?</h2>
                <p>Our platform offers cutting-edge features designed to enhance your learning and testing experience.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3>Instant Results</h3>
                    <p>Get immediate feedback on your performance with detailed analytics and explanations for each question.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3>Comprehensive Tests</h3>
                    <p>Access thousands of questions across multiple categories to thoroughly test your knowledge.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Progress Tracking</h3>
                    <p>Monitor your improvement over time with our advanced progress tracking and reporting system.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Mobile Friendly</h3>
                    <p>Take tests anytime, anywhere with our fully responsive platform that works on all devices.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>Certification</h3>
                    <p>Earn verifiable certificates upon completing tests to showcase your skills to employers.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Community</h3>
                    <p>Join a community of learners, compare scores, and participate in skill challenges.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>What Our Users Say</h2>
                <p>Hear from professionals who have enhanced their skills with Skill Shoper.</p>
            </div>
            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <p class="testimonial-text">"Skill Shoper helped me prepare for my certification exam. The practice tests were incredibly similar to the real thing, and I passed with flying colors!"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">JD</div>
                        <div class="author-info">
                            <h4>John Doe</h4>
                            <p>Software Developer</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"As a hiring manager, I recommend Skill Shoper to all candidates. The certification tests provide reliable proof of a candidate's skills."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">AS</div>
                        <div class="author-info">
                            <h4>Amanda Smith</h4>
                            <p>HR Director</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"The progress tracking feature is amazing. I can see exactly which areas I need to improve, and the platform suggests relevant tests to strengthen my weak points."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">RJ</div>
                        <div class="author-info">
                            <h4>Robert Johnson</h4>
                            <p>IT Student</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="container">
            <h2>Ready to Test Your Skills?</h2>
            <p>Join thousands of professionals who use Skill Shoper to validate and improve their knowledge.</p>
            <a href="#" class="btn">Start Free Trial</a>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Skill Shoper</h3>
                    <p>Empowering professionals through comprehensive online testing solutions.</p>
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Features</a></li>
                        <li><a href="#">Tests</a></li>
                        <li><a href="#">Pricing</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Tutorials</a></li>
                        <li><a href="#">Webinars</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contact</h3>
                    <ul>
                        <li><a href="#">support@skillshoper.com</a></li>
                        <li><a href="#">+1 (555) 123-4567</a></li>
                        <li><a href="#">123 Tech Street, Digital City</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2023 Skill Shoper. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>