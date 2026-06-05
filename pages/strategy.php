<?php
require_once __DIR__ . '/../auth.php';

trackVisitor();

$pageTitle = 'Our Strategy';
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

    .card {
        background: var(--dark-card);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 1rem;
        padding: 2.5rem;
        margin-bottom: 3rem;
    }

    .card h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
    }

    .card p {
        color: var(--text-gray);
        line-height: 1.8;
        font-size: 1.05rem;
    }

    .grid-4 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .info-card {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 0.75rem;
        padding: 1.5rem;
        border-left: 3px solid var(--cyan-glow);
    }

    .info-card h3 {
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .info-card p {
        color: var(--text-gray);
        line-height: 1.6;
        margin: 0;
        font-size: 0.95rem;
    }

    .timeline-card {
        text-align: center;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 0.75rem;
        padding: 2rem;
    }

    .timeline-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .timeline-card h3 {
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .timeline-card p {
        color: var(--text-gray);
        line-height: 1.6;
        margin: 0;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .grid-4 {
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
                <span class="section-badge">Strategic Framework</span>
                <h2 class="section-title">Mission Strategy</h2>
                <p class="section-subtitle">Comprehensive operational framework for systematic plastic contamination elimination through education, advocacy, and community engagement protocols.</p>
            </div>

            <!-- Vision -->
            <div class="card">
                <h2>Primary Objective</h2>
                <p>Establish a plastic-free operational environment where communities, businesses, and government entities collaborate to eliminate plastic contamination and secure planetary resources for future generations. Our target: a Ghana where plastic waste is systematically managed, recycled, or eliminated through sustainable alternative deployment.</p>
            </div>

            <!-- Goals -->
            <div class="card">
                <h2>Tactical Objectives</h2>
                <div class="grid-4">
                    <div class="info-card">
                        <h3>🎯 Reduce Contamination</h3>
                        <p>Achieve 50% reduction in single-use plastic deployment by 2030 through education and policy advocacy protocols.</p>
                    </div>
                    <div class="info-card">
                        <h3>♻️ Optimize Recycling</h3>
                        <p>Enhance recycling efficiency from 5% to 40% through infrastructure development and public awareness operations.</p>
                    </div>
                    <div class="info-card">
                        <h3>🌊 Marine Protection</h3>
                        <p>Reduce oceanic plastic contamination by 75% through coastal extraction and waste management optimization.</p>
                    </div>
                    <div class="info-card">
                        <h3>🎓 Education Deployment</h3>
                        <p>Reach 100,000 personnel with contamination education programs and sustainable alternative protocols.</p>
                    </div>
                </div>
            </div>

            <!-- Policies -->
            <div class="card">
                <h2>Operational Protocols</h2>
                <div class="grid-4">
                    <div class="info-card">
                        <h3>📜 Advocacy Protocol</h3>
                        <p>Execute advocacy for enhanced environmental legislation, plastic bans, and extended producer responsibility mandates. Collaborate with policymakers to develop effective regulatory frameworks.</p>
                    </div>
                    <div class="info-card">
                        <h3>🤝 Partnership Protocol</h3>
                        <p>Collaborate with commercial entities, NGOs, government agencies, and academic institutions to amplify operational impact and share best practices.</p>
                    </div>
                    <div class="info-card">
                        <h3>📊 Transparency Protocol</h3>
                        <p>Maintain complete operational transparency in activities, funding, and impact reporting to build trust with supporters and stakeholders.</p>
                    </div>
                    <div class="info-card">
                        <h3>🌍 Sustainability Protocol</h3>
                        <p>Execute mission protocols by minimizing environmental footprint through sustainable event planning and operational practices.</p>
                    </div>
                </div>
            </div>

            <!-- Long-term Vision -->
            <div class="card">
                <h2>Strategic Timeline</h2>
                <div class="grid-4">
                    <div class="timeline-card">
                        <div class="timeline-icon">📅</div>
                        <h3>2026-2028</h3>
                        <p>Build awareness and community engagement across operational sectors</p>
                    </div>
                    <div class="timeline-card">
                        <div class="timeline-icon">🏛️</div>
                        <h3>2028-2030</h3>
                        <p>Influence national policy and establish recycling infrastructure</p>
                    </div>
                    <div class="timeline-card">
                        <div class="timeline-icon">🌍</div>
                        <h3>2030-2035</h3>
                        <p>Expand regional operations and achieve significant contamination reduction</p>
                    </div>
                    <div class="timeline-card">
                        <div class="timeline-icon">✨</div>
                        <h3>Beyond 2035</h3>
                        <p>Lead Africa in contamination remediation solutions and innovation</p>
                    </div>
                </div>
            </div>

            <!-- Approach -->
            <div class="card">
                <h2>Operational Methodology</h2>
                <div class="grid-4">
                    <div class="info-card">
                        <h3>🎓 Education Priority</h3>
                        <p>Education is the foundation of operational change. Execute workshops, school programs, and community awareness campaigns to inform personnel about contamination and remediation solutions.</p>
                    </div>
                    <div class="info-card">
                        <h3>🤝 Community Integration</h3>
                        <p>Work directly with community sectors to understand challenges and co-create solutions optimized for specific contexts and operational requirements.</p>
                    </div>
                    <div class="info-card">
                        <h3>🔬 Data-Driven Operations</h3>
                        <p>Collect and analyze contamination data, recycling metrics, and campaign impact to inform strategic decisions and measure operational effectiveness.</p>
                    </div>
                    <div class="info-card">
                        <h3>💡 Innovation Support</h3>
                        <p>Support and promote innovative remediation solutions, including alternative materials, recycling technologies, and waste-to-energy conversion systems.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
