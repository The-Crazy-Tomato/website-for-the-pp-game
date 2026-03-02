// === ПЕРЕВОДЫ ===
const translations = {
  ru: {
    'about': 'О игре',
    'heroes': 'Герои',
    'feedback': 'Отзыв',
    'news': 'Новости',
    'gallery': 'Галерея',
    'account': 'Аккаунт',
    'login': 'Войти',
    'register': 'Зарегистрироваться',
    'locations': 'Локации',
    'main-room': 'Главная комната',
    'interactions': 'Взаимодействие с объектами',
    'dialogues': 'Диалоги',
    'text-2': 'Мир этой истории — не просто фон, а живое пространство, наполненное настроением...',
    'text-3': 'Это ваше убежище — тёплое, личное пространство...',
    'text-4': 'Каждый день — это цепочка маленьких дел...',
    'text-5': 'Разговоры здесь — не просто текст на экране...',
    'home': 'Настройки',
    'settings': 'Настройки',
    'support': 'Служба поддержки',
    'download-game': 'Игра',
    'enjoy': 'приятного использования нашим сайтом :)',
    'characters': 'Персонажи',
    'privacy': 'Политика конфиденциальности',
    'copyright': '© 2025 Pocket World. Все права защищены.',
    'logout': 'Выйти'
  },
  en: {
    'about': 'About',
    'heroes': 'Heroes',
    'feedback': 'Feedback',
    'news': 'News',
    'gallery': 'Gallery',
    'account': 'Account',
    'login': 'Login',
    'register': 'Register',
    'locations': 'Locations',
    'main-room': 'Main Room',
    'interactions': 'Interactions with Objects',
    'dialogues': 'Dialogues',
    'text-2': 'The world of this story is not just a background, but a living space filled with mood...',
    'text-3': 'This is your refuge — a warm, personal space...',
    'text-4': 'Each day is a chain of small actions...',
    'text-5': 'Conversations here are not just text on the screen...',
    'home': 'Settings',
    'settings': 'Settings',
    'support': 'Support',
    'download-game': 'Game',
    'enjoy': 'enjoy using our site :)',
    'characters': 'Characters',
    'privacy': 'Privacy Policy',
    'copyright': '© 2025 Pocket World. All rights reserved.',
    'logout': 'Logout'
  }
};

function applyTranslations() {
  const lang = localStorage.getItem('userLang') || 'ru';
  document.querySelectorAll('[data-lang-key]').forEach(el => {
    const key = el.getAttribute('data-lang-key');
    if (translations[lang] && translations[lang][key]) {
      el.textContent = translations[lang][key];
    }
  });
  const currentLangEl = document.querySelector('.current-lang');
  if (currentLangEl) {
    currentLangEl.textContent = lang === 'ru' ? 'Ru' : 'En';
  }
}

function setLanguage(lang) {
  localStorage.setItem('userLang', lang);
  applyTranslations();
}

// Функция для получения имени пользователя из localStorage
function getUsername() {
  return localStorage.getItem('username') || 'User';
}

// Функция для проверки авторизации
function isUserLoggedIn() {
  return localStorage.getItem('isLoggedIn') === 'true';
}

// ОБНОВЛЁННАЯ ФУНКЦИЯ — ТОЛЬКО ССЫЛКИ, БЕЗ ВКЛАДОК
function updateAccountContent() {
  const isLoggedIn = isUserLoggedIn();
  const content = document.querySelector('.account-content');
  if (!content) return;

  const lang = localStorage.getItem('userLang') || 'ru';
  const username = getUsername();

  if (isLoggedIn) {
    // Получаем первую букву имени для аватара
    const firstLetter = username.charAt(0).toUpperCase();
    
    content.innerHTML = `
      <div class="account-header" style="text-align: center; margin-bottom: 20px;">
        <div style="width: 80px; height: 80px; border-radius: 50%; background: #AEC3B0; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; color: #01161E; font-size: 36px; font-weight: bold;">
          ${firstLetter}
        </div>
        <div class="account-username" style="font-size: 24px; color: #FFE5B4; font-family: 'Sjz', 'Uncial Antiqua', cursive;">${username}</div>
      </div>
      <nav class="account-nav">
        <a href="website/sidebar/settings.html" data-lang-key="settings">${translations[lang].settings}</a>
        <a href="website/sidebar/Help_Desk.html" data-lang-key="support">${translations[lang].support}</a>
        <a href="website/sidebar/review.html" data-lang-key="feedback">${translations[lang].feedback}</a>
      </nav>
      <a href="website/test_version_of_the_game/test_game.html" class="account-download" data-lang-key="download-game">${translations[lang]['download-game']}</a>
      <div class="account-divider" style="height: 2px; background: #2A6B84; margin: 20px 0;"></div>
      <div class="account-info" data-lang-key="enjoy" style="font-size: 18px; color: #E0E0E0; text-align: center; margin: 20px 0;">${translations[lang].enjoy}</div>
      <div class="account-copyright" data-lang-key="copyright" style="font-size: 16px; color: #B0B0B0; text-align: center; margin-top: 20px;">${translations[lang].copyright}</div>
      <button onclick="logout()" style="width: 100%; padding: 12px; margin-top: 15px; background: transparent; border: 2px solid #ff6b6b; color: #ff6b6b; border-radius: 8px; cursor: pointer; font-family: 'Sjz', 'Uncial Antiqua', cursive; font-size: 18px; transition: all 0.3s;" onmouseover="this.style.background='#ff6b6b'; this.style.color='#01161E'" onmouseout="this.style.background='transparent'; this.style.color='#ff6b6b'">${translations[lang].logout}</button>
    `;
  } else {
    content.innerHTML = `
      <a href="auth/register.html" class="login-register-btn" data-lang-key="register" style="font-size: 28px; margin: 10px 0; display: block; color: #FFE5B4; text-decoration: none; text-align: center;">${translations[lang].register}</a>
      <a href="auth/index.html" class="login-register-btn" data-lang-key="login" style="font-size: 28px; margin: 10px 0; display: block; color: #FFE5B4; text-decoration: none; text-align: center;">${translations[lang].login}</a>
      <div style="height: 2px; background: #2A6B84; margin: 20px 0;"></div>
      <nav class="account-nav">
        <a href="website/sidebar/settings.html" data-lang-key="home" style="font-size: 24px; margin: 10px 0; display: block; color: #FFE5B4; text-decoration: none;">${translations[lang].home}</a>
        <a href="website/sidebar/Help_Desk.html" data-lang-key="support" style="font-size: 24px; margin: 10px 0; display: block; color: #FFE5B4; text-decoration: none;">${translations[lang].support}</a>
        <a href="website/sidebar/review.html" data-lang-key="feedback" style="font-size: 24px; margin: 10px 0; display: block; color: #FFE5B4; text-decoration: none;">${translations[lang].feedback}</a>
      </nav>
      <a href="website/test_version_of_the_game/test_game.html" class="account-download" data-lang-key="download-game" style="font-size: 28px; margin: 15px 0; display: block; color: #FFE5B4; text-decoration: none; text-align: center;">${translations[lang]['download-game']}</a>
      <div style="height: 2px; background: #2A6B84; margin: 20px 0;"></div>
      <div class="account-info" data-lang-key="enjoy" style="font-size: 22px; color: #E0E0E0; text-align: center; margin: 20px 0;">${translations[lang].enjoy}</div>
      <div class="account-copyright" data-lang-key="copyright" style="font-size: 20px; color: #B0B0B0; text-align: center; margin-top: 20px;">${translations[lang].copyright}</div>
    `;
  }

  applyTranslations();
}

// Функция выхода
function logout() {
  localStorage.removeItem('isLoggedIn');
  localStorage.removeItem('username');
  localStorage.removeItem('userEmail');
  updateAccountContent();
  
  // Закрываем боковую панель
  const sidebar = document.getElementById('accountSidebar');
  if (sidebar) {
    sidebar.classList.remove('open');
  }
  
  // Показываем уведомление
  alert('Вы успешно вышли из аккаунта');
}

// Открытие/закрытие боковой панели
function initAccountSidebar() {
  const btn1 = document.getElementById('accountToggleBtn');
  const btn2 = document.getElementById('accountToggleBtnFooter');
  const sidebar = document.getElementById('accountSidebar');

  if (!sidebar) return;

  function toggleSidebar() {
    sidebar.classList.toggle('open');
    if (sidebar.classList.contains('open')) {
      updateAccountContent();
    }
  }

  [btn1, btn2].forEach(btn => {
    if (btn) btn.addEventListener('click', toggleSidebar);
  });

  document.addEventListener('click', (e) => {
    if (
      sidebar.classList.contains('open') &&
      !e.target.closest('.account-sidebar') &&
      !e.target.closest('.account-btn') &&
      !e.target.closest('.account-btn-footer')
    ) {
      sidebar.classList.remove('open');
    }
  });
}

// Инициализация
document.addEventListener('DOMContentLoaded', () => {
  // Проверяем авторизацию при загрузке
  if (isUserLoggedIn()) {
    console.log('Пользователь авторизован:', getUsername());
  }

  const savedLang = localStorage.getItem('userLang') || (navigator.language.startsWith('ru') ? 'ru' : 'en');
  setLanguage(savedLang);

  // Язык в шапке/подвале
  const langSelector = document.getElementById('languageSelector');
  const langDropdown = document.getElementById('langDropdown');
  
  if (langSelector && langDropdown) {
    langSelector.addEventListener('click', e => {
      e.stopPropagation();
      langDropdown.classList.toggle('show');
    });
    
    document.addEventListener('click', e => {
      if (!e.target.closest('#languageSelector')) {
        langDropdown.classList.remove('show');
      }
    });
    
    document.querySelectorAll('.lang-option').forEach(opt => {
      opt.addEventListener('click', () => {
        setLanguage(opt.getAttribute('data-lang'));
        langDropdown.classList.remove('show');
      });
    });
  }

  // Боковая панель
  initAccountSidebar();

  // Кнопка "Наверх"
  const scrollToTop = document.querySelector('.scroll-to-top');
  if (scrollToTop) {
    scrollToTop.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // VK
  const vkLink = document.getElementById('vk-link');
  if (vkLink) {
    vkLink.addEventListener('click', e => {
      e.preventDefault();
      alert('Извините, группа ВКонтакте пока не создана, но появится в ближайшее время!');
    });
  }

  // Якорные ссылки
  document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', e => {
      const href = link.getAttribute('href');
      if (href === '#' || href === '#/') return;
      const target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        window.scrollTo({ top: target.offsetTop - 80, behavior: 'smooth' });
      }
    });
  });
});