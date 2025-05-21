document.addEventListener("DOMContentLoaded", function () {
  // Avatar Dropdown
  const avatarContainer = document.querySelector('.avatar_header_container');
  const dropdown = document.querySelector('.dropdown');

  let hideTimeout = null;

  if (avatarContainer && dropdown) {
    avatarContainer.addEventListener('mouseenter', () => {
      clearTimeout(hideTimeout); // Hủy ẩn nếu đang đếm ngược
      dropdown.style.display = 'flex';
      setTimeout(() => {
        dropdown.classList.add('show');
      }, 10);
    });

    avatarContainer.addEventListener('mouseleave', () => {
      hideTimeout = setTimeout(() => {
        dropdown.classList.remove('show');
        setTimeout(() => {
          if (!dropdown.classList.contains('show')) {
            dropdown.style.display = 'none';
          }
        }, 300);
      }, 500); // ⏳ Trễ 1 giây mới ẩn
    });
  }

  // Donate Form
  const donateToggle = document.getElementById('donateToggle');
  const donateForm = document.getElementById('donateForm');
  const closeDonate = document.getElementById('closeDonate');

  if (donateToggle && donateForm && closeDonate) {
    donateToggle.addEventListener('click', () => {
      donateForm.classList.add('active');
    });

    closeDonate.addEventListener('click', () => {
      donateForm.classList.remove('active');
    });
  }

  // Profile Tabs
  const menuItems = document.querySelectorAll(".profile_menu-item");
  const tabs = {
    "General": "profile_general",
    "Edit Profile": "profile_edit",
    "Password": "profile_password",
    // thêm tab khác nếu cần
  };

  const profileWrapper = document.querySelector(".profile_wrapper");
  const activeTabFromSession = profileWrapper?.dataset?.activeTab || 'profile_general';

  // Hiển thị đúng tab sau reload
  document.querySelectorAll('.profile_tab-content').forEach(el => el.style.display = 'none');
  document.querySelectorAll('.profile_menu-item').forEach(el => el.classList.remove('active'));

  const targetTab = document.getElementById(activeTabFromSession);
  if (targetTab) targetTab.style.display = 'block';

  const indexMap = {
    'profile_general': 0,
    'profile_edit': 1,
    'profile_password': 2
  };
  const tabIndex = indexMap[activeTabFromSession];
  if (typeof tabIndex !== 'undefined') {
    const menuItem = document.querySelectorAll('.profile_menu-item')[tabIndex];
    if (menuItem) menuItem.classList.add('active');
  }

  // Chuyển tab khi click
  menuItems.forEach(item => {
    item.addEventListener("click", () => {
      menuItems.forEach(i => i.classList.remove("active"));
      item.classList.add("active");

      Object.values(tabs).forEach(id => {
        const tab = document.getElementById(id);
        if (tab) tab.style.display = "none";

      });

      const tabName = item.innerText.trim();
      const tabId = tabs[tabName];
      const tab = document.getElementById(tabId);
      if (tab) tab.style.display = "block";
    });
  });



  //choose donate amount
  const buttons = document.querySelectorAll('.amount-options button');
    const amountInput = document.querySelector('input[name="amount"]');
    const usdToVndRate = 26500;

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            // Bỏ class active khỏi tất cả nút
            buttons.forEach(btn => btn.classList.remove('active'));
            // Gán class active cho nút được bấm
            button.classList.add('active');

            // Lấy số tiền USD từ nội dung nút, ví dụ "$5" → 5
            const usd = parseFloat(button.innerText.replace('$', ''));
            const vnd = usd * usdToVndRate;

            // Gán vào input
            amountInput.value = vnd;
        });
    });





   
    const toggles = document.querySelectorAll('.comment_menu_toggle');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            const menuId = this.getAttribute('data-id');
            const menu = document.getElementById(menuId);

            // Ẩn tất cả menu khác
            document.querySelectorAll('.comment_menu').forEach(m => {
                if (m.id !== menuId) m.classList.add('hidden');
            });

            // Toggle menu hiện tại
            if (menu) menu.classList.toggle('hidden');
        });
    });

    // Ẩn khi click ngoài
    document.addEventListener('click', function () {
        document.querySelectorAll('.comment_menu').forEach(m => m.classList.add('hidden'));
    });

    //showmore comments
    
        const comments = document.querySelectorAll('.comments_display .comment');
        const showMoreBtn = document.getElementById('showMoreBtn');
        let visibleCount = 3;

        if (showMoreBtn) {
            showMoreBtn.addEventListener('click', function () {
                const total = comments.length;
                const nextVisible = Math.min(visibleCount + 3, total);

                for (let i = visibleCount; i < nextVisible; i++) {
                    comments[i].classList.remove('hidden-comment');
                }

                visibleCount = nextVisible;

                if (visibleCount >= total) {
                    showMoreBtn.style.display = 'none';
                }
            });
        }



                  // active scroll up
          let scrollBtn = document.querySelector('.scroll-up');

          function scrollUp() {
              let scrollY = window.scrollY;
              if(scrollY > 800) {
                  scrollBtn.classList.add('active');
              } else {
                  scrollBtn.classList.remove('active');
              }
          }

          window.addEventListener('scroll', scrollUp);

  

});
