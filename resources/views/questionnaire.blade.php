<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $child_age_in_months }} Month Milestone Checklist</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="questionnaire-container">
    <h2>{{ $child_age_in_months }} Month Milestone Checklist (* = Critical)</h2>

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

        @foreach($milestoneQuestions as $question)
        <div class="milestone-question" data-domain="{{ $question->domain }}" style="display: none;">
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
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const yesButtons = document.querySelectorAll('.yes-button');
        const notYetButtons = document.querySelectorAll('.not-yet-button');
        const form = document.getElementById('milestone-form');
        const tabButtons = document.querySelectorAll('.tab-button');
        const questions = document.querySelectorAll('.milestone-question');

        // Tab switching functionality
        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                const domain = this.getAttribute('data-domain');

                // Hide all questions and show only those matching the selected domain
                questions.forEach(question => {
                    question.style.display = question.getAttribute('data-domain') === domain ? 'block' : 'none';
                });

                // Remove 'active' class from all tab buttons and add it to the clicked tab
                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Initialize first tab as active and display relevant questions
        if (tabButtons.length > 0) {
            tabButtons[0].click();
        }

        // Handle Yes/No button clicks
        yesButtons.forEach(button => {
            button.addEventListener('click', function() {
                const milestoneId = this.getAttribute('data-milestone-id');
                document.getElementById('milestone-' + milestoneId).value = 1; // 1 for Yes
                this.classList.add('active');
                this.nextElementSibling.classList.remove('active');
            });
        });

        notYetButtons.forEach(button => {
            button.addEventListener('click', function() {
                const milestoneId = this.getAttribute('data-milestone-id');
                document.getElementById('milestone-' + milestoneId).value = 0; // 0 for Not Yet
                this.classList.add('active');
                this.previousElementSibling.classList.remove('active');
            });
        });

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
