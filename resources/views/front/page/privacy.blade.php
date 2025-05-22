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
        margin-bottom: 40px;
    }
    
    h1 {
        color: var(--primary);
        font-size: 2.5rem;
        margin-bottom: 10px;
    }
    
    .last-updated {
        color: var(--dark-gray);
        font-style: italic;
        margin-bottom: 30px;
    }
    
    .privacy-content {
        background-color: white;
        border-radius: 8px;
        padding: 40px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    h2 {
        color: var(--primary);
        margin: 30px 0 15px;
        font-size: 1.5rem;
        border-bottom: 1px solid var(--medium-gray);
        padding-bottom: 8px;
    }
    
    h3 {
        margin: 20px 0 10px;
        font-size: 1.2rem;
        color: var(--secondary);
    }
    
    p, ul {
        margin-bottom: 15px;
    }
    
    ul {
        padding-left: 20px;
    }
    
    li {
        margin-bottom: 8px;
    }
    
    .highlight {
        background-color: var(--medium-gray);
        padding: 20px;
        border-radius: 6px;
        margin: 20px 0;
    }
    
    footer {
        text-align: center;
        margin-top: 40px;
        color: var(--dark-gray);
        font-size: 0.9rem;
    }
    
    @media (max-width: 768px) {
        .container.custom {
            padding: 20px 15px;
        }
        
        .privacy-content {
            padding: 25px;
        }
        
        h1 {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')

   

    <div class="container custom">
        <header>
            <h1>Privacy Policy</h1>
            <p class="last-updated">Last Updated: June 10, 2023</p>
        </header>
        
        <div class="privacy-content">
            <section>
                <h2>1. Introduction</h2>
                <p>Babylon Resources Limited ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your personal information when you visit our website <a href="https://brlbd.com/">https://brlbd.com/</a> or interact with our services.</p>
            </section>
            
            <section>
                <h2>2. Information We Collect</h2>
                <h3>2.1 Personal Information</h3>
                <p>We may collect the following personal data:</p>
                <ul>
                    <li><strong>Contact Information:</strong> Name, email, phone number, address.</li>
                    <li><strong>Business Information:</strong> Company name, job title.</li>
                    <li><strong>Technical Data:</strong> IP address, browser type, device information.</li>
                    <li><strong>Usage Data:</strong> Pages visited, time spent on site.</li>
                </ul>
                
                <h3>2.2 How We Collect Data</h3>
                <ul>
                    <li>When you fill out contact forms.</li>
                    <li>When you subscribe to newsletters.</li>
                    <li>Automatically via cookies and analytics tools.</li>
                </ul>
            </section>
            
            <section>
                <h2>3. How We Use Your Information</h2>
                <p>We use collected data for:</p>
                <ul>
                    <li>Providing and improving our services.</li>
                    <li>Responding to inquiries and customer support.</li>
                    <li>Sending marketing communications (with consent).</li>
                    <li>Analyzing website performance.</li>
                    <li>Complying with legal obligations.</li>
                </ul>
            </section>
            
            <section>
                <h2>4. Data Sharing & Disclosure</h2>
                <p>We do not sell your personal data. However, we may share it with:</p>
                <ul>
                    <li><strong>Service Providers:</strong> Third-party vendors assisting with IT, hosting, or analytics.</li>
                    <li><strong>Legal Authorities:</strong> When required by law or to protect our rights.</li>
                    <li><strong>Business Partners:</strong> Only with your explicit consent.</li>
                </ul>
            </section>
            
            <section>
                <h2>5. Data Security</h2>
                <p>We implement industry-standard security measures, including:</p>
                <ul>
                    <li>Encryption (SSL/TLS) for data transmission.</li>
                    <li>Secure storage with access controls.</li>
                    <li>Regular security audits.</li>
                </ul>
                <div class="highlight">
                    <p><strong>Note:</strong> While we take precautions, no online system is 100% secure. You provide data at your own risk.</p>
                </div>
            </section>
            
            <section>
                <h2>6. Cookies & Tracking</h2>
                <p>We use cookies to:</p>
                <ul>
                    <li>Enhance user experience.</li>
                    <li>Analyze traffic patterns.</li>
                    <li>Remember preferences.</li>
                </ul>
                <p>You can disable cookies in your browser settings, but some site features may not work properly.</p>
            </section>
            
            <section>
                <h2>7. Your Rights</h2>
                <p>Under applicable laws (e.g., GDPR), you may:</p>
                <ul>
                    <li>Request access to your data.</li>
                    <li>Correct or delete inaccurate information.</li>
                    <li>Opt out of marketing emails.</li>
                    <li>Withdraw consent (where applicable).</li>
                </ul>
                <p>To exercise these rights, contact us at <a href="mailto:brlinfo@babylon-bd.com">brlinfo@babylon-bd.com</a>.</p>
            </section>
            
            <section>
                <h2>8. Changes to This Policy</h2>
                <p>We may update this Privacy Policy periodically. The "Last Updated" date at the top will reflect changes. Continued use of our services constitutes acceptance of the revised policy.</p>
            </section>
            
            <section>
                <h2>9. Contact Us</h2>
                <p>For privacy-related inquiries, reach us at:</p>
                <p>
                    <strong>Babylon Resources Limited</strong><br>
                    Floor – 7A, House 3/1, Block F, Lalmatia,<br>
                    Mohammadpur, Dhaka 1207, Bangladesh<br>
                    <strong>Phone:</strong> +8801707081370<br>
                    <strong>Email:</strong> <a href="mailto:brlinfo@babylon-bd.com">brlinfo@babylon-bd.com</a>
                </p>
            </section>
        </div>
        
        <footer>
            <p>&copy; 2023 Babylon Resources Limited. All rights reserved.</p>
        </footer>
    </div>

@endsection