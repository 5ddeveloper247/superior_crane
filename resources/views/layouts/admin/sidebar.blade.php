<style>
  .sidebar {
    background: linear-gradient(75deg, rgba(220, 47, 43, 1) 19%, rgba(191, 40, 37, 1) 43%, rgba(161, 29, 29, 1) 61%, rgba(126, 20, 20, 1) 100%);
    height: 100vh;
  }

  #sidebar {
    width: 220px;
    transition: width .6s;
    overflow-y: auto;
    height: calc(100vh - 104px);
  }

  #sidebar.collapsed {
    width: 0;
  }

  .res-btn {
    border: none;
    background-color: transparent;
  }

  .activenav {
    font-weight: 700;
    color: #fff !important;
    background: linear-gradient(10deg, rgba(220, 47, 43, 1) 19%, rgba(191, 40, 37, 1) 43%, rgba(161, 29, 29, 1) 61%, rgba(126, 20, 20, 1) 100%);
    border-radius: 10px;
    transition: all ease-in-out .4s;
    box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;
    scale: 1 !important;
    margin: 0 .3rem;
    /* width: fit-content; */
    padding-top: .6rem;
    padding-bottom: .6rem;
    padding-right: 2rem;
  }

  .nav .nav-item .nav-link {
    scale: .94;
  }

  .nav .nav-item .nav-link:hover {
    scale: 1;
    transition: scale ease-in-out .3s;
  }

  .logo {
    transition: width 0.5s ease-in-out, opacity 0.5s ease-in-out, padding 0.5s ease-in-out;
    opacity: 1;
    width: 140px;
    padding: 1rem 0 0 2rem;
  }

  .logo.hidden {
    opacity: 0;
    width: 0px;
    padding: 0;
  }

  .list-item {
    font-size: 12px !important;
  }
</style>


<div class="sidebar border-end d-none d-lg-block">
  <div class="d-flex justify-content-end">
    <img class="logo" src="{{asset('assets/images/logo.png')}}" alt="">
    <button class="navbar-toggler d-lg-flex justify-content-end w-100 p-4" type="button" data-bs-toggle="collapse"
      data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
      <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 28 24">
        <path fill="white"
          d="M7.184 0H27.65v5.219H7.184zm0 9.39H27.65v5.219H7.184zm0 9.391H27.65V24H7.184zM0 0h5.219v5.219H0zm0 9.39h5.219v5.219H0zm0 9.391h5.219V24H0z" />
      </svg>
    </button>
  </div>
  <div>
    <div id="sidebar" class="collapse show">
      <ul class="nav flex-column">
        <li class="nav-item pt-3 ">
          <a href="{{url('dashboard')}}"
            class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Dashboard' ? 'activenav' : ''}}" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 32 32">
              <path fill="white"
                d="M16.612 2.214a1.01 1.01 0 0 0-1.242 0L1 13.419l1.243 1.572L4 13.621V26a2.004 2.004 0 0 0 2 2h20a2.004 2.004 0 0 0 2-2V13.63L29.757 15L31 13.428ZM18 26h-4v-8h4Zm2 0v-8a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v8H6V12.062l10-7.79l10 7.8V26Z" />
            </svg>
            <span class="sidebar-text">
              Dashboard
            </span>
          </a>
        </li>

        <li class="nav-item pt-2">
          <a class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'All-jobs' ? 'activenav' : ''}}"
            href="{{url('all_jobs')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 1200 1200">
              <path fill="white"
                d="M600 0c-65.168 0-115.356 54.372-115.356 119.385c0 62.619-.439 117.407-.439 117.407h-115.87c-2.181 0-4.291.241-6.372.586h-32.227v112.573h540.527V237.378h-32.227c-2.081-.345-4.191-.586-6.372-.586H715.796s1.318-49.596 1.318-117.041C717.114 57.131 665.168 0 600 0M175.195 114.185V1200h849.609V114.185H755.64v78.662h191.382v928.345h-693.97V192.847H444.36v-78.662zM600 115.649c21.35 0 38.599 17.18 38.599 38.452c0 21.311-17.249 38.525-38.599 38.525s-38.599-17.215-38.599-38.525c0-21.271 17.249-38.452 38.599-38.452M329.736 426.27v38.525h38.599V426.27zm115.869.732v38.525h424.658v-38.525zm-115.869 144.58v38.525h38.599v-38.525zm115.869.732v38.599h424.658v-38.599zM329.736 716.895v38.525h38.599v-38.525zm115.869.805v38.525h424.658V717.7zM329.736 862.28v38.525h38.599V862.28zm115.869.806v38.525h424.658v-38.525zm-115.869 144.507v38.525h38.599v-38.525zm115.869.805v38.525h424.658v-38.525z" />
            </svg>
            <span>Job List</span>
          </a>
        </li>


        <li class="nav-item pt-2">
          <a class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Users' ? 'activenav' : ''}}"
            href="{{url('users')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
              <path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M15.75 6a3.75 3.75 0 1 1-7.5 0a3.75 3.75 0 0 1 7.5 0M4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.9 17.9 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632" />
            </svg>
            <span>Users</span>
          </a>
        </li>


        <li class="nav-item pt-2">
          <a href="{{url('rigger_tickets')}}"
            class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Rigger_tickets' ? 'activenav' : ''}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 56 56">
              <path fill="white" fill-rule="evenodd"
                d="m49.336 12.768l1.152 4.298a3.2 3.2 0 0 1-.967 3.22l-.155.13a5.001 5.001 0 0 0 2.218 8.87l.216.033a3.077 3.077 0 0 1 2.575 2.255l1.173 4.376a4 4 0 0 1-2.828 4.9L12.15 51.72a4 4 0 0 1-4.898-2.829l-1.103-4.117a3.485 3.485 0 0 1 .997-3.459l.163-.14a5.001 5.001 0 0 0-2.37-8.813a3.46 3.46 0 0 1-2.791-2.52L1.04 25.709a4 4 0 0 1 2.83-4.899L44.437 9.94a4 4 0 0 1 4.9 2.828m-4.165.607L4.951 24.152c-.555.149-.885.72-.736 1.275l.791 2.953a9.368 9.368 0 0 1 7.2 6.76a9.368 9.368 0 0 1-2.855 9.455l.791 2.953c.15.555.72.885 1.275.736l40.22-10.777c.555-.149.885-.72.736-1.275l-.79-2.952a9.369 9.369 0 0 1-7.2-6.761a9.368 9.368 0 0 1 2.854-9.455l-.791-2.953a1.041 1.041 0 0 0-1.275-.736m-1.283 21.559a3 3 0 1 1-5.796 1.552a3 3 0 0 1 5.796-1.552m-2.07-7.728a3 3 0 1 1-5.796 1.553a3 3 0 0 1 5.795-1.553m-2.071-7.727a3 3 0 1 1-5.796 1.553a3 3 0 0 1 5.796-1.553M29.383 6.347l2.552 3.644c.037.054.073.109.107.164L7.627 16.697L23.812 5.364a4 4 0 0 1 5.57.983" />
            </svg>
            <span>Rigger Tickets</span>
          </a>
        </li>


        <li class="nav-item pt-2">
          <a href="{{url('transportation')}}"
            class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Transportation' ? 'activenav' : ''}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 48 48">
              <g fill="none">
                <rect width="26" height="38" x="5" y="42" stroke="white" stroke-linejoin="bevel" stroke-width="4" rx="2"
                  transform="rotate(-90 5 42)" />
                <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                  d="M9 16L32 5l5 11" />
                <circle cx="13" cy="23" r="2" fill="white" />
                <circle cx="13" cy="29" r="2" fill="white" />
                <circle cx="13" cy="35" r="2" fill="white" />
                <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                  d="M21 35h4l11-12m-12 6h6" />
              </g>
            </svg>
            <span>Transportation Tickets</span>
          </a>
        </li>


        <li class="nav-item pt-3">
          <a href="{{url('pay_duty')}}"
            class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Pay_duty' ? 'activenav' : ''}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
              <path fill="white"
                d="M11 15h6v2h-6zM9 7H7v2h2zm2 6h6v-2h-6zm0-4h6V7h-6zm-2 2H7v2h2zm12-6v14c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h14c1.1 0 2 .9 2 2m-2 0H5v14h14zM9 15H7v2h2z" />
            </svg>
            <span>Pay Duty Form</span>
          </a>
        </li>


        <li class="nav-item pt-2">
          <a href="{{url('inventory')}}"
            class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Inventory' ? 'activenav' : ''}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
              <path fill="white"
                d="m15.5 17.798l5.335-5.334q.14-.141.344-.15t.363.15t.16.353t-.16.354l-5.477 5.477q-.242.243-.565.243t-.565-.243l-2.639-2.639q-.14-.14-.15-.344t.15-.363t.354-.16t.354.16zM5.616 20q-.667 0-1.141-.475T4 18.386V5.615q0-.666.475-1.14T5.615 4h4.637q.14-.586.623-.985q.483-.4 1.125-.4q.654 0 1.134.4q.48.398.62.985h4.63q.667 0 1.142.475T20 5.615V9.5q0 .213-.144.356t-.357.144t-.356-.144T19 9.5V5.616q0-.231-.192-.424T18.384 5H16v1.423q0 .343-.23.576t-.57.232H8.8q-.34 0-.57-.232T8 6.423V5H5.616q-.231 0-.424.192T5 5.616v12.769q0 .23.192.423t.423.192H10.5q.213 0 .356.144t.144.357t-.144.356T10.5 20zm6.387-14.77q.345 0 .575-.232q.23-.233.23-.578t-.233-.575t-.578-.23t-.575.234t-.23.578t.234.574t.577.23" />
            </svg>
            <span>Inventory</span>
          </a>
        </li>


        <li class="nav-item pt-2">
          <a href="#web_api"  data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseExample"
            class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Web_api' ? 'activenav' : ''}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 512 512">
              <path fill="white"
                d="M421.415 309.528c-7.209 0-14.186.938-20.909 2.54l-.636-1.005l-83.542-131.894c18.528-16.698 30.257-40.888 30.257-67.894c0-50.366-40.556-91.197-90.585-91.197s-90.585 40.83-90.585 91.197c0 27.006 11.728 51.196 30.257 67.894L112.13 311.063l-.636 1.005c-6.723-1.602-13.7-2.54-20.91-2.54C40.557 309.528 0 350.358 0 400.725s40.556 91.197 90.585 91.197s90.584-40.83 90.584-91.197c0-34.507-19.045-64.525-47.122-80.016l81.138-128.098c12.276 6.257 26.114 9.86 40.815 9.86s28.54-3.603 40.816-9.86l81.137 128.098c-28.077 15.49-47.122 45.509-47.122 80.016c0 50.366 40.556 91.197 90.584 91.197S512 451.092 512 400.725s-40.556-91.197-90.585-91.197M90.353 443.791c-23.319 0-42.223-18.903-42.223-42.222s18.904-42.223 42.223-42.223s42.222 18.904 42.222 42.223s-18.903 42.222-42.222 42.222" />
            </svg>
            <span>Web Api's</span>
          </a>
          <div class="collapse sidebar-inner-content" id="web_api">
            <ul class="nav flex-column mx-3">
              <li class="nav-item ps-4 pt-1">
                <a href="{{url('web_api_users')}}" class="list-item"
                  href="#">
                  <span>Users API</span>
                </a>
              </li>
              <li class="nav-item ps-4 pt-1">
                <a href="{{url('web_api_add_job')}}" class="list-item"
                  href="#">
                  <span>Add Job API</span>
                </a>
              </li>
              <li class="nav-item ps-4 pt-1">
                <a href="{{url('')}}" class="list-item"
                  href="#">
                  <span>Transportation Ticket</span>
                </a>
              </li>
              <li class="nav-item ps-4 pt-1">
                <a href="{{url('')}}" class="list-item"
                  href="#">
                  <span>Pay Duty Form</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>


<script>
  document.querySelector('.navbar-toggler').addEventListener('click', function () {
    document.querySelector('#sidebar').classList.toggle('collapsed');
    let logo = document.querySelector('.logo');

    if (logo.classList.contains('hidden')) {
      logo.classList.remove('hidden');
    } else {
      logo.classList.add('hidden');
    }
  });


</script>