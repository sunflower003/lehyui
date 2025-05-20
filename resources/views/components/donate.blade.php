<!-- Nút donate bên phải -->
<div class="donate-button" id="donateToggle">DONATE</div>

<!-- Form Donate -->
<div class="donate-form" id="donateForm">
    <div class="donate-header">
        <span>Ủng hộ chúng tôi</span>
        <button id="closeDonate">&times;</button>
    </div>

    <p style="margin-bottom: 1rem;">
        Nếu bạn yêu thích chúng tôi, hãy đóng góp để website ngày càng phát triển với nhiều tính năng mới và cập nhật tin tức nóng hổi liên tục!
    </p>

    <form method="POST" action="{{ route('donate.redirect') }}">
        @csrf
        <div class="profile_form-group">
            <label class="profile_label">Số tiền ủng hộ (VNĐ)</label>
            <input type="number" name="amount" min="1000" placeholder="Nhập số tiền (VND)" required class="donate-input">
        </div>
        <button type="submit" class="profile_button profile_save" style="margin-top: 1rem;">Donate</button>
    </form>
</div>
