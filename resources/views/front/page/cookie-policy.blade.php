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
    
    .cookie-content {
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
    
    .cookie-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    
    .cookie-table th, .cookie-table td {
        border: 1px solid var(--medium-gray);
        padding: 12px;
        text-align: left;
    }
    
    .cookie-table th {
        background-color: var(--primary);
        color: white;
    }
    
    .cookie-table tr:nth-child(even) {
        background-color: var(--light-gray);
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
        
        .cookie-content {
            padding: 25px;
        }
        
        h1 {
            font-size: 2rem;
        }
        
        .cookie-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>
@endpush
@section('content')
    <div class="container custom">
        <header>
            <h1>Cookie Policy</h1>
        </header>
        
        <div class="cookie-content">
            <section>
                <h2>1. What Are Cookies?</h2>
                <p>Cookies are small text files stored on your device when you visit our website <a href="https://brlbd.com/">https://brlbd.com/</a>. They help us enhance your browsing experience and improve our services.</p>
            </section>
            
            <section>
                <h2>2. How We Use Cookies</h2>
                <p>We use cookies for the following purposes:</p>
                <ul>
                    <li><strong>Essential Cookies:</strong> Necessary for website functionality (e.g., login sessions).</li>
                    <li><strong>Analytics Cookies:</strong> Track visitor behavior to improve our site.</li>
                    <li><strong>Preference Cookies:</strong> Remember your settings (e.g., language).</li>
                    <li><strong>Marketing Cookies:</strong> Deliver personalized ads (if applicable).</li>
                </ul>
            </section>
            
            <section>
                <h2>3. Types of Cookies We Use</h2>
                <table class="cookie-table">
                    <thead>
                        <tr>
                            <th>Cookie Name</th>
                            <th>Purpose</th>
                            <th>Duration</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>session_id</td>
                            <td>Maintains user login session</td>
                            <td>Session</td>
                            <td>Essential</td>
                        </tr>
                        <tr>
                            <td>_ga</td>
                            <td>Google Analytics tracking</td>
                            <td>2 years</td>
                            <td>Analytics</td>
                        </tr>
                        <tr>
                            <td>lang</td>
                            <td>Stores language preference</td>
                            <td>1 year</td>
                            <td>Preference</td>
                        </tr>
                    </tbody>
                </table>
            </section>
            
            <section>
                <h2>4. Third-Party Cookies</h2>
                <p>We may use services like Google Analytics, which set their own cookies. These are governed by their respective privacy policies:</p>
                <ul>
                    <li><a href="https://policies.google.com/technologies/cookies" target="_blank">Google Analytics Cookie Policy</a></li>
                    <li><a href="https://www.facebook.com/policies/cookies/" target="_blank">Facebook Cookies (if used)</a></li>
                </ul>
            </section>
            
            <section>
                <h2>5. Managing Cookies</h2>
                <h3>5.1 Browser Settings</h3>
                <p>You can control or delete cookies through your browser settings:</p>
                <ul>
                    <li><a href="https://support.google.com/chrome/answer/95647" target="_blank">Chrome</a></li>
                    <li><a href="https://support.mozilla.org/en-US/kb/clear-cookies-and-site-data-firefox" target="_blank">Firefox</a></li>
                    <li><a href="https://support.microsoft.com/en-us/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank">Internet Explorer</a></li>
                </ul>
                
                <h3>5.2 Opt-Out Tools</h3>
                <p>For analytics/marketing cookies:</p>
                <ul>
                    <li><a href="https://tools.google.com/dlpage/gaoptout" target="_blank">Google Analytics Opt-Out</a></li>
                    <li><a href="https://www.youronlinechoices.com/" target="_blank">Your Online Choices (EU)</a></li>
                </ul>
                
                <div class="highlight">
                    <p><strong>Note:</strong> Disabling cookies may affect website functionality.</p>
                </div>
            </section>
            
            <section>
                <h2>6. Changes to This Policy</h2>
                <p>We may update this Cookie Policy. The "Last Updated" date at the top will reflect changes.</p>
            </section>
            
            <section>
                <h2>7. Contact Us</h2>
                <p>For questions about cookies, contact us at:</p>
                <p>
                    <strong>Babylon Resources Limited</strong><br>
                    Floor – 7A, House 3/1, Block F, Lalmatia,<br>
                    Mohammadpur, Dhaka 1207, Bangladesh<br>
                    <strong>Email:</strong> <a href="mailto:brlinfo@babylon-bd.com">brlinfo@babylon-bd.com</a>
                </p>
            </section>
        </div>
        
        <footer>
            <p>&copy; 2023 Babylon Resources Limited. All rights reserved.</p>
        </footer>
    </div>


@endsection