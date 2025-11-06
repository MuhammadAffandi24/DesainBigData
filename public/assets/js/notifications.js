document.addEventListener('DOMContentLoaded', function(){
  const badge = document.getElementById('notif-badge');
  const list = document.getElementById('notif-list');
  const toggle = document.getElementById('notif-toggle');
  const dropdown = document.getElementById('notif-dropdown');
  const markAllBtn = document.getElementById('mark-all-read');

  async function fetchNotifications(){
    try {
      const res = await fetch('/api/notifications', {credentials:'same-origin'});
      if(!res.ok) return;
      const data = await res.json();
      // support two shapes: { unread_count, data } or array
      const unreadCount = data.unread_count ?? (Array.isArray(data) ? data.filter(n=>!n.read_at).length : 0);
      if(badge) badge.textContent = unreadCount;

      const items = Array.isArray(data.data) ? data.data : (Array.isArray(data) ? data : []);
      if(list && items.length){
        list.innerHTML = items.map(n => {
          const msg = (n.data && n.data.message) ? n.data.message : (n.type || 'Notifikasi');
          const url = (n.data && n.data.url) ? n.data.url : '#';
          const created = n.created_at || (n.data && n.data.created_at) || '';
          return `<li data-id="${n.id || ''}" class="${n.read_at ? 'read' : 'unread'}">\n            <a href="${url}">\n              <div class="notif-title">${msg}</div>\n              <div class="notif-time">${created}</div>\n            </a>\n          </li>`;
        }).join('');
      }
    } catch(err){ console.error('fetch notifications', err); }
  }

  toggle && toggle.addEventListener('click', function(e){
    e.preventDefault();
    if(!dropdown) return;
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
  });

  markAllBtn && markAllBtn.addEventListener('click', async function(){
    try {
      await fetch('/api/notifications/read-all', {method:'POST', credentials:'same-origin', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')||''}});
      fetchNotifications();
    } catch(err){ console.error(err); }
  });

  // initial fetch and polling
  fetchNotifications();
  setInterval(fetchNotifications, 15000);
});
