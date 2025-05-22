<!-- Nút donate bên phải -->
<div class="donate-button" id="donateToggle">DONATE</div>

<!-- Form Donate -->
<div class="donate-form" id="donateForm">
        <div class="donate-header">
            <div class=""></div>
            <button id="closeDonate">&times;</button>
        </div>
        <h1 class="donate-title">Thank you for your support!</h1>
        <p class="donate-description donate-text">
            If you'd like to help create similar memories for others in our community, please consider donating so we can continue to fulfill our mission.
        </p>

            <h2>Select amount</h2>
            <div class="amount-options">
                <button type="button" class="active">$0.1</button>
                <button type="button">$1</button>
                <button type="button">$5</button>
                <button type="button">$10</button>
                <button type="button">$20</button>
            </div>


            <form method="POST" action="{{ route('donate.redirect') }}" class="donate-form_main">
                @csrf
                <label class="label_donate">Your Donation Amount</label>
              
                <input type="number" step="0.01" name="usd_amount" id="usdAmount" placeholder="Enter USD" required>
                <p id="vndHint" class="usd-hint">= 0 VND</p>
                <input type="hidden" name="amount" id="vndAmount">
                <span class="currency">VND</span>

                <a href="#" class="honor-link">Give in honor to another person</a>

                <button type="submit" class="donate-btn">Donate now</button>
            </form>


            <p class="terms-text terms">
            By donating, you agree to our <a href="#">terms of service</a> and <a href="#">privacy policy</a>.
            </p>
        
    </div>
