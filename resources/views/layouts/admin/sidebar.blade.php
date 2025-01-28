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

  .activenav-h {
    font-weight: 700;
    color: #fff !important;
    background: linear-gradient(10deg, rgba(220, 47, 43, 1) 19%, rgba(191, 40, 37, 1) 43%, rgba(161, 29, 29, 1) 61%, rgba(126, 20, 20, 1) 100%);
    border-radius: 7px;
    transition: all ease-in-out .4s;
    box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;
    scale: 1 !important;
    margin: 0 .3rem;
    /* width: fit-content; */
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

  #i-sidebar {
    transition: width 2s ease-in-out, height 0.5s ease-in-out, opacity 0.5s ease-in-out, ;
    opacity: 1;
    width: auto;
    height: calc(100vh - 74.75px);
  }

  #i-sidebar.hidden {
    opacity: 0;
    width: 0;
    padding: 0;
    height: 0;
  }

  .list-item {
    font-size: 12px !important;
  }
</style>


<div class="sidebar border-end d-none d-lg-block">
  <div class="">
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
    <ul id="i-sidebar" class="nav d-flex flex-column hidden">
      <li class="nav-item w-100 text-center d-flex align-items-center justify-content-center ">
        <a href="{{route('dashboard')}}" class="nav-link w-100 {{$pageTitle == 'Dashboard' ? 'activenav-h' : ''}}"
          href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="1.8em" height="1.8em" viewBox="0 0 32 32">
            <path fill="white"
              d="M16.612 2.214a1.01 1.01 0 0 0-1.242 0L1 13.419l1.243 1.572L4 13.621V26a2.004 2.004 0 0 0 2 2h20a2.004 2.004 0 0 0 2-2V13.63L29.757 15L31 13.428ZM18 26h-4v-8h4Zm2 0v-8a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v8H6V12.062l10-7.79l10 7.8V26Z" />
          </svg>
        </a>
      </li>

      <li class="nav-item w-100 pt-3 text-center d-flex align-items-center justify-content-center ">
        <a class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Jobs' ? 'activenav-h' : ''}}"
          href="{{route('jobs')}}">
          <svg xmlns="http://www.w3.org/2000/svg" width="1.8em" height="1.8em" viewBox="0 0 1200 1200">
            <path fill="white"
              d="M600 0c-65.168 0-115.356 54.372-115.356 119.385c0 62.619-.439 117.407-.439 117.407h-115.87c-2.181 0-4.291.241-6.372.586h-32.227v112.573h540.527V237.378h-32.227c-2.081-.345-4.191-.586-6.372-.586H715.796s1.318-49.596 1.318-117.041C717.114 57.131 665.168 0 600 0M175.195 114.185V1200h849.609V114.185H755.64v78.662h191.382v928.345h-693.97V192.847H444.36v-78.662zM600 115.649c21.35 0 38.599 17.18 38.599 38.452c0 21.311-17.249 38.525-38.599 38.525s-38.599-17.215-38.599-38.525c0-21.271 17.249-38.452 38.599-38.452M329.736 426.27v38.525h38.599V426.27zm115.869.732v38.525h424.658v-38.525zm-115.869 144.58v38.525h38.599v-38.525zm115.869.732v38.599h424.658v-38.599zM329.736 716.895v38.525h38.599v-38.525zm115.869.805v38.525h424.658V717.7zM329.736 862.28v38.525h38.599V862.28zm115.869.806v38.525h424.658v-38.525zm-115.869 144.507v38.525h38.599v-38.525zm115.869.805v38.525h424.658v-38.525z" />
          </svg>
        </a>
      </li>

      <li class="nav-item w-100 pt-3 text-center d-flex align-items-center justify-content-center ">
        <a class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Users' ? 'activenav-h' : ''}}"
          href="{{route('users')}}">
          <svg xmlns="http://www.w3.org/2000/svg" width="1.8em" height="1.8em" viewBox="0 0 24 24">
            <path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M15.75 6a3.75 3.75 0 1 1-7.5 0a3.75 3.75 0 0 1 7.5 0M4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.9 17.9 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632" />
          </svg>
        </a>
      </li>

      <li class="nav-item w-100 pt-3 text-center d-flex align-items-center justify-content-center ">
        <a href="{{route('rigger_tickets')}}"
          class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Rigger_tickets' ? 'activenav-h' : ''}}">
          <svg xmlns="http://www.w3.org/2000/svg" width="1.8em" height="1.8em" viewBox="0 0 56 56">
            <path fill="white" fill-rule="evenodd"
              d="m49.336 12.768l1.152 4.298a3.2 3.2 0 0 1-.967 3.22l-.155.13a5.001 5.001 0 0 0 2.218 8.87l.216.033a3.077 3.077 0 0 1 2.575 2.255l1.173 4.376a4 4 0 0 1-2.828 4.9L12.15 51.72a4 4 0 0 1-4.898-2.829l-1.103-4.117a3.485 3.485 0 0 1 .997-3.459l.163-.14a5.001 5.001 0 0 0-2.37-8.813a3.46 3.46 0 0 1-2.791-2.52L1.04 25.709a4 4 0 0 1 2.83-4.899L44.437 9.94a4 4 0 0 1 4.9 2.828m-4.165.607L4.951 24.152c-.555.149-.885.72-.736 1.275l.791 2.953a9.368 9.368 0 0 1 7.2 6.76a9.368 9.368 0 0 1-2.855 9.455l.791 2.953c.15.555.72.885 1.275.736l40.22-10.777c.555-.149.885-.72.736-1.275l-.79-2.952a9.369 9.369 0 0 1-7.2-6.761a9.368 9.368 0 0 1 2.854-9.455l-.791-2.953a1.041 1.041 0 0 0-1.275-.736m-1.283 21.559a3 3 0 1 1-5.796 1.552a3 3 0 0 1 5.796-1.552m-2.07-7.728a3 3 0 1 1-5.796 1.553a3 3 0 0 1 5.795-1.553m-2.071-7.727a3 3 0 1 1-5.796 1.553a3 3 0 0 1 5.796-1.553M29.383 6.347l2.552 3.644c.037.054.073.109.107.164L7.627 16.697L23.812 5.364a4 4 0 0 1 5.57.983" />
          </svg>
        </a>
      </li>

      <li class="nav-item w-100 pt-3 text-center d-flex align-items-center justify-content-center ">
        <a href="{{url('pay_duty')}}"
          class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Pay_duty' ? 'activenav-h' : ''}}">
          <svg xmlns="http://www.w3.org/2000/svg" width="1.8em" height="1.8em" viewBox="0 0 24 24">
            <path fill="white"
              d="M11 15h6v2h-6zM9 7H7v2h2zm2 6h6v-2h-6zm0-4h6V7h-6zm-2 2H7v2h2zm12-6v14c0 1.1-.9 2-2 2H5c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h14c1.1 0 2 .9 2 2m-2 0H5v14h14zM9 15H7v2h2z" />
          </svg>
        </a>
      </li>
      
      <li class="nav-item w-100 pt-3 text-center d-flex align-items-center justify-content-center ">
        <a href="{{url('transportation')}}"
          class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Transportation' ? 'activenav-h' : ''}}">
          <svg xmlns="http://www.w3.org/2000/svg" width="1.8em" height="1.8em" viewBox="0 0 48 48">
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
        </a>
      </li>

      

      <li class="nav-item w-100 pt-3 text-center d-flex align-items-center justify-content-center ">
        <a href="{{url('inventory')}}"
          class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Inventory' ? 'activenav-h' : ''}}">
          <svg xmlns="http://www.w3.org/2000/svg" width="1.8em" height="1.8em" viewBox="0 0 24 24">
            <path fill="white"
              d="m15.5 17.798l5.335-5.334q.14-.141.344-.15t.363.15t.16.353t-.16.354l-5.477 5.477q-.242.243-.565.243t-.565-.243l-2.639-2.639q-.14-.14-.15-.344t.15-.363t.354-.16t.354.16zM5.616 20q-.667 0-1.141-.475T4 18.386V5.615q0-.666.475-1.14T5.615 4h4.637q.14-.586.623-.985q.483-.4 1.125-.4q.654 0 1.134.4q.48.398.62.985h4.63q.667 0 1.142.475T20 5.615V9.5q0 .213-.144.356t-.357.144t-.356-.144T19 9.5V5.616q0-.231-.192-.424T18.384 5H16v1.423q0 .343-.23.576t-.57.232H8.8q-.34 0-.57-.232T8 6.423V5H5.616q-.231 0-.424.192T5 5.616v12.769q0 .23.192.423t.423.192H10.5q.213 0 .356.144t.144.357t-.144.356T10.5 20zm6.387-14.77q.345 0 .575-.232q.23-.233.23-.578t-.233-.575t-.578-.23t-.575.234t-.23.578t.234.574t.577.23" />
          </svg>
        </a>
      </li>

    </ul>
  </div>
  <div>
    <div id="sidebar" class="collapse show">
      <ul class="nav flex-column">
        <li class="nav-item pt-3 ">
          <a href="{{route('dashboard')}}"
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
          <a class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Jobs' ? 'activenav' : ''}}"
            href="{{route('jobs')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 1200 1200">
              <path fill="white"
                d="M600 0c-65.168 0-115.356 54.372-115.356 119.385c0 62.619-.439 117.407-.439 117.407h-115.87c-2.181 0-4.291.241-6.372.586h-32.227v112.573h540.527V237.378h-32.227c-2.081-.345-4.191-.586-6.372-.586H715.796s1.318-49.596 1.318-117.041C717.114 57.131 665.168 0 600 0M175.195 114.185V1200h849.609V114.185H755.64v78.662h191.382v928.345h-693.97V192.847H444.36v-78.662zM600 115.649c21.35 0 38.599 17.18 38.599 38.452c0 21.311-17.249 38.525-38.599 38.525s-38.599-17.215-38.599-38.525c0-21.271 17.249-38.452 38.599-38.452M329.736 426.27v38.525h38.599V426.27zm115.869.732v38.525h424.658v-38.525zm-115.869 144.58v38.525h38.599v-38.525zm115.869.732v38.599h424.658v-38.599zM329.736 716.895v38.525h38.599v-38.525zm115.869.805v38.525h424.658V717.7zM329.736 862.28v38.525h38.599V862.28zm115.869.806v38.525h424.658v-38.525zm-115.869 144.507v38.525h38.599v-38.525zm115.869.805v38.525h424.658v-38.525z" />
            </svg>
            <span>Job List</span>
          </a>
        </li>

        <li class="nav-item pt-2">
          <a class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Users' ? 'activenav' : ''}}"
            href="{{route('users')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
              <path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M15.75 6a3.75 3.75 0 1 1-7.5 0a3.75 3.75 0 0 1 7.5 0M4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.9 17.9 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632" />
            </svg>
            <span>Users</span>
          </a>
        </li>


        <li class="nav-item pt-2">
          <a href="{{route('rigger_tickets')}}"
            class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Rigger_tickets' ? 'activenav' : ''}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 56 56">
              <path fill="white" fill-rule="evenodd"
                d="m49.336 12.768l1.152 4.298a3.2 3.2 0 0 1-.967 3.22l-.155.13a5.001 5.001 0 0 0 2.218 8.87l.216.033a3.077 3.077 0 0 1 2.575 2.255l1.173 4.376a4 4 0 0 1-2.828 4.9L12.15 51.72a4 4 0 0 1-4.898-2.829l-1.103-4.117a3.485 3.485 0 0 1 .997-3.459l.163-.14a5.001 5.001 0 0 0-2.37-8.813a3.46 3.46 0 0 1-2.791-2.52L1.04 25.709a4 4 0 0 1 2.83-4.899L44.437 9.94a4 4 0 0 1 4.9 2.828m-4.165.607L4.951 24.152c-.555.149-.885.72-.736 1.275l.791 2.953a9.368 9.368 0 0 1 7.2 6.76a9.368 9.368 0 0 1-2.855 9.455l.791 2.953c.15.555.72.885 1.275.736l40.22-10.777c.555-.149.885-.72.736-1.275l-.79-2.952a9.369 9.369 0 0 1-7.2-6.761a9.368 9.368 0 0 1 2.854-9.455l-.791-2.953a1.041 1.041 0 0 0-1.275-.736m-1.283 21.559a3 3 0 1 1-5.796 1.552a3 3 0 0 1 5.796-1.552m-2.07-7.728a3 3 0 1 1-5.796 1.553a3 3 0 0 1 5.795-1.553m-2.071-7.727a3 3 0 1 1-5.796 1.553a3 3 0 0 1 5.796-1.553M29.383 6.347l2.552 3.644c.037.054.073.109.107.164L7.627 16.697L23.812 5.364a4 4 0 0 1 5.57.983" />
            </svg>
            <span>Rigger Tickets</span>
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
          <a href="{{url('email_settings')}}"
            class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Email Settings' ? 'activenav' : ''}}">
            <svg fill="#ffffff" width="1.5em" height="1.5em" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 493.419 493.419" xml:space="preserve" stroke="#ffffff">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier"> 
                <g><path d="M162.988,288.902c3.088-0.828,6.277-1.25,9.479-1.25c2.525,0,5.032,0.26,7.485,0.779 c4.791-14.577,18.526-25.135,34.686-25.135h28.057c7.455,0,14.342,2.323,20.123,6.173c0.725-4.849,2.308-9.575,4.835-13.952 l17.671-30.616c1.566-2.705,3.491-5.1,5.578-7.317l-30.452-25.021l12.628-11.143l32.328,26.549 c1.291-0.496,2.544-1.096,3.899-1.462c3.329-0.894,6.771-1.349,10.226-1.349c4.846,0,9.647,0.893,14.145,2.624 c2.98-18.857,19.336-33.313,39.012-33.313h18.16V65.835c0-16.453-13.344-29.796-29.805-29.796H29.804 C13.343,36.039,0,49.381,0,65.835v200.703c0,16.461,13.343,29.804,29.804,29.804H148.98 C153.031,292.914,157.734,290.299,162.988,288.902z M44.527,72.413c4.563-5.173,12.436-5.651,17.608-1.104l121.828,107.514 c6.547,5.768,16.39,5.768,22.935,0L328.723,71.308c5.164-4.539,13.041-4.061,17.605,1.104c4.558,5.166,4.061,13.042-1.103,17.607 L223.402,197.532c-7.969,7.034-17.973,10.55-27.971,10.55c-9.998,0-20.002-3.516-27.969-10.55L45.635,90.02 C40.467,85.455,39.973,77.579,44.527,72.413z M43.998,263.525c-1.547,1.274-3.416,1.892-5.269,1.892 c-2.403,0-4.792-1.04-6.433-3.037c-2.916-3.549-2.403-8.787,1.146-11.703l84.342-69.256l12.629,11.143L43.998,263.525z"></path> <path d="M390.361,268.918c-20.424,0-37.047,16.623-37.047,37.047s16.623,37.049,37.047,37.049 c20.423,0,37.049-16.625,37.049-37.049S410.784,268.918,390.361,268.918z"></path> <path d="M486.139,324.05l-13.35-7.707c0.429-3.444,1.048-6.822,1.048-10.379c0-3.558-0.619-6.943-1.048-10.387l13.35-7.706 c3.348-1.935,5.782-5.11,6.783-8.837c0.998-3.729,0.478-7.697-1.455-11.044l-17.67-30.601c-2.695-4.669-7.596-7.275-12.623-7.275 c-2.468,0-4.967,0.624-7.258,1.948l-13.269,7.659c-5.58-4.24-11.518-8.017-18.063-10.762v-14.99 c0-8.039-6.512-14.552-14.553-14.552h-35.344c-8.039,0-14.553,6.513-14.553,14.552v14.99c-6.543,2.745-12.48,6.521-18.052,10.762 l-13.278-7.667c-2.232-1.291-4.74-1.948-7.273-1.948c-1.26,0-2.529,0.161-3.77,0.496c-3.727,0.998-6.904,3.435-8.838,6.78 l-17.67,30.607c-4.02,6.959-1.633,15.86,5.328,19.881l7.008,4.042c0.982,0.514,1.918,1.049,2.85,1.65l3.492,2.014 c-0.022,0.202-0.031,0.406-0.065,0.607c3.354,2.746,6.411,5.865,8.633,9.723l14.067,24.347c4.822,8.421,6.115,18.216,3.605,27.653 c-1.51,5.626-4.279,10.693-8.064,14.91c1.452,1.631,2.702,3.401,3.833,5.237l10.135-5.856c5.578,4.247,11.506,8.023,18.059,10.767 v14.993c0,8.039,6.514,14.552,14.553,14.552h35.344c8.041,0,14.553-6.513,14.553-14.552v-14.993 c6.555-2.744,12.482-6.52,18.063-10.767l13.269,7.668c2.231,1.289,4.744,1.947,7.277,1.947c1.256,0,2.523-0.162,3.768-0.494 c3.728-1,6.902-3.436,8.836-6.782l17.67-30.608C495.486,336.97,493.1,328.07,486.139,324.05z M390.361,359.646 c-29.602,0-53.68-24.08-53.68-53.682c0-29.6,24.078-53.68,53.68-53.68c29.6,0,53.682,24.08,53.682,53.68 C444.043,335.566,419.961,359.646,390.361,359.646z"></path> <path d="M304.691,387.166l-10.598-6.115c0.342-2.736,0.83-5.415,0.83-8.241c0-2.817-0.488-5.507-0.83-8.243l10.598-6.115 c2.655-1.535,4.589-4.053,5.385-7.017c0.787-2.964,0.373-6.107-1.154-8.771l-14.023-24.28c-2.145-3.713-6.033-5.783-10.022-5.783 c-1.955,0-3.939,0.504-5.757,1.551l-10.533,6.083c-4.434-3.37-9.152-6.367-14.341-8.543v-11.898c0-6.383-5.173-11.548-11.55-11.548 h-28.057c-6.377,0-11.549,5.165-11.549,11.548v11.898c-5.199,2.176-9.908,5.173-14.332,8.543l-10.543-6.09 c-1.762-1.023-3.742-1.544-5.747-1.544c-1.007,0-2.024,0.13-3.017,0.397c-2.952,0.788-5.471,2.721-7.016,5.378l-14.024,24.288 c-3.183,5.53-1.29,12.596,4.231,15.788l10.598,6.115c-0.342,2.736-0.826,5.426-0.826,8.243c0,2.826,0.484,5.505,0.826,8.233 l-10.598,6.115c-5.521,3.191-7.414,10.258-4.231,15.779l14.024,24.305c1.545,2.648,4.063,4.582,7.016,5.378 c0.992,0.267,2,0.397,2.998,0.397c2.008,0,4.004-0.528,5.766-1.551l10.533-6.082c4.434,3.369,9.143,6.366,14.342,8.543v11.904 c0,6.375,5.172,11.549,11.549,11.549h28.057c6.377,0,11.55-5.174,11.55-11.549v-11.904c5.198-2.177,9.907-5.174,14.341-8.543 l10.533,6.082c1.762,1.023,3.762,1.551,5.767,1.551c0.997,0,2.005-0.13,2.997-0.397c2.957-0.796,5.471-2.729,7.016-5.378 l14.023-24.296C312.105,397.423,310.213,390.358,304.691,387.166z M228.662,404.66c-17.58,0-31.84-14.26-31.84-31.851 c0-17.591,14.26-31.852,31.84-31.852c17.59,0,31.851,14.262,31.851,31.852C260.513,390.4,246.252,404.66,228.662,404.66z"></path> </g></g>
              </svg>
            <span>Email Settings</span>
          </a>
        </li>

        <li class="nav-item pt-2">
          <a href="#web_api" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseExample"
            class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Web_api' ? 'activenav' : ''}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 512 512">
              <path fill="white"
                d="M421.415 309.528c-7.209 0-14.186.938-20.909 2.54l-.636-1.005l-83.542-131.894c18.528-16.698 30.257-40.888 30.257-67.894c0-50.366-40.556-91.197-90.585-91.197s-90.585 40.83-90.585 91.197c0 27.006 11.728 51.196 30.257 67.894L112.13 311.063l-.636 1.005c-6.723-1.602-13.7-2.54-20.91-2.54C40.557 309.528 0 350.358 0 400.725s40.556 91.197 90.585 91.197s90.584-40.83 90.584-91.197c0-34.507-19.045-64.525-47.122-80.016l81.138-128.098c12.276 6.257 26.114 9.86 40.815 9.86s28.54-3.603 40.816-9.86l81.137 128.098c-28.077 15.49-47.122 45.509-47.122 80.016c0 50.366 40.556 91.197 90.584 91.197S512 451.092 512 400.725s-40.556-91.197-90.585-91.197M90.353 443.791c-23.319 0-42.223-18.903-42.223-42.222s18.904-42.223 42.223-42.223s42.222 18.904 42.222 42.223s-18.903 42.222-42.222 42.222" />
            </svg>
            <span class="d-flex align-items-center justify-content-between w-100">Web Api's
              <i class="fa-solid fa-chevron-down"></i>
            </span>
          </a>
          <div class="collapse sidebar-inner-content" id="web_api">
            <ul class="nav flex-column">
              <li class="nav-item ps-5 pt-1">
                <a href="{{url('web_api_users')}}" class="list-item" href="#">
                  <span>Users API</span>
                </a>
              </li>
              <li class="nav-item ps-5 pt-1">
                <a href="{{url('web_api_add_job')}}" class="list-item" href="#">
                  <span>Add Job API</span>
                </a>
              </li>
              <li class="nav-item ps-5 pt-1">
                <a href="{{url('web_api_rigger')}}" class="list-item" href="#">
                  <span>Rigger Ticket API</span>
                </a>
              </li>
              <li class="nav-item ps-5 pt-1">
                <a href="{{url('web_api_payduty')}}" class="list-item" href="#">
                  <span>Pay Duty Formn API</span>
                </a>
              </li>
              <li class="nav-item ps-5 pt-1">
                <a href="{{url('web_api_transportation')}}" class="list-item" href="#">
                  <span>Transportaion API</span>
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
    let sideBar = document.querySelector('#i-sidebar')

    if (logo.classList.contains('hidden')) {
      logo.classList.remove('hidden');
      sideBar.classList.add('hidden');
    } else {
      logo.classList.add('hidden');
      sideBar.classList.remove('hidden');
    }
  });


</script>