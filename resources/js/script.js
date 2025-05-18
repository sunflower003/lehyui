const avatarContainer = document.querySelector('.avatar_header_container');
const dropdown = document.querySelector('.dropdown');

avatarContainer.addEventListener('mouseenter', () => {
  dropdown.style.display = 'flex'; // Hiển thị trước để transition hoạt động
  setTimeout(() => {
    dropdown.classList.add('show');
  }, 10); // Delay nhỏ để trình duyệt kịp render
});

avatarContainer.addEventListener('mouseleave', () => {
  dropdown.classList.remove('show');
  // Đợi animation hoàn tất mới ẩn
  setTimeout(() => {
    if (!dropdown.classList.contains('show')) {
      dropdown.style.display = 'none';
    }
  }, 300); // Trùng với thời gian transition (0.3s)
});


// Donate form transition

const donateToggle = document.getElementById('donateToggle');
const donateForm = document.getElementById('donateForm');
const closeDonate = document.getElementById('closeDonate');

donateToggle.addEventListener('click', () => {
  donateForm.classList.add('active');
});

closeDonate.addEventListener('click', () => {
  donateForm.classList.remove('active');
});



//Profile tabs
const menuItems = document.querySelectorAll(".profile_menu-item");
  const tabs = {
    "General": "profile_general",
    "Edit Profile": "profile_edit",
    "Password": "profile_password",
    // bạn có thể thêm các tab khác nếu cần
  };

  menuItems.forEach(item => {
    item.addEventListener("click", () => {
      // Gỡ class active khỏi tất cả
      menuItems.forEach(i => i.classList.remove("active"));
      item.classList.add("active");

      // Ẩn tất cả tab
      Object.values(tabs).forEach(id => {
        document.getElementById(id).style.display = "none";
      });

      // Hiện tab tương ứng
      const tabName = item.innerText.trim();
      const tabId = tabs[tabName];
      if (tabId) {
        document.getElementById(tabId).style.display = "block";
      }
    });
  });
