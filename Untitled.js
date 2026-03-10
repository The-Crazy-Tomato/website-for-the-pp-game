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
    'text-2': 'Погрузитесь в атмосферу загадочного дома, где каждая комната хранит мрачную тайну. От уютной квартиры главного героя до жуткого двухэтажного особняка — каждая локация раскрывает часть истории. Исследуйте просторную гостиную, функциональную кухню, детскую комнату без единого окна и множество других помещений, каждое из которых расскажет свою историю. Динамичное освещение и детализированные фоны создадут полное погружение в мир тайн и загадок.',
    'text-3': 'Ваше убежище и центр управления расследованием. Именно здесь вы будете анализировать полученную информацию, общаться с союзниками и планировать следующие шаги. Главная комната оснащена компьютером для поиска информации, телефоном для связи с персонажами и удобным рабочим столом. Здесь же находится ваша сумка с важными предметами и записной книжкой, где фиксируются все ключевые открытия.',
    'text-4': 'Игра предлагает интуитивно понятную систему взаимодействия. Просто наведите курсор на интересующий вас объект — если он подсветится, значит, с ним можно взаимодействовать. Открывайте двери, изучайте предметы, читайте документы и находите скрытые улики. Каждый найденный предмет может стать ключом к разгадке тайны дома. Система подсказок поможет не упустить важные детали, а инвентарь позволит организовать все найденные предметы.',
    'text-5': 'Живые и эмоциональные диалоги с персонажами раскроют сюжет и помогут лучше понять мотивы каждого героя. Выберите подходящий ответ в ключевых моментах — ваши решения могут повлиять на развитие отношений и ход расследования. Система диалогов включает как основные сцены с важными персонажами, так и дополнительные разговоры, раскрывающие детали истории. Каждая реплика наполнена атмосферой и характером персонажей.',
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
    'text-2': 'Immerse yourself in the atmosphere of a mysterious house where "My Room" holds a dark secret. From the protagonist\'s cozy apartment to the Creepy One\'s two-story mansion, the unique location reveals a piece of the story. Explore a spacious living room, a functional kitchen, a children\'s room without a complicated window, and many other rooms, each revealing its own story. Dynamic lighting and custom backdrops create a completely immersive world of mystery and enigma.',
    'text-3': 'Your safehouse and investigation command center. This is where you\'ll analyze information, communicate with allies, and plan your next steps. The main room is equipped with a computer for research, a phone for communicating with characters, and a comfortable work desk. This is also where you\'ll find your satchel containing important items and a notebook where you\'ll record all your key discoveries.',
    'text-4': 'The game offers an intuitive interaction system. Simply hover your cursor over an object of interest—if it highlights, you can interact with it. Open doors, examine objects, read documents, and discover hidden clues. Every item you find could be the key to solving the house\'s mystery. A hint system will help you avoid missing important details, and your inventory will help you organize all your finds.',
    'text-5': 'Lively and emotional dialogues with characters will reveal the plot and help you better understand each character\'s motives. Choose the appropriate response at key moments—your decisions can impact the development of relationships and the course of the investigation. The dialogue system includes both main scenes with important characters and additional conversations that reveal further details of the story. Each line is imbued with atmosphere and character.',
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

// Ф получения имени из localStorage
function getUsername() {
  return localStorage.getItem('username') || 'User';
}

// Ф для проверки авт
function isUserLoggedIn() {
  return localStorage.getItem('isLoggedIn') === 'true';
}

function updateAccountContent() {
  const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
  const content = document.querySelector('.account-content');
  if (!content) return;

  const lang = localStorage.getItem('userLang') || 'ru';
  const t = translations[lang];
  const username = localStorage.getItem('username') || 'User';
  const firstLetter = username.charAt(0).toUpperCase();

  // Проверяем, мобильное ли устройство
  const isMobile = window.innerWidth <= 768;

  if (isLoggedIn) {
    content.innerHTML = `
      <div class="account-header">
        <div class="account-avatar">${firstLetter}</div>
        <div class="account-username">${username}</div>
      </div>
      <nav class="account-nav">
        <a href="sidebar/settings.html" data-lang-key="settings">${t.settings}</a>
        <a href="sidebar/Help_Desk.html" data-lang-key="support">${t.support}</a>
        <a href="sidebar/review.html" data-lang-key="feedback">${t.feedback}</a>
      </nav>
      ${isMobile 
        ? '<div class="mobile-download-text">Игру можно скачать только на ПК</div>' 
        : '<a href="website/test_version_of_the_game/test_game.html" class="account-download" data-lang-key="downloadGame">' + t.downloadGame + '</a>'}
      <div class="account-divider"></div>
      <div class="account-info" data-lang-key="enjoy">${t.enjoy}</div>
      <div class="account-copyright" data-lang-key="copyright">${t.copyright}</div>
      <button class="logout-btn" onclick="logout()">${t.logout}</button>
    `;
  } else {
    content.innerHTML = `
      <a href="auth/index.html" class="login-register-btn">${t.register}</a>
      <a href="auth/index.html" class="login-register-btn">${t.login}</a>
      <div class="account-divider"></div>
      <nav class="account-nav">
        <a href="sidebar/settings.html" data-lang-key="settings">${t.settings}</a>
        <a href="sidebar/Help_Desk.html" data-lang-key="support">${t.support}</a>
        <a href="sidebar/review.html" data-lang-key="feedback">${t.feedback}</a>
      </nav>
      ${isMobile 
        ? '<div class="mobile-download-text">Игру можно скачать только на ПК</div>' 
        : '<a href="website/test_version_of_the_game/test_game.html" class="account-download" data-lang-key="downloadGame">' + t.downloadGame + '</a>'}
      <div class="account-divider"></div>
      <div class="account-info" data-lang-key="enjoy">${t.enjoy}</div>
      <div class="account-copyright" data-lang-key="copyright">${t.copyright}</div>
    `;
  }
  
  applyTranslations();
}

// Добавляем обработчик изменения размера окна
window.addEventListener('resize', function() {
  const sidebar = document.getElementById('accountSidebar');
  if (sidebar && sidebar.classList.contains('open')) {
    updateAccountContent();
  }
});

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
