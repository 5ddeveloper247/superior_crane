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
</style>


<nav class="w-100">
  <div class="px-4 py-2">
    <div class="d-flex align-items-center justify-content-between justify-content-lg-end">

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
          <div class="d-flex align-items-center justify-content-center">
            <img src="{{asset('assets/images/logo.png')}}" width="100" alt="">
          </div>
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
                <li class="nav-item pt-3">
                  <a href="{{url('dashboard')}}" class="nav-link d-flex align-items-center gap-2 px-3" href="#">
                    <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M0.00261665 10.2357C0.00261665 8.93431 0.00899456 7.63252 6.54915e-05 6.33113C-0.00503683 5.62288 0.287922 5.0809 0.904878 4.66563C3.12056 3.17439 5.32689 1.67115 7.53662 0.172317C7.87423 -0.0567051 8.1302 -0.0579042 8.46822 0.171518C10.6996 1.68474 12.9302 3.19917 15.162 4.71159C15.725 5.0929 15.9997 5.60929 15.9997 6.25759C16.0001 8.93032 16.0001 11.603 15.9997 14.2758C15.9997 14.6998 15.6961 14.9968 15.2458 14.9976C13.5378 15.0008 11.8298 15.0008 10.1222 14.9976C9.68981 14.9968 9.41386 14.7246 9.41343 14.3137C9.41215 13.3313 9.41556 12.3489 9.41173 11.3668C9.40875 10.6422 8.91213 10.081 8.18972 9.9747C7.28661 9.84161 6.49958 10.4567 6.4915 11.3169C6.48257 12.2941 6.48937 13.2717 6.48895 14.249C6.48895 14.7546 6.22788 14.9992 5.68788 14.9992C4.05939 14.9996 2.43132 14.9996 0.802831 14.9992C0.265812 14.9992 0.00261665 14.751 0.00219146 14.2454C0.00261665 12.9084 0.00261665 11.5723 0.00261665 10.2357ZM5.20104 13.7158C5.20104 13.6435 5.20104 13.5843 5.20104 13.5251C5.20231 12.7573 5.18233 11.9883 5.20996 11.2213C5.25929 9.8476 6.43112 8.76484 7.89209 8.71208C9.38452 8.65813 10.6928 9.76447 10.7541 11.1674C10.7889 11.964 10.7651 12.7629 10.7672 13.5607C10.7672 13.6195 10.7672 13.6782 10.7672 13.741C12.0662 13.741 13.3465 13.741 14.6378 13.741C14.6378 13.6774 14.6378 13.6235 14.6378 13.5695C14.6378 11.1458 14.6357 8.72208 14.6412 6.29836C14.6416 6.04336 14.5417 5.8639 14.3261 5.71721C12.2465 4.30391 10.169 2.88781 8.0932 1.46931C8.00816 1.41135 7.95544 1.41615 7.87338 1.47171C5.79205 2.88301 3.70903 4.29192 1.62473 5.69922C1.42361 5.83512 1.32752 6.00539 1.32795 6.2428C1.3322 8.68131 1.3305 11.1202 1.3305 13.5587C1.3305 13.6107 1.3305 13.6626 1.3305 13.7154C2.62989 13.7158 3.90249 13.7158 5.20104 13.7158Z"
                        fill="white" />
                    </svg>
                    <span class="sidebar-text">
                      DASHBOARD
                    </span>
                  </a>
                </li>


                <li class="nav-item pt-2">
                  <a class="nav-link d-flex align-items-center gap-2" data-bs-toggle="collapse" href="#sidebar-crane"
                    role="button" aria-expanded="false" aria-controls="collapseExample">
                    <span class="dropdown-indicator-icon-wrapper">
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M8.00048 0.0012997C9.85665 0.0012997 11.7133 -0.00220817 13.5695 0.00230195C14.8007 0.0053087 15.7589 0.816129 15.9714 2.02584C15.9939 2.15413 15.9979 2.28693 15.9979 2.41772C15.9994 6.13657 16.0019 9.85542 15.9974 13.5748C15.9959 14.806 15.1791 15.7637 13.9699 15.9727C13.8291 15.9967 13.6837 15.9987 13.5404 15.9987C9.84663 16.0002 6.15233 16.0012 2.45854 15.9987C1.20874 15.9977 0.24858 15.1984 0.0300894 13.9837C0.00703769 13.8554 0.00252756 13.7226 0.00252756 13.5918C0.000523064 9.86695 -0.00198256 6.14158 0.00252756 2.41672C0.00403094 1.20651 0.811343 0.251862 2.00252 0.034374C2.16689 0.00430645 2.33827 0.00280308 2.50615 0.00230195C4.33776 0.000798579 6.16937 0.0012997 8.00048 0.0012997ZM14.7987 8.0198C14.7987 6.17566 14.7997 4.33202 14.7982 2.48788C14.7977 1.68909 14.3111 1.2025 13.5134 1.2025C9.83811 1.20149 6.16286 1.20149 2.48711 1.2025C1.68982 1.2025 1.20172 1.69009 1.20172 2.48738C1.20072 6.16263 1.20072 9.83788 1.20172 13.5136C1.20172 14.3109 1.68982 14.799 2.4866 14.7995C6.16185 14.8005 9.8371 14.8005 13.5129 14.799C13.6311 14.799 13.7524 14.796 13.8662 14.77C14.446 14.6372 14.7972 14.1711 14.7982 13.5332C14.7997 11.6951 14.7987 9.85743 14.7987 8.0198Z"
                          fill="white" fill-opacity="0.7" />
                        <path
                          d="M9.82004 9.46509C10.8073 9.46509 11.7945 9.46459 12.7817 9.46559C13.0282 9.46559 13.2137 9.57584 13.3304 9.79333C13.4412 9.99979 13.4251 10.2037 13.2958 10.3957C13.1625 10.5941 12.9686 10.6678 12.7326 10.6673C11.3394 10.6643 9.94582 10.6658 8.55269 10.6658C8.00296 10.6658 7.45322 10.6663 6.90349 10.6658C6.47653 10.6653 6.1969 10.4232 6.20041 10.0599C6.20392 9.70413 6.48204 9.46609 6.89647 9.46609C7.87116 9.46459 8.84535 9.46509 9.82004 9.46509Z"
                          fill="white" fill-opacity="0.7" />
                        <path
                          d="M9.79849 6.50293C8.80526 6.50293 7.81153 6.50494 6.8183 6.50193C6.52164 6.50093 6.29663 6.32603 6.22046 6.05442C6.15231 5.81088 6.24953 5.53977 6.47904 5.40747C6.58227 5.34784 6.71307 5.30775 6.83133 5.30775C8.81178 5.30173 10.7922 5.30224 12.7732 5.30474C13.1345 5.30524 13.4046 5.57284 13.4011 5.9111C13.3976 6.24235 13.1325 6.50143 12.7792 6.50243C11.785 6.50494 10.7917 6.50293 9.79849 6.50293Z"
                          fill="white" fill-opacity="0.7" />
                        <path
                          d="M3.88725 5.71965C4.14282 5.44353 4.38487 5.18194 4.62641 4.92136C4.90654 4.61868 5.27186 4.58059 5.53445 4.82564C5.78802 5.06267 5.78301 5.43701 5.51691 5.72666C5.14908 6.12656 4.78026 6.52546 4.40892 6.92235C4.10775 7.24407 3.76498 7.25259 3.44325 6.95241C3.23328 6.75647 3.02131 6.56254 2.81384 6.36359C2.54624 6.10702 2.5287 5.74721 2.76724 5.49615C3.00226 5.24859 3.35205 5.24258 3.62366 5.48161C3.70785 5.55478 3.78953 5.63095 3.88725 5.71965Z"
                          fill="white" fill-opacity="0.7" />
                        <path
                          d="M3.88628 9.88902C4.14636 9.60889 4.39141 9.34279 4.63847 9.0787C4.91108 8.78654 5.2744 8.75246 5.53298 8.99401C5.78805 9.23154 5.78304 9.60688 5.51844 9.89453C5.15062 10.2939 4.78179 10.6928 4.41046 11.0892C4.10728 11.4129 3.76701 11.423 3.44529 11.1228C3.23532 10.9268 3.02284 10.7339 2.81588 10.5345C2.54677 10.2754 2.52873 9.92009 2.76576 9.66752C3.00229 9.41545 3.35659 9.41245 3.63622 9.6605C3.71489 9.73066 3.79207 9.80282 3.88628 9.88902Z"
                          fill="white" fill-opacity="0.7" />
                      </svg>
                    </span>
                    <span>Job Lists</span>
                  </a>

                  <div class="collapse sidebar-inner-content" id="sidebar-crane">
                    <ul class="nav flex-column">
                      <li class="nav-item ">
                        <a href="{{url('all_jobs')}}" class=" ps-5" href="#">
                          <span>All Jobs</span>
                        </a>
                      </li>
                      <li class="nav-item pt-3">
                        <a href="{{url('add_job')}}" class="ps-5" href="#">
                          <span>Add Jobs</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>


                <li class="nav-item pt-2">
                  <a class="nav-link d-flex align-items-center gap-2" href="{{url('add_user')}}">
                    <svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M7.91771 18.908C6.15476 18.8807 4.34324 18.6676 2.61186 17.9938C1.85848 17.7011 1.15306 17.3254 0.599404 16.7159C0.195698 16.2715 -0.0149574 15.7555 0.000826587 15.1466C0.0566776 13.0157 0.818559 11.1836 2.30468 9.65434C2.61854 9.33138 3.05685 9.30892 3.35796 9.59121C3.66878 9.88321 3.67364 10.3282 3.34885 10.6615C2.349 11.685 1.73767 12.9004 1.52459 14.3143C1.48756 14.5607 1.48634 14.8121 1.45538 15.0598C1.41107 15.4137 1.56891 15.6741 1.81841 15.8969C2.25612 16.2867 2.77699 16.5258 3.32032 16.7225C4.67228 17.2124 6.07827 17.4067 7.50733 17.4425C9.26663 17.4868 11.0041 17.3326 12.6693 16.7189C13.1191 16.5532 13.5465 16.314 13.9612 16.0687C14.4177 15.7986 14.5907 15.39 14.5397 14.8388C14.391 13.224 13.7887 11.8271 12.6493 10.6688C12.4702 10.4866 12.3536 10.2821 12.3834 10.0216C12.4174 9.72537 12.577 9.51411 12.8581 9.41091C13.1501 9.30345 13.4111 9.37569 13.6291 9.59121C14.499 10.4514 15.1383 11.4586 15.5456 12.6126C15.8249 13.4036 15.959 14.2202 15.9973 15.0573C16.0313 15.8089 15.7441 16.4117 15.2063 16.9119C14.5427 17.5287 13.7396 17.8942 12.8939 18.1747C11.3046 18.7028 9.66306 18.8904 7.91771 18.908Z"
                        fill="white" fill-opacity="0.7" />
                      <path
                        d="M8.00883 9.83245e-06C10.8439 0.00547352 13.0919 2.29112 13.0864 5.16198C13.081 7.90293 10.765 10.1874 7.99912 10.1789C5.16893 10.1704 2.89967 7.8835 2.90878 5.04967C2.91789 2.26683 5.21263 -0.00545386 8.00883 9.83245e-06ZM7.99365 8.72309C10.0085 8.72066 11.6319 7.09673 11.6331 5.08185C11.6337 3.07728 9.99883 1.45335 7.9809 1.45396C6.00183 1.45457 4.36394 3.09306 4.36394 5.07274C4.36334 7.09066 5.98969 8.72552 7.99365 8.72309Z"
                        fill="white" fill-opacity="0.7" />
                    </svg>
                    <span>Users</span>
                  </a>
                </li>


                <li class="nav-item pt-2">
                  <a href="#rigger" data-bs-toggle="collapse" class="nav-link d-flex align-items-center gap-2">
                    <svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M7.91771 18.908C6.15476 18.8807 4.34324 18.6676 2.61186 17.9938C1.85848 17.7011 1.15306 17.3254 0.599404 16.7159C0.195698 16.2715 -0.0149574 15.7555 0.000826587 15.1466C0.0566776 13.0157 0.818559 11.1836 2.30468 9.65434C2.61854 9.33138 3.05685 9.30892 3.35796 9.59121C3.66878 9.88321 3.67364 10.3282 3.34885 10.6615C2.349 11.685 1.73767 12.9004 1.52459 14.3143C1.48756 14.5607 1.48634 14.8121 1.45538 15.0598C1.41107 15.4137 1.56891 15.6741 1.81841 15.8969C2.25612 16.2867 2.77699 16.5258 3.32032 16.7225C4.67228 17.2124 6.07827 17.4067 7.50733 17.4425C9.26663 17.4868 11.0041 17.3326 12.6693 16.7189C13.1191 16.5532 13.5465 16.314 13.9612 16.0687C14.4177 15.7986 14.5907 15.39 14.5397 14.8388C14.391 13.224 13.7887 11.8271 12.6493 10.6688C12.4702 10.4866 12.3536 10.2821 12.3834 10.0216C12.4174 9.72537 12.577 9.51411 12.8581 9.41091C13.1501 9.30345 13.4111 9.37569 13.6291 9.59121C14.499 10.4514 15.1383 11.4586 15.5456 12.6126C15.8249 13.4036 15.959 14.2202 15.9973 15.0573C16.0313 15.8089 15.7441 16.4117 15.2063 16.9119C14.5427 17.5287 13.7396 17.8942 12.8939 18.1747C11.3046 18.7028 9.66306 18.8904 7.91771 18.908Z"
                        fill="white" fill-opacity="0.7" />
                      <path
                        d="M8.00883 9.83245e-06C10.8439 0.00547352 13.0919 2.29112 13.0864 5.16198C13.081 7.90293 10.765 10.1874 7.99912 10.1789C5.16893 10.1704 2.89967 7.8835 2.90878 5.04967C2.91789 2.26683 5.21263 -0.00545386 8.00883 9.83245e-06ZM7.99365 8.72309C10.0085 8.72066 11.6319 7.09673 11.6331 5.08185C11.6337 3.07728 9.99883 1.45335 7.9809 1.45396C6.00183 1.45457 4.36394 3.09306 4.36394 5.07274C4.36334 7.09066 5.98969 8.72552 7.99365 8.72309Z"
                        fill="white" fill-opacity="0.7" />
                    </svg>
                    <span>Rigger</span>
                  </a>
                  <div class="collapse sidebar-inner-content" id="rigger">
                    <ul class="nav flex-column">
                      <li class="nav-item ">
                        <a href="{{url('rigger_tickets')}}" class=" ps-5" href="#">
                          <span>Rigger Tickets</span>
                        </a>
                      </li>
                      <li class="nav-item pt-3">
                        <a href="{{url('pay_duty')}}" class="ps-5" href="#">
                          <span>Pay Duty Form</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>


                <li class="nav-item pt-2">
                  <a href="{{url('transportation')}}" class="nav-link d-flex align-items-center gap-2">
                    <svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M7.91771 18.908C6.15476 18.8807 4.34324 18.6676 2.61186 17.9938C1.85848 17.7011 1.15306 17.3254 0.599404 16.7159C0.195698 16.2715 -0.0149574 15.7555 0.000826587 15.1466C0.0566776 13.0157 0.818559 11.1836 2.30468 9.65434C2.61854 9.33138 3.05685 9.30892 3.35796 9.59121C3.66878 9.88321 3.67364 10.3282 3.34885 10.6615C2.349 11.685 1.73767 12.9004 1.52459 14.3143C1.48756 14.5607 1.48634 14.8121 1.45538 15.0598C1.41107 15.4137 1.56891 15.6741 1.81841 15.8969C2.25612 16.2867 2.77699 16.5258 3.32032 16.7225C4.67228 17.2124 6.07827 17.4067 7.50733 17.4425C9.26663 17.4868 11.0041 17.3326 12.6693 16.7189C13.1191 16.5532 13.5465 16.314 13.9612 16.0687C14.4177 15.7986 14.5907 15.39 14.5397 14.8388C14.391 13.224 13.7887 11.8271 12.6493 10.6688C12.4702 10.4866 12.3536 10.2821 12.3834 10.0216C12.4174 9.72537 12.577 9.51411 12.8581 9.41091C13.1501 9.30345 13.4111 9.37569 13.6291 9.59121C14.499 10.4514 15.1383 11.4586 15.5456 12.6126C15.8249 13.4036 15.959 14.2202 15.9973 15.0573C16.0313 15.8089 15.7441 16.4117 15.2063 16.9119C14.5427 17.5287 13.7396 17.8942 12.8939 18.1747C11.3046 18.7028 9.66306 18.8904 7.91771 18.908Z"
                        fill="white" fill-opacity="0.7" />
                      <path
                        d="M8.00883 9.83245e-06C10.8439 0.00547352 13.0919 2.29112 13.0864 5.16198C13.081 7.90293 10.765 10.1874 7.99912 10.1789C5.16893 10.1704 2.89967 7.8835 2.90878 5.04967C2.91789 2.26683 5.21263 -0.00545386 8.00883 9.83245e-06ZM7.99365 8.72309C10.0085 8.72066 11.6319 7.09673 11.6331 5.08185C11.6337 3.07728 9.99883 1.45335 7.9809 1.45396C6.00183 1.45457 4.36394 3.09306 4.36394 5.07274C4.36334 7.09066 5.98969 8.72552 7.99365 8.72309Z"
                        fill="white" fill-opacity="0.7" />
                    </svg>
                    <span>Transportation Tickets</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
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
              <a class="dropdown-item d-flex gap-2" href="#">
                <img class="rounded-5" src="https://img.freepik.com/free-vector/people-white_24877-49457.jpg?size=626&ext=jpg" width="40" height="40" alt="img">
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
              <a class="dropdown-item d-flex gap-2" href="#">
              <img class="rounded-5" src="https://img.freepik.com/free-vector/people-white_24877-49457.jpg?size=626&ext=jpg" width="40" height="40" alt="img">
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
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <hr class="my-1 mx-4" style="border: 1px solid red">
            <li><a class="dropdown-item" href="#">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>