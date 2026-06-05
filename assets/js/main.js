// ============================================================
// PlasticPollutions - JavaScript
// Pentecost University - PUIS304 Project
// ============================================================

// Cookie Notification
function acceptCookies() {
    localStorage.setItem('cookiesAccepted', 'true');
    document.getElementById('cookieNotification').classList.remove('show');
}

function learnMoreCookies() {
    alert('We use cookies to improve your experience and track site usage.');
}

// Check if cookies already accepted
if (!localStorage.getItem('cookiesAccepted')) {
    setTimeout(() => {
        document.getElementById('cookieNotification').classList.add('show');
    }, 1000);
}

// Navigation Toggle
function toggleNav() {
    document.querySelector('.nav-menu').classList.toggle('show');
}

// Image Slider
let currentSlide = 0;
const slides = document.querySelectorAll('.slide');

function changeSlide(direction) {
    if (slides.length === 0) return;
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + direction + slides.length) % slides.length;
    slides[currentSlide].classList.add('active');
}

// Auto-advance slider only if slides exist
if (slides.length > 0) {
    setInterval(() => {
        changeSlide(1);
    }, 5000);
}

// Sign Up Modal
function openSignupModal() {
    document.getElementById('signupModal').classList.add('show');
}

function closeSignupModal() {
    document.getElementById('signupModal').classList.remove('show');
}

// Close modal when clicking outside
document.getElementById('signupModal').addEventListener('click', function (e) {
    if (e.target === this) {
        closeSignupModal();
    }
});

// Handle Signup Form Submission
async function handleSignup(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const errorDiv = document.getElementById('signupError');

    // Client-side validation
    const password = formData.get('password');
    const confirmPassword = formData.get('confirm_password');

    if (password !== confirmPassword) {
        errorDiv.textContent = 'Passwords do not match.';
        return;
    }

    // Password strength validation
    const passwordErrors = validatePasswordStrength(password);
    if (passwordErrors.length > 0) {
        errorDiv.textContent = passwordErrors.join(' ');
        return;
    }

    try {
        const response = await fetch('register.php', {
            method: 'POST',
            body: formData
        });

        const text = await response.text();

        if (text.includes('Registration successful')) {
            alert('Registration successful! Redirecting to login...');
            window.location.href = 'login.php';
        } else {
            errorDiv.textContent = 'Registration failed. Please try again.';
        }
    } catch (error) {
        errorDiv.textContent = 'An error occurred. Please try again.';
    }
}

function validatePasswordStrength(password) {
    const errors = [];
    if (password.length < 8) errors.push('Password must be at least 8 characters');
    if (!/[A-Z]/.test(password)) errors.push('Must contain uppercase letter');
    if (!/[a-z]/.test(password)) errors.push('Must contain lowercase letter');
    if (!/[0-9]/.test(password)) errors.push('Must contain a number');
    return errors;
}

// Animated Counters
function animateCounters() {
    const counters = document.querySelectorAll('.stat-number');

    counters.forEach(counter => {
        const target = parseFloat(counter.getAttribute('data-target'));
        const duration = 2000;
        const steps = 60;
        const increment = target / steps;
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                counter.textContent = formatNumber(target);
                clearInterval(timer);
            } else {
                counter.textContent = formatNumber(current);
            }
        }, duration / steps);
    });
}

function formatNumber(num) {
    if (num >= 1000000000) {
        return (num / 1000000000).toFixed(1) + 'B';
    } else if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M';
    } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K';
    }
    return Math.round(num);
}

// Intersection Observer for counter animation
const observerOptions = {
    threshold: 0.5
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateCounters();
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

const statsSection = document.querySelector('.stats-section');
if (statsSection) {
    observer.observe(statsSection);
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href === '#' || href === '') return;

        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Dropdown menu toggle on mobile
document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
    toggle.addEventListener('click', function (e) {
        if (window.innerWidth <= 768) {
            e.preventDefault();
            const menu = this.nextElementSibling;
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }
    });
});

// Close dropdowns when clicking outside
document.addEventListener('click', function (e) {
    if (!e.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.style.display = '';
        });
    }
});

// Donation Widget Functionality
let selectedAmount = 50;
let selectedFrequency = 'one-time';

// Amount button selection
document.querySelectorAll('.amount-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.amount-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        selectedAmount = parseInt(this.getAttribute('data-amount'));
        updateImpactDisplay();
    });
});

// Frequency selection
document.querySelectorAll('.frequency-option').forEach(option => {
    option.addEventListener('click', function () {
        document.querySelectorAll('.frequency-option').forEach(o => o.classList.remove('active'));
        this.classList.add('active');
        selectedFrequency = this.querySelector('input').value;
        updateImpactDisplay();
    });
});

// Update impact display
function updateImpactDisplay() {
    const impactAmount = document.querySelector('.impact-amount');
    const impactResult = document.querySelector('.impact-result');

    if (impactAmount && impactResult) {
        impactAmount.textContent = '$' + selectedAmount;

        const impactPerDollar = 2; // 2 lbs per dollar
        const totalImpact = selectedAmount * impactPerDollar;
        impactResult.textContent = totalImpact + ' lbs of ocean plastic extracted';
    }
}

// Handle donation button click
function handleDonation() {
    if (isLoggedIn()) {
        // Redirect to donation page with pre-selected values
        window.location.href = 'user/donate.php?amount=' + selectedAmount + '&frequency=' + selectedFrequency;
    } else {
        // Open signup modal
        openSignupModal();
    }
}

// Live telemetry counter animation
function animateTelemetryCounter() {
    const counter = document.getElementById('totalPlastic');
    if (!counter) return;

    const target = parseInt(counter.textContent.replace(/,/g, ''));
    const duration = 3000;
    const steps = 120;
    const increment = target / steps;
    let current = 0;

    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            counter.textContent = target.toLocaleString();
            clearInterval(timer);
        } else {
            counter.textContent = Math.floor(current).toLocaleString();
        }
    }, duration / steps);
}

// Intersection Observer for telemetry counter
const telemetryObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateTelemetryCounter();
            telemetryObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

const telemetrySection = document.querySelector('.telemetry-section');
if (telemetrySection) {
    telemetryObserver.observe(telemetrySection);
}
