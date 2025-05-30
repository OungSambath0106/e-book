<div class="form-section" id="resetPasswordForm">
    <div class="success-icon">
        <span>✓</span>
    </div>
    <h3 style="text-align: center; margin-bottom: 20px; color: #4a5568;">Reset Password</h3>

    <form id="resetPasswordFormElement" method="POST">
        @csrf
        <div class="form-group">
            <label for="newPassword">New Password</label>
            <input type="password" id="newPassword" class="form-input" placeholder="Enter your new password" required>
        </div>

        <div class="form-group">
            <label for="confirmNewPassword">Confirm New Password</label>
            <input type="password" id="confirmNewPassword" class="form-input" placeholder="Confirm your new password" required>
        </div>

        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>
