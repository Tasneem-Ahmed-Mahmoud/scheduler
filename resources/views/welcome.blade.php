<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Content Scheduler</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }
        .hero {
            background: linear-gradient(120deg, #4f46e5, #3b82f6);
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .features {
            padding: 60px 0;
        }
        .feature-icon {
            font-size: 40px;
            color: #4f46e5;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 30px 0;
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1 class="display-4 fw-bold">Content Scheduler</h1>
            <p class="lead">Plan, schedule, and automate your social media content with ease.</p>
            <a href="{{ route('login') }}" class="btn btn-light btn-lg mt-3">Get Started</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Why Choose Content Scheduler?</h2>
                <p class="text-muted">Powerful features to streamline your content strategy.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="feature-icon mb-3">📅</div>
                    <h5>Visual Calendar</h5>
                    <p>Plan and visualize your posts with an interactive calendar view.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-icon mb-3">⚙️</div>
                    <h5>Automation</h5>
                    <p>Automate publishing across multiple platforms effortlessly.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-icon mb-3">📊</div>
                    <h5>Performance Insights</h5>
                    <p>Track the performance of your scheduled content over time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="text-center py-5 bg-light">
        <div class="container">
            <h3 class="fw-bold">Ready to schedule your first post?</h3>
            <p>Sign up today and start managing your content like a pro.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Create an Account</a>
        </div>
    </section>

    <footer class="footer text-center">
        <div class="container">
            <p class="mb-1">&copy; {{ date('Y') }} Content Scheduler. All rights reserved.</p>
        </div>
    </footer>

  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
