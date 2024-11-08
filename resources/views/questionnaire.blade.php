<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $child_age_in_months }} Month Milestone Checklist</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

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
            <input type="hidden" name="screening_id" value="{{ $screeningId }}">
            @foreach($milestoneQuestions as $question)
            <div class="milestone-question" data-domain="{{ $question->domain }}">
                <div class="question-text">
                    <p>{{ $question->description }} @if($question->isCritical) (*) @endif</p>
                </div>
                <div class="media">
                    @if($question->youtube_title !== 'unavailable')
                        <iframe src="https://www.youtube.com/embed/{{ $question->key }}" frameborder="0" allowfullscreen></iframe>
                    @else
                        <img src="{{ asset('images/image-coming-soon.jpg') }}" alt="Image Coming Soon">
                    @endif
                </div>
                <div class="response-buttons">
                    <input type="hidden" name="milestones[{{ $question->id }}]" id="milestone-{{ $question->id }}" value="">
                    <button type="button" class="yes-button" data-milestone-id="{{ $question->id }}">Yes</button>
                    <button type="button" class="not-yet-button" data-milestone-id="{{ $question->id }}">Not Yet</button>
                </div>
            </div>
            @endforeach

            <!-- Submit button at the end -->
            <button type="submit" class="submit-button">Submit</button>
            <div id="overlay" style="display: none;"></div>
            <div id="popup-modal" style="display: none;">
                <p>Since the child failed to achieve all the milestones expected of their age, they now need to complete the previous age checklist to assess their current developmental age.</p>
                <button type="button" id="understood-btn">Understood</button>
            </div>
        </form>
    </div>

    <footer class="dashboard-footer">
        <p>&copy; 2024 Kevin - All Rights Reserved</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if user abandoned a previous questionnaire
            if (sessionStorage.getItem('questionnaire_abandoned') === 'true' && 
                document.referrer.includes('questionnaire')) {
                window.location.replace('{{ url("form") }}');
            }

            const yesButtons = document.querySelectorAll('.yes-button');
            const notYetButtons = document.querySelectorAll('.not-yet-button');
            const form = document.getElementById('milestone-form');
            const tabButtons = document.querySelectorAll('.tab-button');
            const questions = document.querySelectorAll('.milestone-question');
            const returnButton = document.getElementById('returnButton');
            const modal = document.getElementById("popup-modal");
            const understoodButton = document.getElementById("understood-btn");
            const submitButton = document.querySelector('.submit-button');
            const overlay = document.getElementById("overlay");
            
            // Display the modal
            function showModal() {
                overlay.style.display = "block";
                modal.style.display = "block";
            }       

            // Handle "Understood" button click to proceed
            understoodButton.addEventListener("click", function() {
                overlay.style.display = "block";
                modal.style.display = "none";
                form.submit(); // Submit the form after understanding
            });

            // Check milestone criteria before form submission
            function checkMilestoneBeforeSubmit() {
                let isCriticalFailed = false;
                let nonCriticalFailures = 0;

                document.querySelectorAll('.milestone-question').forEach(question => {
                    const input = question.querySelector('input[type="hidden"]');
                    const isCritical = question.querySelector('.question-text').innerText.includes('*');
                    
                    if (input.value === "0") { // "Not Yet" response
                        if (isCritical) {
                            isCriticalFailed = true;
                        } else {
                            nonCriticalFailures++;
                        }
                    }
                });

                if (isCriticalFailed || nonCriticalFailures >= 2) {
                    showModal();
                    return false; // Prevent form from submitting immediately
                }
                return true;
            }

            // Separate the tab functionality from form submission
            submitButton?.addEventListener("click", function(event) {
                event.preventDefault(); // Prevent immediate submission

                if (checkMilestoneBeforeSubmit()) {
                    form.submit(); // Submit only if criteria are met
                }
            });
            
            // Confirmation popup for Return button
            returnButton.addEventListener('click', function (e) {
                e.preventDefault();
                const confirmReturn = confirm("Are you sure you want to return? Your progress will not be saved.");
                if (confirmReturn) {
                    // Clear browser history and redirect
                    window.location.replace('{{ url("form") }}');
                    
                    // Additional security: Add entry to session storage
                    sessionStorage.setItem('questionnaire_abandoned', 'true');
                }
            });

            // Tab switching functionality
            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const domain = this.getAttribute('data-domain');

                    // Hide all questions and show only those matching the selected domain
                    questions.forEach(question => {
                        question.style.display = question.getAttribute('data-domain') === domain ? 'block' : 'none';
                    });

                    // Remove 'active' class from all tab buttons
                    tabButtons.forEach(btn => btn.classList.remove('active'));

                    // Check if the current tab is completed and add appropriate classes
                    if (this.classList.contains('completed')) {
                        this.classList.add('completed', 'active');
                    } else {
                        this.classList.add('active');
                    }
                });
            });

            // Initialize first tab as active and display relevant questions
            if (tabButtons.length > 0) {
                tabButtons[0].click();
            }

            // Handle Yes/No button clicks with toggle functionality
            yesButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const milestoneId = this.getAttribute('data-milestone-id');
                    const input = document.getElementById('milestone-' + milestoneId);

                    if (this.classList.contains('active')) {
                        // If already active, deselect it
                        input.value = "";
                        this.classList.remove('active');
                    } else {
                        // If not active, select it and deselect the other button
                        input.value = 1; // 1 for Yes
                        this.classList.add('active');
                        this.nextElementSibling.classList.remove('active');
                    }
                    updateTabStatus();
                });
            });

            notYetButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const milestoneId = this.getAttribute('data-milestone-id');
                    const input = document.getElementById('milestone-' + milestoneId);

                    if (this.classList.contains('active')) {
                        // If already active, deselect it
                        input.value = "";
                        this.classList.remove('active');
                    } else {
                        // If not active, select it and deselect the other button
                        input.value = 0; // 0 for Not Yet
                        this.classList.add('active');
                        this.previousElementSibling.classList.remove('active');
                    }
                    updateTabStatus();
                });
            });

            // Update tab colors based on completion status of questions
            function updateTabStatus() {
                tabButtons.forEach(button => {
                    const domain = button.getAttribute('data-domain');
                    const domainQuestions = document.querySelectorAll(`.milestone-question[data-domain="${domain}"]`);
                    let allAnswered = true;

                    domainQuestions.forEach(question => {
                        const input = question.querySelector('input[type="hidden"]');
                        if (input.value === "") {
                            allAnswered = false;
                        }
                    });

                    // Update tab color: green if completed, remove completed if not
                    if (allAnswered) {
                        button.classList.add('completed');
                    } else {
                        button.classList.remove('completed');
                    }
                });
            }

            // Validation to ensure all questions are answered before submitting
            form.addEventListener('submit', function (e) {
                const inputs = document.querySelectorAll('input[type="hidden"]');
                let allAnswered = true;

                inputs.forEach(input => {
                    if (input.value === "") {
                        allAnswered = false;
                    }
                });

                if (!allAnswered) {
                    alert('Please answer all questions before submitting.');
                    e.preventDefault();
                }
            });
        });
    </script>

</body>
</html>
