<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sejarah Saringan</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body>
        @include('components.logo-header')
        
        <div class="screening-history-main">
            <div class="screening-history-wrapper">
                <h1 class="screening-history-title">Sejarah Saringan</h1>
                <button class="screening-history-edit" onclick="toggleEditMode()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="screening-history-cards">
                    @foreach($screenings as $screening)
                        <div class="screening-history-card" data-id="{{ $screening['id'] }}">
                            <div class="screening-history-border"></div>
                            <div class="screening-history-info">
                                <div class="screening-history-name">{{ $screening['child_name'] }}</div>
                                <div class="screening-history-date">
                                    {{ $screening['created_at']->format('j F Y') }} - {{ $screening['checklist_age'] }} Month
                                </div>
                                @if(!empty($screening['checklist_ages']))
                                    <div class="screening-history-ages">
                                        <span class="screening-history-label">Checklists:</span>
                                        @foreach($screening['checklist_ages'] as $index => $age)
                                            <span class="screening-history-age">{{ $age }} Month</span>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="screening-history-status {{ $screening['has_delay'] ? 'delayed' : 'normal' }}">
                                    {{ $screening['has_delay'] ? 'DELAYED' : 'NORMAL' }}
                                </div>
                            </div>
                            <div class="screening-history-actions">
                                <button type="button" class="screening-history-delete" data-id="{{ $screening['id'] }}">
                                    DELETE
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div id="deleteModal" class="screening-history-modal">
            <div class="screening-history-modal-content">
                <h3>Adakah anda pasti mahu memadamkan rekod ini?</h3>
                <div class="screening-history-modal-buttons">
                    <button class="screening-history-cancel" onclick="cancelDelete()">Batal</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="screening-history-confirm">Padam</button>
                    </form>
                </div>
            </div>
        </div>

        <footer class="login-footer">
            <p>&copy; 2024 - Kevin - All Rights Reserved</p>
        </footer>

        <script>
            let isEditMode = false;
            const cards = document.querySelectorAll('.screening-history-card');
            const editButton = document.querySelector('.screening-history-edit');
            const deleteButtons = document.querySelectorAll('.screening-history-delete');
            const modal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');

            // Toggle edit mode
            function toggleEditMode() {
                isEditMode = !isEditMode;
                editButton.classList.toggle('active', isEditMode);
                
                cards.forEach(card => {
                    card.classList.toggle('edit-mode', isEditMode);
                });
            }

            // Handle card clicks
            cards.forEach(card => {
                card.addEventListener('click', (e) => {
                    if (!isEditMode && !e.target.classList.contains('screening-history-delete')) {
                        const id = card.dataset.id;
                        window.location.href = `/screening-history/${id}/result`;
                    }
                });
            });

            // Handle delete button clicks
            deleteButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const id = button.dataset.id;
                    deleteForm.action = `/screening/${id}/delete`;
                    modal.style.display = 'block';
                });
            });

            // Cancel delete
            function cancelDelete() {
                modal.style.display = 'none';
            }

            // Close modal when clicking outside
            window.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });

            
        </script>
    </body>
</html>