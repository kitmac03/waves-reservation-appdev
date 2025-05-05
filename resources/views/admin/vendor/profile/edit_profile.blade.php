@extends('admin.vendor.profile')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ven_editprof.css') }}">
@endsection

@section('profile-content')
    <div class="main-content">
        <div class="profile-container">
            <div class="profile-card">
                <h2>Edit Profile</h2>

                <!-- Error Messages (e.g., email already taken) -->
                @if($errors->any())
                    <div class="alert alert-error" style="color: red; font-size: 18px; margin-bottom: 15px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-section">
                    <form id="editProfileForm" method="POST"
                        action="{{ route('admin.vendor.profile.update', ['id' => $vendor->id])}}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <div class="input-item">
                                <i class="material-icons">person</i>
                                <input type="text" class="form-input" name="name" value="{{ $vendor->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <div class="input-item">
                                <i class="material-icons">email</i>
                                <input type="email" class="form-input" name="email" value="{{ $vendor->email }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Contact No.</label>
                            <div class="input-item">
                                <i class="material-icons">phone</i>
                                <input type="tel" class="form-input" name="number" value="{{ $vendor->number }}">
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-cancel" id="cancelBtn">Cancel</button>
                            <button type="button" class="btn btn-save" id="saveBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Changes Confirmation Modal -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to make changes?</p>
            <div class="modal-buttons">
                <button class="btn-cancel-modal" id="cancelModalBtn">Cancel</button>
                <button class="btn-yes" id="yesBtn">Yes</button>
            </div>
        </div>
    </div>

    <!-- Cancel Changes Confirmation Modal -->
    <div id="confirmCancelModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to cancel the changes?</p>
            <div class="modal-buttons">
                <button class="btn-cancel-modal" id="cancelCancelModalBtn">Cancel</button>
                <button class="btn-yes" id="yesCancelBtn">Yes</button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const saveBtn = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const modal = document.getElementById('confirmModal');
        const cancelModal = document.getElementById('confirmCancelModal');
        const yesBtn = document.getElementById('yesBtn');
        const cancelModalBtn = document.getElementById('cancelModalBtn');
        const yesCancelBtn = document.getElementById('yesCancelBtn');
        const cancelCancelModalBtn = document.getElementById('cancelCancelModalBtn');
        const form = document.getElementById('editProfileForm');

        // When Save button is clicked, show modal
        saveBtn.addEventListener('click', () => {
            modal.style.display = 'block';
        });

        // When Yes is clicked on Save, submit the form and close modal
        yesBtn.addEventListener('click', () => {
            modal.style.display = 'none';
            form.submit(); // Submit form to update profile
        });

        // When Cancel in Save modal is clicked, close modal
        cancelModalBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // When Cancel button is clicked, show the cancel confirmation modal
        cancelBtn.addEventListener('click', () => {
            cancelModal.style.display = 'block';
        });

        // When Yes is clicked on Cancel, redirect to profile page
        yesCancelBtn.addEventListener('click', () => {
            cancelModal.style.display = 'none';
            window.location.href = "{{ route('admin.vendor.profile') }}"; // Redirect to profile page
        });

        // When Cancel in Cancel modal is clicked, close modal
        cancelCancelModalBtn.addEventListener('click', () => {
            cancelModal.style.display = 'none';
        });
    </script>
@endsection