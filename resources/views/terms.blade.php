<x-dashboard-layout>
    <div class="dashboard-container offset" style="display:grid;">
        <div class="card span-full">
            <h2 style="margin-top:0;">Terms & Conditions</h2>
            <p class="text" style="margin:0 0 12px; color:#666;">Last updated: {{ now()->format('F d, Y') }}</p>

            <div style="display:grid; gap:12px; text-align:left;">
                <div>
                    <h3 style="margin:0 0 6px;">1. Purpose</h3>
                    <p class="text">NutriTrack provides tools for tracking health records, water intake, exercise, nutrition, goals, and AI-powered recommendations to support wellness and learning.</p>
                </div>
                <div>
                    <h3 style="margin:0 0 6px;">2. Eligibility</h3>
                    <p class="text">Use is limited to authorized users (students, staff, or administrators) with valid accounts provisioned by the institution or system administrator.</p>
                </div>
                <div>
                    <h3 style="margin:0 0 6px;">3. Accounts & Security</h3>
                    <p class="text">You are responsible for maintaining the confidentiality of your login credentials and for all activities under your account. Notify administrators immediately if you suspect unauthorized access.</p>
                </div>
                <div>
                    <h3 style="margin:0 0 6px;">4. Data & Privacy</h3>
                    <p class="text">We process personal and health-related data you enter (e.g., height, weight, intake, goals, tips). Data is used to deliver features such as reports and AI suggestions. Refer to the Privacy Policy for details on collection, storage, retention, and rights. Do not submit data you are not authorized to share.</p>
                </div>
                <div>
                    <h3 style="margin:0 0 6px;">5. Acceptable Use</h3>
                    <p class="text">Do not misuse the system, attempt to breach security, disrupt service, or submit harmful, unlawful, or infringing content. Respect others’ privacy and follow institutional policies.</p>
                </div>
                <div>
                    <h3 style="margin:0 0 6px;">6. AI Recommendations</h3>
                    <p class="text">AI-generated suggestions are informational and do not constitute medical advice. Always consult qualified health professionals before making significant health decisions.</p>
                </div>
                <div>
                    <h3 style="margin:0 0 6px;">7. Content Ownership</h3>
                    <p class="text">You retain ownership of your data. You grant NutriTrack a limited license to process your data solely to provide the service features (e.g., charts, insights, recommendations). Administrators may access data as required by policy.</p>
                </div>
                <div>
                    <h3 style="margin:0 0 6px;">8. Availability & Changes</h3>
                    <p class="text">We strive for reliable service but do not guarantee uninterrupted availability. Features may change, be added, or removed. We will provide reasonable notice for material changes.</p>
                </div>
                <div>
                    <h3 style="margin:0 0 6px;">9. Disclaimers & Liability</h3>
                    <p class="text">The service is provided "as is" without warranties. To the maximum extent permitted by law, NutriTrack and its administrators are not liable for indirect or consequential losses arising from use of the system.</p>
                </div>
                <div>
                    <h3 style="margin:0 0 6px;">10. Termination</h3>
                    <p class="text">We may suspend or terminate accounts for policy violations, security concerns, or legal compliance. You may request account deletion pursuant to institutional and legal requirements.</p>
                </div>
                <div>
                    <h3 style="margin:0 0 6px;">11. Governing Law</h3>
                    <p class="text">These Terms are governed by the laws of your jurisdiction (set by your institution). Disputes will be handled per institutional procedures.</p>
                </div>
                <div>
                    <h3 style="margin:0 0 6px;">12. Contact</h3>
                    <p class="text">For questions or requests regarding these Terms, contact your system administrator.</p>
                </div>
                <div>
                    <h3 style="margin:0 0 6px;">13. Updates</h3>
                    <p class="text">We may update these Terms from time to time. Changes take effect upon publication. For significant changes, we will notify users via the dashboard.</p>
                </div>

                <div class="form-actions" style="margin-top:8px; display:flex; justify-content:flex-end; gap:10px;">
                    <a class="btn-card btn-secondary" href="{{ url()->previous() ?? route('dashboard') }}">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
