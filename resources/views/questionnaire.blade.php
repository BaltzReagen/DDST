<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0"
    <title>{{ $child_age_in_months }} Month Milestone Checklist</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    @include('components.logo-header')
    
    <div class="background-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="back-button">
        <button class="back-btn" id="returnButton"><span>←</span> Kembali</button>
    </div>

    <div class="questionnaire-container">
        <h2>
            <span class="title-main">SENARAI SEMAK PENGESANAN {{ $child_age_in_months >= 18 ? 'PERKEMBANGAN KANAK-KANAK' : 'PERKEMBANGAN BAYI' }} {{ $child_age_in_months >= 24 ? floor($child_age_in_months/12) . ' TAHUN' : $child_age_in_months . ' BULAN' }}</span>
            <span class="title-sub">(Untuk kegunaan {{ $child_age_in_months >= 18 ? 'kanak-kanak' : 'bayi' }} berumur {{ $child_age_in_months }} bulan hingga 
                {{ $child_age_in_months == 1 ? '2' : 
                ($child_age_in_months <= 9 ? $child_age_in_months + 2 : 
                ($child_age_in_months <= 18 ? $child_age_in_months + 5 : 
                $child_age_in_months + 11)) }} bulan bagi tujuan pendidikan)</span>
        </h2>

        <div class="milestone-note">
            <p><span class="critical-indicator">!</span> Soalan yang ditandakan dengan asterisk (<span class="critical-indicator">*</span>) adalah soalan kritikal. Kanak-kanak akan gagal senarai semak ini jika gagal menjawab 1 soalan kritikal atau 2 soalan bukan kritikal.</p>
        </div>

        <!-- Navigation for domain types -->
        <div class="domain-tabs">
            @foreach ($domains as $domain)
                @if ($milestoneQuestions->where('domain', $domain)->count() > 0)
                    <button class="tab-button" data-domain="{{ $domain }}">{{ ucfirst(str_replace('_', ' ', $domain)) }}</button>
                @endif
            @endforeach
        </div>

        <!-- Form to submit answers -->
        <form id="milestone-form" method="POST" action="{{ route('submit.milestone') }}">
            @csrf
            <input type="hidden" name="screening_id" value="{{ $childId }}">
            @foreach($milestoneQuestions as $question)
            <div class="milestone-question" data-domain="{{ $question->domain }}">
                <div class="question-text">
                    <p>{{ $question->description }} @if($question->isCritical) <span class="critical-indicator">*</span> @endif</p>
                </div>
                <div class="media">
                    @if($question->youtube_title !== 'unavailable')
                        <iframe src="https://www.youtube.com/embed/{{ $question->key }}" frameborder="0" allowfullscreen></iframe>
                    @else
                        @if($question->image_path !== 'unavailable')
                            <div style="display: none">Debug Path: {{ asset($question->image_path) }}</div>
                            <img src="{{ asset($question->image_path) }}" alt="Milestone Image" 
                                 onerror="console.log('Failed to load image:', this.src); this.src='{{ asset('images/image-coming-soon.jpg') }}';">
                        @else
                            <img src="{{ asset('images/image-coming-soon.jpg') }}" alt="Image Coming Soon">
                        @endif
                    @endif
                </div>
                <div class="response-buttons">
                    <input type="hidden" name="milestones[{{ $question->id }}]" id="milestone-{{ $question->id }}" value="">
                    <button type="button" class="yes-button" data-milestone-id="{{ $question->id }}">Yes</button>
                    <button type="button" class="not-yet-button" data-milestone-id="{{ $question->id }}">Not Yet</button>
                </div>
            </div>
            @endforeach

            <button type="submit" class="submit-button" disabled>Submit</button>
        </form>
    </div>

    <!-- Single Modal Implementation -->
    <div id="overlay" class="overlay"></div>
    <div id="popup-modal" class="modal">
        <div class="modal-content">
            <p>Oleh kerana anak tidak mencapai semua perkembangan yang sepatutnya pada umur ini, mereka perlu melengkapkan senarai semak umur sebelumnya untuk menilai tahap perkembangan semasa mereka.</p>
            <button type="button" id="understood-btn" class="understood-button">Understood</button>
        </div>
    </div>

    <footer class="dashboard-footer">
        <p>&copy; 2024 Kevin - All Rights Reserved</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoLink = document.getElementById('logo-link');
            if (logoLink) {
                logoLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (confirm('Adakah anda pasti mahu keluar? Semua jawapan akan hilang.')) {
                        // Clear any stored questionnaire data
                        sessionStorage.removeItem('questionnaire_completed');
                        sessionStorage.setItem('questionnaire_abandoned', 'true');
                        
                        // Clear session storage and redirect
                        window.onbeforeunload = null;
                        window.location.replace('{{ url("form") }}');
                    }
                });
            }
            
            if (sessionStorage.getItem('questionnaire_completed')) {
                window.location.replace('{{ url("form") }}');
                return;
            }

            // Prevent back button
            window.history.pushState(null, null, window.location.href);
            window.addEventListener('popstate', function(event) {
                window.history.pushState(null, null, window.location.href);
                window.location.replace('{{ url("form") }}');
            });

            // Cache DOM elements
            const form = document.getElementById('milestone-form');
            const submitButton = document.querySelector('.submit-button');
            const returnButton = document.getElementById('returnButton');
            const modal = document.getElementById('popup-modal');
            const overlay = document.getElementById('overlay');
            const understoodButton = document.getElementById('understood-btn');
            const tabButtons = document.querySelectorAll('.tab-button');
            const questions = document.querySelectorAll('.milestone-question');
            const yesButtons = document.querySelectorAll('.yes-button');
            const notYetButtons = document.querySelectorAll('.not-yet-button');

            // Prevent page navigation
            preventPageNavigation();

            // Check for abandoned questionnaire
            checkAbandonedQuestionnaire();

            // Initialize event listeners
            initializeEventListeners();

            // Initialize first tab
            if (tabButtons.length > 0) {
                tabButtons[0].click();
            }

            // Helper Functions
            function preventPageNavigation() {
                window.history.pushState(null, null, window.location.href);
                window.onpopstate = function() {
                    window.history.pushState(null, null, window.location.href);
                };

                window.onbeforeunload = function() {
                    return "Are you sure you want to leave? Your progress will be lost.";
                };
            }

            function checkAbandonedQuestionnaire() {
                if (sessionStorage.getItem('questionnaire_abandoned') === 'true' && 
                    document.referrer.includes('questionnaire')) {
                    window.location.replace('{{ url("form") }}');
                }
            }

            function initializeEventListeners() {
                // Return button handler
                returnButton.addEventListener('click', handleReturn);

                // Tab button handlers
                tabButtons.forEach(button => {
                    button.addEventListener('click', handleTabClick);
                });

                // Response button handlers
                yesButtons.forEach(button => {
                    button.addEventListener('click', () => handleResponse(button, true));
                });

                notYetButtons.forEach(button => {
                    button.addEventListener('click', () => handleResponse(button, false));
                });

                // Form submission handler
                form.addEventListener('submit', handleFormSubmit);

                // Modal handler
                understoodButton.addEventListener('click', handleUnderstood);
            }

            function handleReturn(e) {
                e.preventDefault();
                if (confirm("Are you sure you want to return? Your progress will not be saved.")) {
                    sessionStorage.setItem('questionnaire_abandoned', 'true');
                    window.location.replace('{{ url("form") }}');
                }
            }

            function handleTabClick() {
                const domain = this.getAttribute('data-domain');
                questions.forEach(question => {
                    question.style.display = question.getAttribute('data-domain') === domain ? 'block' : 'none';
                });
                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add(this.classList.contains('completed') ? 'completed active' : 'active');
            }

            function handleResponse(button, isYes) {
                const milestoneId = button.getAttribute('data-milestone-id');
                const input = document.getElementById('milestone-' + milestoneId);
                const otherButton = isYes ? button.nextElementSibling : button.previousElementSibling;

                if (button.classList.contains('active')) {
                    input.value = "";
                    button.classList.remove('active');
                } else {
                    input.value = isYes ? "1" : "0";
                    button.classList.add('active');
                    otherButton.classList.remove('active');
                }
                updateTabStatus();
                updateSubmitButtonState();
            }

            function updateTabStatus() {
                tabButtons.forEach(button => {
                    const domain = button.getAttribute('data-domain');
                    const domainQuestions = document.querySelectorAll(`.milestone-question[data-domain="${domain}"]`);
                    const allAnswered = Array.from(domainQuestions).every(question => {
                        return question.querySelector('input[type="hidden"]').value !== "";
                    });
                    button.classList.toggle('completed', allAnswered);
                });
            }

            function updateSubmitButtonState() {
                const allAnswered = Array.from(document.querySelectorAll('input[name^="milestones"]'))
                    .every(input => input.value !== "");
                submitButton.disabled = !allAnswered;
                submitButton.style.opacity = allAnswered ? '1' : '0.5';
                submitButton.style.backgroundColor = allAnswered ? '#2196F3' : '#ccc';
                submitButton.style.cursor = allAnswered ? 'pointer' : 'not-allowed';
            }

            function handleFormSubmit(e) {
                e.preventDefault();
                if (!validateForm()) {
                    return;
                }
                if (checkMilestonesCriteria()) {
                    submitButton.disabled = true;
                    window.onbeforeunload = null;
                    this.submit();
                }
            }

            function validateForm() {
                const unansweredQuestions = Array.from(document.querySelectorAll('input[name^="milestones"]'))
                    .filter(input => input.value === "");
                
                if (unansweredQuestions.length > 0) {
                    alert('Please answer all questions before submitting.');
                    const firstUnanswered = unansweredQuestions[0].closest('.milestone-question');
                    const domain = firstUnanswered.getAttribute('data-domain');
                    document.querySelector(`.tab-button[data-domain="${domain}"]`)?.click();
                    firstUnanswered.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return false;
                }
                return true;
            }

            function checkMilestonesCriteria() {
                let isCriticalFailed = false;
                let nonCriticalFailures = 0;

                questions.forEach(question => {
                    const input = question.querySelector('input[type="hidden"]');
                    const isCritical = question.querySelector('.question-text').innerText.includes('*');
                    
                    if (input.value === "0") {
                        if (isCritical) {
                            isCriticalFailed = true;
                        } else {
                            nonCriticalFailures++;
                        }
                    }
                });

                if (isCriticalFailed || nonCriticalFailures >= 2) {
                    showModal();
                    return false;
                }
                return true;
            }

            function showModal() {
                const overlay = document.getElementById('overlay');
                const modal = document.getElementById('popup-modal');
                
                // Prevent body scrolling when modal is open
                document.body.style.overflow = 'hidden';
                
                // Show overlay and modal with fade effect
                overlay.style.display = 'block';
                modal.style.display = 'block';
                
                // Optional: Add fade-in effect
                setTimeout(() => {
                    overlay.style.opacity = '1';
                    modal.style.opacity = '1';
                }, 10);
            }

            function handleUnderstood() {
                const overlay = document.getElementById('overlay');
                const modal = document.getElementById('popup-modal');
                
                // Restore body scrolling
                document.body.style.overflow = 'auto';
                
                // Hide overlay and modal
                overlay.style.display = 'none';
                modal.style.display = 'none';
                
                // Submit the form
                window.onbeforeunload = null;
                form.submit();
            }
        });
    </script>
</body>
</html>