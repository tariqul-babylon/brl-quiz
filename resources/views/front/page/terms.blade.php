@extends('front.layouts.app')
@push('css')
<style>
    :root {
        --primary: #4361ee;
        --secondary: #3a0ca3;
        --text: #2b2d42;
        --light-gray: #f8f9fa;
        --medium-gray: #e9ecef;
        --dark-gray: #6c757d;
    }
    
   
    header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    h1 {
        color: var(--primary);
        font-size: 2.5rem;
        margin-bottom: 15px;
    }
    
    .last-updated {
        color: var(--dark-gray);
        font-style: italic;
        margin-bottom: 30px;
    }
    
    .terms-content {
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
        
        .terms-content {
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
            <h1>Terms of Use</h1>
            <p class="last-updated">Last Updated: June 10, 2023</p>
        </header>
        
        <div class="terms-content">
            <section>
                <h2>1. Acceptance of Terms</h2>
                <p>By accessing and using this Online Quiz System ("the System"), you accept and agree to be bound by these Terms of Use. If you do not agree to these terms, please do not use the System.</p>
            </section>
            
            <section>
                <h2>2. User Responsibilities</h2>
                <h3>2.1 Account Security</h3>
                <p>You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.</p>
                
                <h3>2.2 Appropriate Conduct</h3>
                <p>You agree not to:</p>
                <ul>
                    <li>Use the System for any fraudulent or unlawful purpose</li>
                    <li>Attempt to compromise the security of the System</li>
                    <li>Share quiz questions or answers with others during active examination periods</li>
                    <li>Use any automated means to interact with the System</li>
                </ul>
            </section>
            
            <section>
                <h2>3. Examination Rules</h2>
                <div class="highlight">
                    <p><strong>Important:</strong> Violation of examination rules may result in disqualification or other academic penalties.</p>
                </div>
                <ul>
                    <li>All quizzes must be completed independently without assistance</li>
                    <li>Time limits are strictly enforced</li>
                    <li>Only one attempt per quiz is allowed unless otherwise specified</li>
                    <li>Technical issues must be reported immediately</li>
                </ul>
            </section>
            
            <section>
                <h2>4. Intellectual Property</h2>
                <p>All quiz content, including questions, answers, and supporting materials, are the property of the System administrators or their licensors and are protected by copyright laws.</p>
            </section>
            
            <section>
                <h2>5. Privacy</h2>
                <p>Your use of the System is subject to our Privacy Policy, which explains how we collect, use, and protect your personal information.</p>
            </section>
            
            <section>
                <h2>6. System Availability</h2>
                <p>We strive to maintain System availability but cannot guarantee uninterrupted access. Scheduled maintenance may occur, and unexpected outages may happen.</p>
            </section>
            
            <section>
                <h2>7. Limitation of Liability</h2>
                <p>The System administrators shall not be liable for any indirect, incidental, special, or consequential damages resulting from the use or inability to use the System.</p>
            </section>
            
            <section>
                <h2>8. Changes to Terms</h2>
                <p>We reserve the right to modify these Terms of Use at any time. Continued use of the System after changes constitutes acceptance of the modified terms.</p>
            </section>
            
            <section>
                <h2>9. Governing Law</h2>
                <p>These Terms shall be governed by and construed in accordance with the laws of the jurisdiction where the System is administered.</p>
            </section>
        </div>
        
        <footer>
            <p>If you have any questions about these Terms of Use, please contact us at support@quizsystem.edu</p>
            <p>&copy; 2023 Online Quiz System. All rights reserved.</p>
        </footer>
    </div>
@endsection