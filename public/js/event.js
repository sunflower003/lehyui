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

  if (menuItems.length > 0) {
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
  }
});
