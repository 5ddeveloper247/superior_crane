<style>
  nav {
    background-color: #fff;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
  }

  .dropdown button {
    background-color: transparent;
    border: none;
  }

  .dropdown-item {
    color: #000 !important;
  }

  .offcanvas {
    background-color: #DC2F2B;
    width: 250px !important;
  }

  .close {
    background-color: transparent;
    border: none;
  }

  .breadcrumb small {
    font-size: 12px;
    color: #000;
  }
</style>


<nav class="w-100">
  <div class="p-2">
    <div class="d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-1">
        <button class="d-block d-lg-none res-btn" type="button" data-bs-toggle="offcanvas"
          data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
          <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 28 24">
            <path fill="black"
              d="M7.184 0H27.65v5.219H7.184zm0 9.39H27.65v5.219H7.184zm0 9.391H27.65V24H7.184zM0 0h5.219v5.219H0zm0 9.39h5.219v5.219H0zm0 9.391h5.219V24H0z" />
          </svg>
        </button>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
          aria-labelledby="offcanvasExampleLabel">
          <div class="offcanvas-header d-flex align-items-center justify-content-between">
            <button class="close" data-bs-dismiss="offcanvas" aria-label="Close">
              <svg xmlns="http://www.w3.org/2000/svg" width="1.7em" height="1.7em" viewBox="0 0 24 24">
                <path fill="white"
                  d="M3 16.74L7.76 12L3 7.26L7.26 3L12 7.76L16.74 3L21 7.26L16.24 12L21 16.74L16.74 21L12 16.24L7.26 21zm9-3.33l4.74 4.75l1.42-1.42L13.41 12l4.75-4.74l-1.42-1.42L12 10.59L7.26 5.84L5.84 7.26L10.59 12l-4.75 4.74l1.42 1.42z" />
              </svg>
            </button>
          </div>
          <div class="offcanvas-body">
            <div>
              <div id="sidebar" class="collapse show">
                <ul class="nav flex-column">
                  <li class="nav-item pt-3 ">
                    <a href="{{url('dashboard')}}"
                      class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Dashboard' ? 'activenav' : ''}}"
                      href="#">
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
                    <a class="nav-link d-flex align-items-center gap-2 {{$pageTitle == 'Add-users' ? 'activenav' : ''}}"
                      href="{{url('add_user')}}">
                      <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                        <path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="1.5"
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
                          <rect width="26" height="38" x="5" y="42" stroke="white" stroke-linejoin="bevel"
                            stroke-width="4" rx="2" transform="rotate(-90 5 42)" />
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
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- <h6  class="mb-0 fw-bold d-flex align-items-center gap-1">
          <img src="{{asset('assets/images/image-removebg-preview.png')}}" width="70" alt="">
          SUPERIOR CRANE CANADA INC
        </h6> -->
      </div>

      <div class="d-flex align-items-center">
        <div class="dropdown">
          <button class="py-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="1.7em" height="1.7em" viewBox="0 0 24 24">
                <g fill="none">
                  <path
                    d="M24 0v24H0V0zM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z" />
                  <path fill="black"
                    d="M12 2a7 7 0 0 1 2.263.374a4.5 4.5 0 0 0 4.5 7.447L19 9.743v2.784a1 1 0 0 0 .06.34l.046.107l1.716 3.433a1.1 1.1 0 0 1-.869 1.586l-.115.006H4.162a1.1 1.1 0 0 1-1.03-1.487l.046-.105l1.717-3.433a1 1 0 0 0 .098-.331L5 12.528V9a7 7 0 0 1 7-7m5.5 1a2.5 2.5 0 1 1 0 5a2.5 2.5 0 0 1 0-5M12 21a3 3 0 0 1-2.83-2h5.66A3 3 0 0 1 12 21" />
                </g>
              </svg>
            </span>
          </button>
          <ul class="dropdown-menu text-center">
            <li>
              <a class="dropdown-item d-flex gap-2" href="{{url('notification')}}">
                <img class="rounded-5"
                  src="https://img.freepik.com/free-vector/people-white_24877-49457.jpg?size=626&ext=jpg" width="40"
                  height="40" alt="img">
                <div class="text-start">
                  <span class="fw-bold">John Doe</span>
                  <br>
                  <small>Mentioned you in a comment</small>
                  <br>
                  <div class="d-flex align-items-center gap-3">
                    <small>01, August, 2024</small>
                    <small>11:00 am</small>
                  </div>
                </div>
              </a>
            </li>
            <hr class="my-1 mx-4" style="border: 1px solid red">
            <li>
              <a class="dropdown-item d-flex gap-2" href="{{url('notification')}}">
                <img class="rounded-5"
                  src="https://img.freepik.com/free-vector/people-white_24877-49457.jpg?size=626&ext=jpg" width="40"
                  height="40" alt="img">
                <div class="text-start">
                  <span class="fw-bold">John Doe</span>
                  <br>
                  <small>Mentioned you in a comment</small>
                  <br>
                  <div class="d-flex align-items-center gap-3">
                    <small>01, August, 2024</small>
                    <small>11:00 am</small>
                  </div>
                </div>
              </a>
            </li>
            <hr class="my-1 mx-4" style="border: 1px solid red">
            <li>
              <a class="dropdown-item d-flex gap-2" href="{{url('notification')}}">
                <img class="rounded-5"
                  src="https://img.freepik.com/free-vector/people-white_24877-49457.jpg?size=626&ext=jpg" width="40"
                  height="40" alt="img">
                <div class="text-start">
                  <span class="fw-bold">John Doe</span>
                  <br>
                  <small>Mentioned you in a comment</small>
                  <br>
                  <div class="d-flex align-items-center gap-3">
                    <small>01, August, 2024</small>
                    <small>11:00 am</small>
                  </div>
                </div>
              </a>
            </li>
            <a class="text-dark d-flex justify-content-end px-3 py-2" href="{{url('notification')}}">View All</a>
          </ul>
        </div>

        <div class="dropdown">
          <button class="dropdown-toggle py-3 px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span>
              <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M13.5136 25.9956C13.0155 25.9956 12.5174 25.9956 12.0193 25.9956C11.954 25.9834 11.8928 25.9589 11.8275 25.9548C10.2597 25.8486 8.7573 25.4771 7.35287 24.7872C3.4376 22.8561 1.04108 19.7451 0.20005 15.4542C0.106149 14.9684 0.0653225 14.4703 0 13.9804C0 13.4823 0 12.9842 0 12.4861C0.0163306 12.4126 0.0367439 12.3432 0.0408266 12.2697C0.146976 10.7102 0.510332 9.21182 1.21255 7.81963C3.49067 3.29196 7.16915 0.81379 12.2316 0.49126C14.7466 0.332037 17.1227 0.93627 19.2742 2.26313C23.1487 4.65149 25.2431 8.14624 25.5125 12.6943C25.6473 15.0051 25.1451 17.2097 24.0224 19.2388C22.0341 22.8316 19.0129 25.0321 14.967 25.7956C14.4853 25.8854 13.9953 25.9303 13.5136 25.9956ZM12.7787 14.8255C12.7787 14.8132 12.7787 14.7969 12.7787 14.7846C11.9744 14.7846 11.1661 14.7806 10.3618 14.7846C8.23064 14.801 6.50367 16.2054 6.11174 18.2427C5.99334 18.8469 5.92394 19.4756 6.3322 19.99C6.62615 20.3575 6.99767 20.6882 7.38961 20.9576C9.39828 22.3457 11.6233 22.8846 14.0525 22.5621C15.8611 22.3212 17.4534 21.5864 18.8496 20.4187C19.2906 20.0513 19.4947 19.5614 19.4947 18.9939C19.4947 16.8954 17.8575 15.0296 15.7713 14.8418C14.7792 14.752 13.7749 14.8255 12.7787 14.8255ZM8.54092 8.51368C8.55317 10.8408 10.4475 12.7311 12.7665 12.7311C15.0936 12.7311 17.0206 10.7959 16.9879 8.48919C16.9553 6.14574 15.0691 4.27588 12.7501 4.29221C10.4149 4.30446 8.52867 6.19881 8.54092 8.51368Z"
                  fill="#DC2F2B" />
                <path
                  d="M12.7786 14.8255C13.7747 14.8255 14.7791 14.752 15.7671 14.8418C17.8533 15.0296 19.4904 16.8954 19.4904 18.9939C19.4904 19.5654 19.2822 20.0553 18.8454 20.4187C17.4491 21.5863 15.8569 22.3212 14.0483 22.5621C11.6191 22.8846 9.39403 22.3457 7.38537 20.9576C6.99751 20.6882 6.62191 20.3615 6.32796 19.99C5.91969 19.4756 5.9891 18.8469 6.10749 18.2426C6.50351 16.2054 8.23048 14.805 10.3575 14.7846C11.1618 14.7765 11.9702 14.7846 12.7745 14.7846C12.7786 14.7969 12.7786 14.8091 12.7786 14.8255Z"
                  fill="white" />
                <path
                  d="M8.54059 8.51369C8.52834 6.19882 10.4145 4.30447 12.7539 4.29222C15.0728 4.27589 16.959 6.14575 16.9917 8.48919C17.0203 10.7959 15.0933 12.7311 12.7702 12.7311C10.4472 12.7311 8.55692 10.8408 8.54059 8.51369Z"
                  fill="white" />
              </svg>
              NAME
            </span>
          </button>
          <ul class="dropdown-menu text-center">
            <li><a class="dropdown-item" href="{{url('profile')}}">Profile</a></li>
            <hr class="my-1 mx-4" style="border: 1px solid red">
            <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>