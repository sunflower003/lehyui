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
