<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<header class="qf-header">
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid px-4">
      <a class="navbar-brand qf-brand d-flex align-items-center gap-2" href="#">
        <span class="qf-brand-icon"><i class="bx bxs-wrench"></i></span>
        <span class="qf-brand-text">Admin <span class="qf-brand-accent">Panel</span></span>
      </a>

      <div class="d-flex align-items-center gap-1">

        {{-- Messages --}}
        @php
          $mess = $messages->where('receiver_id', 1)->where('is_read', 0)->count();
        @endphp
        <div class="qf-icon-btn" data-bs-toggle="modal" data-bs-target="#messageModal" role="button" title="Messages">
          <i class="bx bx-envelope"></i>
          @if ($mess != 0)
            <span class="qf-badge qf-badge-warning">{{ $mess }}</span>
          @endif
        </div>

        {{-- Notifications --}}
        <div class="dropdown">
          <div class="qf-icon-btn" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
            <i class="bx bx-bell"></i>
            @if (count($feedbacks) != 0)
              <span class="qf-badge qf-badge-danger">{{ count($feedbacks) }}</span>
            @endif
          </div>
          <ul class="dropdown-menu dropdown-menu-end qf-dropdown qf-dropdown-notif" aria-labelledby="notificationsDropdown">
            <li class="qf-dropdown-header d-flex justify-content-between align-items-center">
              <span>Notifications</span>
              <span class="qf-pill">{{ count($feedbacks) }} new</span>
            </li>
            <div class="qf-notif-list">
              @if (count($feedbacks) != 0)
                @foreach ($feedbacks as $feedback)
                  @php
                    $user = $users->where('id', $feedback->user_id)->first();
                  @endphp
                  <a href="#" class="qf-notif-item">
                    <span class="qf-notif-avatar"><i class="bx bx-message-rounded-dots"></i></span>
                    <span class="qf-notif-body">
                      <span class="d-flex justify-content-between align-items-center">
                        <span class="qf-notif-name">{{ $user->name }}</span>
                        <span class="qf-notif-date">{{ $feedback->created_at->format('Y-m-d') }}</span>
                      </span>
                      <span class="qf-notif-text">{{ $feedback->content }}</span>
                    </span>
                  </a>
                @endforeach
              @else
                <div class="qf-notif-empty">
                  <i class="bx bx-bell-off"></i>
                  <span>You're all caught up</span>
                </div>
              @endif
            </div>
          </ul>
        </div>

        {{-- Profile --}}
        <div class="dropdown ms-2">
          <div class="qf-profile d-flex align-items-center" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ auth()->user()->profile }}" class="qf-avatar" alt="Profile">
            <span class="qf-profile-meta d-none d-md-flex flex-column">
              <span class="qf-profile-name">{{ auth()->user()->name }}</span>
              <span class="qf-profile-role">Administrator</span>
            </span>
            <i class="bx bx-chevron-down qf-profile-caret d-none d-md-inline"></i>
          </div>
          <ul class="dropdown-menu dropdown-menu-end qf-dropdown" aria-labelledby="profileDropdown">
            <li class="qf-profile-card">
              <img src="{{ auth()->user()->profile }}" class="qf-avatar" alt="Profile">
              <span>
                <span class="qf-profile-name d-block">{{ auth()->user()->name }}</span>
                <span class="qf-profile-email">{{ auth()->user()->email }}</span>
              </span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a href="{{ route('admin.profile') }}" class="dropdown-item qf-menu-item">
                <i class="bx bx-user"></i><span>Profile</span>
              </a>
            </li>
            <li>
              <a href="#" class="dropdown-item qf-menu-item">
                <i class="bx bx-cog"></i><span>Settings</span>
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <a href="{{ route('admin.logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="dropdown-item qf-menu-item qf-menu-item-danger">
                  <i class="bx bx-log-out"></i><span>Logout</span>
                </a>
              </form>
            </li>
          </ul>
        </div>

        <i class='bx bx-menu qf-mobile-toggle'></i>
      </div>
    </div>
  </nav>
</header>

<style>
  :root {
    --qf-accent: #f59e0b;
    --qf-accent-light: #fbbf24;
    --qf-dark: #1b1f24;
    --qf-dark-2: #23272e;
  }
  .qf-header {
    position: sticky;
    top: 0;
    z-index: 1030;
  }
  .qf-header .navbar {
    background: linear-gradient(90deg, var(--qf-dark) 0%, var(--qf-dark-2) 100%);
    border-bottom: 1px solid rgba(245, 158, 11, .25);
    box-shadow: 0 2px 14px rgba(0, 0, 0, .18);
    padding: .55rem 0;
  }
  /* Brand */
  .qf-brand { text-decoration: none; }
  .qf-brand-icon {
    display: grid; place-items: center;
    width: 38px; height: 38px; border-radius: 10px;
    background: linear-gradient(135deg, var(--qf-accent), var(--qf-accent-light));
    color: var(--qf-dark); font-size: 1.25rem;
    box-shadow: 0 4px 10px rgba(245, 158, 11, .35);
  }
  .qf-brand-text { color: #f8f9fa; font-weight: 700; font-size: 1.05rem; letter-spacing: .3px; }
  .qf-brand-accent { color: var(--qf-accent-light); }
  /* Icon buttons */
  .qf-icon-btn {
    position: relative;
    display: grid; place-items: center;
    width: 42px; height: 42px; border-radius: 50%;
    color: #cdd2da; font-size: 1.35rem; cursor: pointer;
    transition: background .2s ease, color .2s ease;
  }
  .qf-icon-btn:hover { background: rgba(255, 255, 255, .08); color: var(--qf-accent-light); }
  .qf-badge {
    position: absolute; top: 4px; right: 4px;
    min-width: 18px; height: 18px; padding: 0 5px;
    font-size: .65rem; font-weight: 700; line-height: 18px; text-align: center;
    border-radius: 999px; color: var(--qf-dark);
    border: 2px solid var(--qf-dark-2);
  }
  .qf-badge-warning { background: var(--qf-accent-light); }
  .qf-badge-danger { background: #ef4444; color: #fff; }
  /* Profile trigger */
  .qf-profile {
    gap: .6rem; padding: .25rem .55rem .25rem .3rem; border-radius: 999px; cursor: pointer;
    transition: background .2s ease;
  }
  .qf-profile:hover { background: rgba(255, 255, 255, .08); }
  .qf-avatar {
    width: 38px; height: 38px; border-radius: 50%; object-fit: cover;
    border: 2px solid var(--qf-accent);
  }
  .qf-profile-meta { line-height: 1.15; }
  .qf-profile-name { color: #f8f9fa; font-weight: 600; font-size: .85rem; }
  .qf-profile-role { color: #9aa1ab; font-size: .7rem; }
  .qf-profile-caret { color: #9aa1ab; font-size: 1.1rem; }
  /* Dropdowns */
  .qf-dropdown {
    border: none; border-radius: 14px; padding: .5rem; margin-top: .6rem;
    min-width: 240px; box-shadow: 0 12px 32px rgba(0, 0, 0, .18) !important;
  }
  .qf-dropdown-notif { min-width: 340px; }
  .qf-dropdown-header {
    font-weight: 700; font-size: .8rem; color: var(--qf-dark);
    padding: .4rem .6rem .6rem; text-transform: uppercase; letter-spacing: .5px;
  }
  .qf-pill {
    background: rgba(245, 158, 11, .15); color: #b45309; font-size: .65rem; font-weight: 700;
    padding: .15rem .5rem; border-radius: 999px; text-transform: none; letter-spacing: 0;
  }
  .qf-notif-list { max-height: 320px; overflow-y: auto; }
  .qf-notif-item {
    display: flex; gap: .7rem; align-items: flex-start;
    padding: .6rem; border-radius: 10px; text-decoration: none; color: inherit;
    transition: background .15s ease;
  }
  .qf-notif-item:hover { background: #f6f7f9; }
  .qf-notif-avatar {
    flex: 0 0 auto; width: 38px; height: 38px; border-radius: 50%;
    display: grid; place-items: center;
    background: rgba(245, 158, 11, .15); color: var(--qf-accent); font-size: 1.2rem;
  }
  .qf-notif-body { flex: 1; min-width: 0; display: flex; flex-direction: column; }
  .qf-notif-name { font-weight: 600; font-size: .8rem; color: #1f2937; }
  .qf-notif-date { font-size: .68rem; color: #9aa1ab; white-space: nowrap; }
  .qf-notif-text {
    margin-top: .1rem; font-size: .78rem; color: #6b7280;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
  }
  .qf-notif-empty {
    display: flex; flex-direction: column; align-items: center; gap: .4rem;
    padding: 2rem 1rem; color: #9aa1ab; font-size: .85rem;
  }
  .qf-notif-empty i { font-size: 2rem; }
  .qf-profile-card { display: flex; gap: .7rem; align-items: center; padding: .4rem .6rem .6rem; }
  .qf-profile-card .qf-profile-name { color: #1f2937; }
  .qf-profile-email { font-size: .72rem; color: #9aa1ab; }
  .qf-menu-item {
    display: flex; align-items: center; gap: .7rem;
    padding: .55rem .6rem; border-radius: 10px; font-size: .85rem; color: #374151;
  }
  .qf-menu-item i { font-size: 1.15rem; color: #6b7280; }
  .qf-menu-item:hover { background: #f6f7f9; }
  .qf-menu-item-danger, .qf-menu-item-danger i { color: #dc2626; }
  .qf-menu-item-danger:hover { background: #fef2f2; }
  /* Mobile */
  .qf-mobile-toggle { display: none; color: #f7f7f7; font-size: 1.7rem; cursor: pointer; margin-left: .4rem; }
  @media (max-width: 991px) { .qf-mobile-toggle { display: inline; } }
  @media (max-width: 767px) { .qf-brand-text { display: none; } }
</style>
<!-- ---------------------top service detail------------------ -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->

<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white h-3">
        <h5 class="modal-title" id="messageModalLabel">Messaging</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- User List -->
          <div class="col-md-4 border-end ">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="button-addon2">
              <button class="btn btn-warning" type="button" id="button-addon2"><i class="bx bx-search"></i></button>
            </div>
            <div class="d-flex justify-content-around mb-2">
              <a href="#" id='showall' class="btn-hover-border-bottom">Show All</a>
              <a href="#" id='fixers' class="btn-hover-border-bottom">Fixer</a>
              <a href="#" id='customers' class="btn-hover-border-bottom">Customer</a>
            </div>
            <div class="list-group d-flex gap-3" id="userList" style="height: 430px; overflow-y: auto;">
              <!-- Example User List Item -->
              @php 
                $sender = [];
              @endphp
              @foreach ($messages as $message)
                @if ($message->receiver_id == 1 && !in_array($message->sender_id, $sender))
                    @php 
                      foreach ($messages as $messag){
                        if(($messag->receiver_id == 1 && $messag->sender_id == $message->sender_id)){
                          $mess= $messag->message;
                          $date=$messag->created_at;
                          $is_read = $messag->is_read;
                        }elseif(($messag->receiver_id == $message->sender_id  && $messag->sender_id ==1 )){
                          $mess= $messag->message;
                          $date=$messag->created_at;
                          $is_read = 1;
                        }
                      } 
                        $sender[] = $message->sender_id;
                        $user = $users->where('id', $message->sender_id)->first();
                      @endphp
                 <!-- --------------------------------- -->
                 <div id="{{ $user->role == 'fixer' ? 'fixer' : 'customer' }}" class="btn message-card rounded-lg p-3 shadow-md hover:scale-105 transition-all">
                    <div id='{{$user->id}}' class="sen d-flex items-center">
                      <div class="position-relative">
                        <img src="{{$user->profile}}" class="rounded-circle" alt="Profile Image" style="height: 3rem; width: 3rem; object-fit: cover;">
                        <span class="position-absolute bottom-0 end-0 translate-middle p-1 bg-success border border-light rounded-circle">
                          <span class="visually-hidden">Online</span>
                        </span>
                      </div>
                      <div class="flex-grow-1 text-start ms-3">
                        <h5 class="card-title font-bold mb-1" style="font-size:0.875rem;">{{$user->name}}</h5>
                        @if ($is_read==0 && $user->role!="admin")
                        <p class=" mb-0 truncate" style="font-size:0.75rem;"><strong>{{$mess}}</strong></p>
                        @elseif($is_read==1 && $user->role!="admin")
                        <p class="text-gray-600 mb-0 truncate" style="font-size:0.75rem;">{{$mess}}</p>
                        @else
                        <p class="text-gray-600 mb-0 truncate" style="font-size:0.75rem;">You: {{$mess}}</p>
                        @endif
                      </div>
                      @if ($user->role=='fixer')
                        <span class="text-white rounded px-2 py-1 ms-3 mr-6" style="font-size:2em;">👷‍♂️</span>
                      @else
                      <span class="bg-warning text-white rounded px-2 py-1 ms-3 mr-6" style="font-size:0.50rem;">Customer</span>
                      @endif
                      <p class="text-gray-600 mb-0 truncate" style="font-size:0.70rem;">{{$date->format('Y-m-d')}}</p>
                    </div>
                  </div>
                <!-- -------------------------------- -->
                 @endif
                @endforeach
                  <!-- Add more user items here -->
            </div>
          </div>
          @php
$sent = [];
@endphp
@foreach ($messages as $message)
    @if ($message->receiver_id == 1 && !in_array($message->sender_id, $sent))
        @php
            $sent[] = $message->sender_id;
            $account = $users->where('id', $message->sender_id)->first();
        @endphp
        <div id='sender{{ $account->id }}' class="discussion col-md-8" style='display:none'>
            <div class="d-flex align-items-center gap-3 p-2">
                <img src="{{ $account->profile }}" class="rounded-circle" alt="Profile Image" style="height: 3rem; width: 3rem; object-fit: cover;">
                <h5 class="card-title fw-bold mb-0 truncate" style="font-size:20px;">{{ $account->name }}</h5>
                <p class="bg-warning text-white text-sm truncate rounded -ml-2" style="font-size:11px;">{{ $account->role }}</p>
            </div>
            <span class='text-info -mr-9'>Online</span>
            <div class='bg-light mb-3 p-3 d-flex' style="height: 370px; border: 1px solid #ddd;">
                <div id="chatBox" class="d-flex flex-column justify-content-end" style='width:100%;overflow-y: auto;'>
                    @foreach ($messages as $message)
                        @if ($message->receiver_id == 1 && $message->sender_id == $account->id)
                            <div class="d-flex align-items-center gap-2 mt-2">
                                <img src="{{ $account->profile }}" class="rounded-circle" alt="Profile Image" style="height: 2rem; width: 2rem; object-fit: cover;">
                                <span class='bg-white p-2 rounded-lg'>{{ $message->message }}</span>
                            </div>
                            @php 
                              $re = $message->sender_id;
                            @endphp
                        @elseif ($message->receiver_id == $account->id && $message->sender_id == 1)
                            <div class="text-end mt-4">
                            <span class='bg-info p-2 rounded-lg'>{{ $message->message }}</span>
                          </div>
                          @php 
                              $re = $message->receiver_id;
                            @endphp
                        @endif
                    @endforeach
                </div>
            </div>
            <form method="POST" action="{{ route('admin.chats.store') }}" enctype="multipart/form-data">
    @csrf
            <div class="input-group">
                <input type="text" value='{{ $account->id }}' name='card' hidden>
                <input type="text" value='{{ $re}}' name='receiver_id' hidden>
                <input type="text" id="messageInput" name='message' class="form-control" placeholder="Type a message" aria-label="Message" require>
                <div class="input-group-append">
                    <button class="btn btn-warning" id="sendMessageButton" type="submit" aria-label="Send message">Send</button>
                </div>
            </div>
        </form>

        </div>
    @endif
@endforeach
          <div  class="discussion col-md-8 d-flex justify-content-center align-items-center" style='display:none'>
            <span id='message_toselect'>
              Selecte a chart to start messaging <i class='bx bxs-message-rounded-dots bx-tada text-yellow-300 text-3xl -ml-3' ></i>  
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




<style>
/* ............. */
.btn-hover-border-bottom {
  position: relative;
  padding-bottom: 2px; /* Add some padding to avoid overlap */
  font-size: 0.875rem; /* Adjust font size for smaller text */
  color: inherit;
  text-decoration: none;
}

.btn-hover-border-bottom::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  width: 100%;
  height: 2px;
  background-color: currentColor;
  transform: scaleX(0);
  transform-origin: bottom right;
  transition: transform 0.2s ease-in-out;
}

.btn-hover-border-bottom:hover::after,
.btn-hover-border-bottom:focus::after {
  transform: scaleX(1);
  transform-origin: bottom left;
}

.message-card:focus, .message-card:active {
    background-color: #f0f0f0; /* Background color when card is focused or active */
    color: #333; /* Text color when card is focused or active */
  }
</style>

@if (session('messaged'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
            var cardId = "{{ session('card') }}"; // Retrieve the card ID from session
            var cardElement = document.getElementById(cardId);
            if (cardElement) {
                requestAnimationFrame(function() {
                    cardElement.click();
                    messageModal.show(); // Show the message modal immediately
                });
            } else {
                console.warn("Card element not found:", cardId);
            }
        });
    </script>
@endif


<script>
  // -------------spacific------------
  let showall = document.querySelector('#showall');
  let fixers = document.querySelector('#fixers');
  let customers = document.querySelector('#customers');
  let fixer = document.querySelector('#fixer');
  let customer = document.querySelector('#customer');

  showall.addEventListener('click', function () {
    customer.style.display='block';
    fixer.style.display = 'block';
    fixer.style.animation = 'fadeIn 0.5s ease';
    customer.style.animation = 'fadeIn 0.5s ease';
  });

  fixers.addEventListener('click', function () {
    customer.style.display='none';
    fixer.style.display = 'block';
    fixer.style.animation = 'fadeIn 0.5s ease';
  });

  customers.addEventListener('click', function () {
    fixer.style.display='none';
    customer.style.display = 'block';
    customer.style.animation = 'fadeIn 0.5s ease';
  });

  // -----------end spacific-----------------------
  let message_card  = document.querySelectorAll('.sen');
  let message_toselect  = document.querySelector('#message_toselect');

  for(let sender of message_card) {
    sender.addEventListener('click', function () {
      let discuss = '#sender'+ sender.id;
      message_toselect.style.display="none";
      document.querySelector(discuss).style.display="block";
      message_toselect= document.querySelector(discuss);
      let send = document.querySelector(discuss).children[3].children[1].children[0];
      send.addEventListener('click', function () {
        let messages = document.querySelector(discuss).children[3].children[0];
        if(messages.value!='') {
          let main = document.querySelector(discuss).children[2].children[0];
          let d = document.createElement('div');
          d.classList.add('text-end','mt-4');
          let newMessage = document.createElement('span');
          newMessage.classList.add('bg-info', 'p-2', 'rounded-lg');
          newMessage.style.display = 'inline-block';
          newMessage.style.whiteSpace = 'normal';
          newMessage.textContent = messages.value;
          d.appendChild(newMessage);
          main.appendChild(d);
          messages.value='';
        }
      });
    });
  }
</script>