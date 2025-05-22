@extends('front.layouts.app')
@push('css')
<style>
    :root {
        --primary: #2c3e50;
        --secondary: #e74c3c;
        --accent: #3498db;
        --text: #333;
        --light-gray: #f9f9f9;
        --medium-gray: #ecf0f1;
        --dark-gray: #7f8c8d;
    }
    
   
    header {
        text-align: center;
        margin-bottom: 50px;
    }
    
    /* .logo {
        max-width: 180px;
        margin-bottom: 20px;
    } */
    
    h1 {
        color: var(--primary);
        font-size: 2.5rem;
        margin-bottom: 15px;
    }
    
    .tagline {
        color: var(--secondary);
        font-size: 1.2rem;
        font-weight: 500;
        margin-bottom: 30px;
    }
    
    .about-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 50px;
    }
    
    .about-text {
        background-color: white;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    }
    
    h2 {
        color: var(--primary);
        margin-bottom: 20px;
        font-size: 1.8rem;
        position: relative;
        padding-bottom: 10px;
    }
    
    h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background-color: var(--secondary);
    }
    
    p {
        margin-bottom: 20px;
    }
    
    .mission-vision {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin: 30px 0;
    }
    
    .card {
        background-color: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        border-top: 4px solid var(--accent);
    }
    
    .card h3 {
        color: var(--primary);
        margin-bottom: 15px;
        font-size: 1.3rem;
    }
    
    .contact-info {
        background-color: var(--primary);
        color: white;
        border-radius: 8px;
        padding: 30px;
    }
    
    .contact-info h2 {
        color: white;
    }
    
    .contact-info h2::after {
        background-color: var(--accent);
    }
    
    .contact-details {
        margin-top: 20px;
    }
    
    .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .contact-icon {
        margin-right: 15px;
        color: var(--accent);
        font-size: 1.2rem;
        min-width: 25px;
    }
    
    .map-container {
        height: 300px;
        margin-top: 30px;
        border-radius: 8px;
        overflow: hidden;
    }
    
    iframe {
        width: 100%;
        height: 100%;
        border: none;
    }
    
    @media (max-width: 768px) {
        .about-content {
            grid-template-columns: 1fr;
        }
        
        .mission-vision {
            grid-template-columns: 1fr;
        }
        
        .container.custom {
            padding: 30px 15px;
        }
        
        h1 {
            font-size: 2rem;
        }
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush
@section('content')


    <div class="container custom">
        <header>
            <h1>About Us</h1>
        </header>
        
        <div class="about-content">
            <div class="about-text">
                <h2>Our Company</h2>
                <p>Babylon Resources Limited is a leading company based in Dhaka, Bangladesh, committed to delivering high-quality products and services to our clients. Since our establishment, we have been dedicated to innovation, quality, and customer satisfaction.</p>
                
                <p>With a team of experienced professionals and a customer-centric approach, we have built a strong reputation in our industry. Our diverse portfolio and strategic partnerships enable us to provide comprehensive solutions tailored to our clients' needs.</p>
                
                <div class="mission-vision">
                    <div class="card">
                        <h3>Our Mission</h3>
                        <p>To provide innovative solutions and exceptional services that create sustainable value for our clients, partners, and stakeholders while maintaining the highest standards of integrity and professionalism.</p>
                    </div>
                    
                    <div class="card">
                        <h3>Our Vision</h3>
                        <p>To be recognized as a market leader and trusted partner in our industry, known for our commitment to excellence, continuous improvement, and positive impact on the communities we serve.</p>
                    </div>
                </div>
                
                <h2>Our Values</h2>
                <ul style="list-style-type: none;">
                    <li style="margin-bottom: 10px;"><strong>Integrity:</strong> We conduct our business with honesty and transparency.</li>
                    <li style="margin-bottom: 10px;"><strong>Innovation:</strong> We embrace creativity and continuous improvement.</li>
                    <li style="margin-bottom: 10px;"><strong>Quality:</strong> We deliver excellence in everything we do.</li>
                    <li style="margin-bottom: 10px;"><strong>Customer Focus:</strong> We build lasting relationships through exceptional service.</li>
                    <li><strong>Sustainability:</strong> We are committed to responsible business practices.</li>
                </ul>
            </div>
            
            <div class="contact-info">
                <h2>Contact Information</h2>
                <div class="contact-details">
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <strong>Head Office</strong><br>
                            Floor – 7A, House 3/1, Block F, Lalmatia,<br>
                            Mohammadpur, Dhaka 1207, Bangladesh
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                        <div>
                            <strong>Mobile</strong>: +8801707081370<br>
                            <strong>Phone</strong>: +88 09609003306
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-fax"></i></div>
                        <div>
                            <strong>Fax</strong>: 88 (02) 8032949
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <strong>Email</strong>: brlinfo@babylon-bd.com
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-globe"></i></div>
                        <div>
                            <strong>Website</strong>: <a href="https://brlbd.com/" style="color: var(--accent);">https://brlbd.com/</a>
                        </div>
                    </div>
                </div>
                
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.215730036332!2d90.3562143154309!3d23.75086898459138!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755bf4e2c82d3d7%3A0x1a1a9a9a9a9a9a9a!2sLalmatia%2C%20Dhaka%201207%2C%20Bangladesh!5e0!3m2!1sen!2sbd!4v1620000000000!5m2!1sen!2sbd" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection