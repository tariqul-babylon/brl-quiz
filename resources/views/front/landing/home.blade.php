@extends('front.layouts.app')
@push('css')
<style>
    :root {
            --dark-blue: #101845;
            --medium-purple: #6161e2;
            --light-purple: #6261e2;
            --white: #ffffff;
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
        
</style>
@endpush

@section('content')

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
            <h2>Why Choose our Quiz Platform?</h2>
            <p>Our platform offers cutting-edge features designed to enhance your learning and testing experience.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <span class="material-symbols-outlined">bolt</span>
                </div>
                <h3>Instant Results</h3>
                <p>Get immediate feedback on your performance with detailed analytics and explanations for each question.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <span class="material-symbols-outlined">book</span>
                </div>
                <h3>Comprehensive Tests</h3>
                <p>Access thousands of questions across multiple categories to thoroughly test your knowledge.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                   <span class="material-symbols-outlined">show_chart</span>
                </div>
                <h3>Progress Tracking</h3>
                <p>Monitor your improvement over time with our advanced progress tracking and reporting system.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <span class="material-symbols-outlined">smartphone</span>
                </div>
                <h3>Mobile Friendly</h3>
                <p>Take tests anytime, anywhere with our fully responsive platform that works on all devices.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                      <span class="material-symbols-outlined">emoji_events</span>
                </div>
                <h3>Certification</h3>
                <p>Earn verifiable certificates upon completing tests to showcase your skills to employers.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                     <span class="material-symbols-outlined">group</span>
                </div>
                <h3>Community</h3>
                <p>Join a community of learners, compare scores, and participate in skill challenges.</p>
            </div>
        </div>
    </div>
</section>




@endsection

