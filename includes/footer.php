</main>
    <!-- MAIN BODY END -->

    <!-- FOOTER START -->
    <style>
        .footer {
            background: var(--bg-surface);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-top: 1px solid var(--glass-border);
            color: var(--text-main);
            padding: 80px 0 40px 0;
            position: relative;
            overflow: hidden;
            margin-top: auto; /* Keeps footer pinned to bottom if content is short */
        }

        /* Top ambient horizontal trim */
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--glass-border-glow), transparent);
        }

        /* Subtle underlying visual anchor glow */
        .footer::after {
            content: '';
            position: absolute;
            bottom: -150px;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 300px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.04) 0%, transparent 70%);
            z-index: 1;
            pointer-events: none;
        }

        .footer-container {
            max-width: var(--max-width);
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 2;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 60px;
            margin-bottom: 60px;
        }

        .footer-section h3 {
            font-size: 0.815rem;
            font-weight: 700;
            margin-bottom: 24px;
            color: #00F2FE;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        /* Special brand header alignment with header styles */
        .footer-section .footer-brand-title {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            text-transform: uppercase;
            background: linear-gradient(135deg, var(--text-main) 30%, var(--text-muted));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 16px;
        }

        .footer-brand-desc {
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .footer-institution {
            color: #00F2FE;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(0, 242, 254, 0.08);
            padding: 0.35rem 0.75rem;
            border-radius: var(--radius-sm);
            border: 1px solid rgba(0, 242, 254, 0.15);
        }

        .footer-links-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links-list li {
            margin-bottom: 14px;
        }

        .footer-links-list a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--transition-premium);
            display: inline-flex;
            align-items: center;
        }

        .footer-links-list a:hover {
            color: var(--text-main);
            transform: translateX(6px);
        }

        /* Chevron indicator added inline dynamically via hover pseudo-elements */
        .footer-links-list a::before {
            content: '→';
            font-family: monospace;
            margin-right: 8px;
            opacity: 0;
            transform: translateX(-6px);
            transition: var(--transition-premium);
            color: #00F2FE;
        }

        .footer-links-list a:hover::before {
            opacity: 1;
            transform: translateX(0);
        }

        .footer-bottom {
            border-top: 1px solid var(--glass-border);
            padding-top: 32px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
            letter-spacing: 0.01em;
        }

        @media (max-width: 968px) {
            .footer-content {
                grid-template-columns: 1fr;
                gap: 48px;
            }

            .footer {
                padding: 60px 0 32px 0;
            }
            
            .footer-section h3 {
                margin-bottom: 16px;
            }
        }
    </style>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-brand-title">PlasticPollutions</div>
                    <p class="footer-brand-desc">Working together to architect, deploy, and execute systematic solutions for a plastic-free future.</p>
                    <div class="footer-institution">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Pentecost University — Environmental Action Group
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul class="footer-links-list">
                        <li><a href="<?= rtrim(BASE_URL, '/') ?>/">Home</a></li>
                        <li><a href="<?= rtrim(BASE_URL, '/') ?>/pages/latest.php">Field Logs</a></li>
                        <li><a href="<?= rtrim(BASE_URL, '/') ?>/pages/campaigns.php">Active Deployments</a></li>
                        <li><a href="<?= rtrim(BASE_URL, '/') ?>/pages/contact.php">Contact Us</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Solutions</h3>
                    <ul class="footer-links-list">
                        <li><a href="<?= rtrim(BASE_URL, '/') ?>/pages/what-to-do.php">Interceptor Blueprint</a></li>
                        <li><a href="<?= rtrim(BASE_URL, '/') ?>/pages/strategy.php">Our Strategy</a></li>
                        <li><a href="<?= rtrim(BASE_URL, '/') ?>/pages/developers.php">Our Team</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Get Involved</h3>
                    <ul class="footer-links-list">
                        <li><a href="<?= rtrim(BASE_URL, '/') ?>/pages/help.php">How You Can Help</a></li>
                        <li><a href="<?= rtrim(BASE_URL, '/') ?>/register.php">Join Us</a></li>
                        <li><a href="<?= rtrim(BASE_URL, '/') ?>/login.php">Login</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> PlasticPollutions — Pentecost University. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>