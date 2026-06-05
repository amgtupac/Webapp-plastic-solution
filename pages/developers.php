<?php
require_once __DIR__ . '/../auth.php';

trackVisitor();

$pageTitle = 'Our Team';
require_once __DIR__ . '/../includes/header.php';
?>

<!-- ADVANCED INTERFACE DESIGN OVERRIDES -->
<style>
    :root {
        --dark-space: #070B19;
        --dark-surface: #111827;
        --dark-card: #1F2937;
        --cyan-glow: #00F2FE;
        --blue-vibe: #4FACFE;
        --text-bright: #F9FAFB;
        --text-gray: #9CA3AF;
        --gradient-electric: linear-gradient(135deg, #00F2FE 0%, #4FACFE 100%);
    }

    body {
        background-color: var(--dark-space);
        color: var(--text-bright);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    section {
        padding: 6rem 0;
    }

    .section-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 4rem auto;
    }

    .section-badge {
        color: var(--cyan-glow);
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        display: block;
        margin-bottom: 0.5rem;
    }

    .section-title { font-size: 2.25rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 0.75rem; }
    .section-subtitle { color: var(--text-gray); font-size: 1.05rem; line-height: 1.7; }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
    }

    .team-card {
        background: var(--dark-card);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem;
        padding: 2.5rem;
        text-align: center;
        transition: transform 0.2s, border-color 0.2s;
    }

    .team-card:hover {
        transform: translateY(-4px);
        border-color: rgba(0, 242, 254, 0.2);
    }

    .team-avatar {
        width: 120px;
        height: 120px;
        background: var(--gradient-electric);
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
    }

    .team-card h3 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .team-card .role {
        color: var(--cyan-glow);
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
    }

    .team-card p {
        color: var(--text-gray);
        line-height: 1.6;
        margin-bottom: 1.5rem;
        font-style: italic;
    }

    .team-role-detail {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 0.75rem;
        padding: 1.25rem;
    }

    .team-role-detail strong {
        color: var(--text-bright);
        font-size: 0.875rem;
    }

    .team-role-detail p {
        color: var(--text-gray);
        font-size: 0.9rem;
        margin: 0.5rem 0 0 0;
        font-style: normal;
    }

    .project-info {
        background: var(--dark-card);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem;
        padding: 2.5rem;
        margin-top: 3rem;
    }

    .project-info h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .project-info p {
        color: var(--text-gray);
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .project-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .project-meta div strong {
        color: var(--text-bright);
        font-size: 0.875rem;
    }

    .project-meta div p {
        color: var(--text-gray);
        font-size: 0.9rem;
        margin: 0.5rem 0 0 0;
    }

    @media (max-width: 768px) {
        .team-grid {
            grid-template-columns: 1fr;
        }
        .section-title {
            font-size: 1.75rem;
        }
    }
</style>

    <section>
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Operational Unit</span>
                <h2 class="section-title">Development Team</h2>
                <p class="section-subtitle">Elite engineering unit from Pentecost University's Faculty of Engineering, Science and Computing. Deploying advanced solutions for environmental remediation.</p>
            </div>

            <div class="team-grid">
                <!-- Team Member 1 -->
                <div class="team-card">
                    <div class="team-avatar">👨‍💻</div>
                    <h3>Kwame Mensah</h3>
                    <p class="role">Lead Architect</p>
                    <p>"Technology is the weapon against environmental degradation. This platform represents the fusion of code and conservation."</p>
                    <div class="team-role-detail">
                        <strong>Function:</strong>
                        <p>Full-Stack Systems & Database Architecture</p>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="team-card">
                    <div class="team-avatar">👩‍💻</div>
                    <h3>Abena Osei</h3>
                    <p class="role">Interface Engineer</p>
                    <p>"Design is not just aesthetics—it's the bridge between complex systems and human understanding. Every pixel serves the mission."</p>
                    <div class="team-role-detail">
                        <strong>Function:</strong>
                        <p>Frontend Design & User Experience Systems</p>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="team-card">
                    <div class="team-avatar">👨‍🔬</div>
                    <h3>Emmanuel Agyeman</h3>
                    <p class="role">Data Operations</p>
                    <p>"Data integrity is mission-critical. Our database architecture ensures every metric is captured, secured, and actionable."</p>
                    <div class="team-role-detail">
                        <strong>Function:</strong>
                        <p>Database Architecture & Security Protocols</p>
                    </div>
                </div>

                <!-- Team Member 4 -->
                <div class="team-card">
                    <div class="team-avatar">👩‍🔬</div>
                    <h3>Grace Boateng</h3>
                    <p class="role">Security Lead</p>
                    <p>"Security is not an add-on—it's foundational. Every layer of our system is hardened against threats to protect our users."</p>
                    <div class="team-role-detail">
                        <strong>Function:</strong>
                        <p>Authentication & Data Protection Systems</p>
                    </div>
                </div>

                <!-- Team Member 5 -->
                <div class="team-card">
                    <div class="team-avatar">👨‍🎓</div>
                    <h3>Samuel Asante</h3>
                    <p class="role">Content Operations</p>
                    <p>"Communication is the deployment vector for awareness. Our content strategy ensures the message reaches every target."</p>
                    <div class="team-role-detail">
                        <strong>Function:</strong>
                        <p>Content Management & Documentation</p>
                    </div>
                </div>

                <!-- Team Member 6 -->
                <div class="team-card">
                    <div class="team-avatar">👩‍🎓</div>
                    <h3>Rebecca Darko</h3>
                    <p class="role">Quality Assurance</p>
                    <p>"Reliability is non-negotiable. Our testing protocols ensure the platform performs flawlessly under all operational conditions."</p>
                    <div class="team-role-detail">
                        <strong>Function:</strong>
                        <p>Quality Assurance & Testing Operations</p>
                    </div>
                </div>
            </div>

            <!-- Project Information -->
            <div class="project-info">
                <h2>Mission Specifications</h2>
                <p>This web application was developed as a Level 300 Semester Project for the course PUIS304 (Plastic Pollutions) at Pentecost University's Faculty of Engineering, Science and Computing.</p>
                <div class="project-meta">
                    <div>
                        <strong>Course Designation:</strong>
                        <p>PUIS304 - Plastic Pollutions</p>
                    </div>
                    <div>
                        <strong>Operational Unit:</strong>
                        <p>Engineering, Science and Computing</p>
                    </div>
                    <div>
                        <strong>Clearance Level:</strong>
                        <p>Level 300</p>
                    </div>
                    <div>
                        <strong>Deployment Cycle:</strong>
                        <p>2025/2026</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
