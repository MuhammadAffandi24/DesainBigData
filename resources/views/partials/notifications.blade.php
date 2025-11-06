<div id="notif-root" class="notifications">
  <a href="#" id="notif-toggle" class="notif-bell">
    <span class="icon">🔔</span>
    <span id="notif-badge" class="badge">{{ auth()->check() ? auth()->user()->unreadNotifications()->count() : 0 }}</span>
  </a>
  <div id="notif-dropdown" class="notif-dropdown" style="display:none;">
    <ul id="notif-list">
      @if(auth()->check())
         @foreach(auth()->user()->notifications()->orderBy('created_at','desc')->limit(10)->get() as $notification)
           <li data-id="{{ $notification->id }}" class="{{ $notification->read_at ? 'read' : 'unread' }}">
             <a href="{{ $notification->data['url'] ?? '#' }}">
               <div class="notif-title">{{ $notification->data['message'] ?? ($notification->data['type'] ?? 'Notifikasi') }}</div>
               <div class="notif-time">{{ $notification->created_at->diffForHumans() }}</div>
             </a>
           </li>
         @endforeach
      @else
         <li>Silakan login untuk melihat notifikasi</li>
      @endif
    </ul>
    <div class="notif-actions">
      <button id="mark-all-read">Tandai semua dibaca</button>
    </div>
  </div>
</div>
