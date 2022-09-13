@extends('layouts.app')

@section('content')
   <div id="app" class="site-wrapper">
      <div class="site-background-block">
         {{-- <svg width="57" height="55" viewBox="0 0 57 55" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14.3627 54.3053H56.6286V34.0418L0.273438 22.7874L14.3627 54.3053Z" fill="url(#paint0_linear_886_8)"/>
            <path d="M0.273438 22.7874L14.3627 54.3053H56.6286L0.273438 22.7874Z" fill="url(#paint1_linear_886_8)"/>
            <path d="M27.2217 37.8568L56.6383 0.272705L56.6217 54.3093L27.2217 37.8568Z" fill="url(#paint2_linear_886_8)"/>
            <defs>
               <linearGradient id="paint0_linear_886_8" x1="1.9806" y1="27.7814" x2="36.3067" y2="46.0418" gradientUnits="userSpaceOnUse">
                  <stop offset="0.14" stop-color="#06FFFF"/>
                  <stop offset="0.38" stop-color="#05F9FF"/>
                  <stop offset="0.7" stop-color="#02E8FF"/>
                  <stop offset="0.88" stop-color="#00DBFF"/>
                  <stop offset="0.92" stop-color="#00CBF4"/>
                  <stop offset="0.99" stop-color="#00A2D7"/>
                  <stop offset="1" stop-color="#009ED4"/>
               </linearGradient>
               <linearGradient id="paint1_linear_886_8" x1="47.512" y1="67.482" x2="12.1727" y2="25.3306" gradientUnits="userSpaceOnUse">
                  <stop offset="0.41" stop-color="#06FFFF"/>
                  <stop offset="0.55" stop-color="#03EFFF"/>
                  <stop offset="0.69" stop-color="#00DBFF"/>
                  <stop offset="0.79" stop-color="#00CBF4"/>
                  <stop offset="0.98" stop-color="#00A2D7"/>
                  <stop offset="1" stop-color="#009ED4"/>
               </linearGradient>
               <linearGradient id="paint2_linear_886_8" x1="59.2632" y1="5.37379" x2="43.5747" y2="45.4214" gradientUnits="userSpaceOnUse">
                  <stop offset="0.33" stop-color="#06FFFF"/>
                  <stop offset="0.54" stop-color="#03EFFF"/>
                  <stop offset="0.75" stop-color="#00DBFF"/>
                  <stop offset="0.83" stop-color="#00CBF4"/>
                  <stop offset="0.98" stop-color="#00A2D7"/>
                  <stop offset="1" stop-color="#009ED4"/>
               </linearGradient>
            </defs>
         </svg> --}}
         <svg width="120" height="28" viewBox="0 0 120 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_13_137)">
            <path d="M6.97694 26.7747H27.9155V16.7361L-0.00292969 11.1606L6.97694 26.7747Z" fill="url(#paint0_linear_13_137)"/>
            <path d="M-0.00292969 11.1606L6.97694 26.7747H27.9155L-0.00292969 11.1606Z" fill="url(#paint1_linear_13_137)"/>
            <path d="M13.3467 18.626L27.9197 0.00683594L27.9115 26.7767L13.3467 18.626Z" fill="url(#paint2_linear_13_137)"/>
            <path d="M43.4245 7.10895C46.1985 7.10895 48.5627 8.07763 50.517 10.015C52.4712 11.9523 53.448 14.3141 53.4473 17.1004C53.4473 19.8867 52.4702 22.2485 50.5159 24.1858C48.5617 26.1232 46.1978 27.0935 43.4245 27.0967C40.148 27.0967 37.6518 25.843 35.9357 23.3356V26.6029H32.4883V0.00488281H35.9388V10.8701C37.6542 8.36267 40.1494 7.10895 43.4245 7.10895ZM42.9883 23.8972C44.9678 23.8972 46.632 23.2449 47.9808 21.9405C49.3296 20.6361 50.0033 19.0214 50.0019 17.0965C50.0019 15.1722 49.3282 13.5575 47.9808 12.2524C46.6333 10.9473 44.9692 10.2951 42.9883 10.2958C40.9801 10.2958 39.303 10.948 37.9569 12.2524C36.6108 13.5569 35.9381 15.1729 35.9388 17.1004C35.9388 19.026 36.6125 20.6406 37.96 21.9444C39.3074 23.2482 40.9835 23.9004 42.9883 23.9011V23.8972Z" fill="white"/>
            <path d="M73.2587 7.60272H76.7062V26.5979H73.2587V23.3306C71.542 25.8381 69.0461 27.0918 65.771 27.0918C62.9969 27.0918 60.6328 26.1231 58.6785 24.1857C56.7243 22.2484 55.7468 19.8866 55.7461 17.1003C55.7461 14.3141 56.7236 11.9523 58.6785 10.0149C60.6335 8.07756 62.9976 7.10889 65.771 7.10889C69.0475 7.10889 71.5434 8.3626 73.2587 10.87V7.60272ZM66.2062 23.9C68.213 23.9 69.8905 23.2478 71.2386 21.9434C72.5867 20.6389 73.2601 19.0243 73.2587 17.0993C73.2587 15.1751 72.5853 13.5604 71.2386 12.2553C69.8918 10.9502 68.2144 10.298 66.2062 10.2986C64.2266 10.2986 62.5625 10.9509 61.2137 12.2553C59.8649 13.5598 59.1915 15.1744 59.1935 17.0993C59.1935 19.0249 59.8669 20.6396 61.2137 21.9434C62.5604 23.2472 64.2246 23.8997 66.2062 23.901V23.9Z" fill="white"/>
            <path d="M91.8255 10.7934H86.5556V21.0892C86.5556 22.0271 86.747 22.6921 87.13 23.0841C87.5129 23.4762 88.1006 23.6788 88.8931 23.6919C89.6856 23.705 90.6631 23.686 91.8255 23.6349V26.5979C88.8146 26.9775 86.6088 26.7432 85.2081 25.8949C83.8074 25.0467 83.1074 23.4431 83.1081 21.0843V10.7934H79.1855V7.60266H83.1081V3.2711L86.5556 2.28345V7.60266H91.8255V10.7934Z" fill="white"/>
            <path d="M111.033 24.2044C109 26.1326 106.53 27.0967 103.624 27.0967C100.718 27.0967 98.2553 26.1342 96.2348 24.2093C94.2143 22.285 93.2041 19.917 93.2041 17.1052C93.2041 14.2934 94.2143 11.9254 96.2348 10.0011C98.2546 8.07558 100.718 7.11312 103.624 7.11377C106.531 7.11442 109 8.07688 111.033 10.0011C113.067 11.9261 114.084 14.2941 114.084 17.1052C114.084 19.9163 113.067 22.2827 111.033 24.2044ZM103.624 23.8627C105.604 23.8627 107.268 23.2171 108.617 21.9257C109.966 20.6343 110.639 19.0259 110.638 17.1003C110.638 15.176 109.964 13.5679 108.617 12.2759C107.269 10.9839 105.605 10.3379 103.624 10.3379C101.67 10.3379 100.019 10.9839 98.6717 12.2759C97.3242 13.5679 96.6522 15.176 96.6556 17.1003C96.6556 19.0259 97.329 20.6343 98.6758 21.9257C100.023 23.2171 101.672 23.8627 103.624 23.8627Z" fill="white"/>
            <path d="M120.004 23.2334H116.494V26.5989H120.004V23.2334Z" fill="white"/>
            </g>
            <defs>
            <linearGradient id="paint0_linear_13_137" x1="0.842804" y1="13.6347" x2="17.848" y2="22.6809" gradientUnits="userSpaceOnUse">
            <stop offset="0.14" stop-color="#06FFFF"/>
            <stop offset="0.38" stop-color="#05F9FF"/>
            <stop offset="0.7" stop-color="#02E8FF"/>
            <stop offset="0.88" stop-color="#00DBFF"/>
            <stop offset="0.92" stop-color="#00CBF4"/>
            <stop offset="0.99" stop-color="#00A2D7"/>
            <stop offset="1" stop-color="#009ED4"/>
            </linearGradient>
            <linearGradient id="paint1_linear_13_137" x1="23.3991" y1="33.3024" x2="5.89201" y2="12.4206" gradientUnits="userSpaceOnUse">
            <stop offset="0.41" stop-color="#06FFFF"/>
            <stop offset="0.55" stop-color="#03EFFF"/>
            <stop offset="0.69" stop-color="#00DBFF"/>
            <stop offset="0.79" stop-color="#00CBF4"/>
            <stop offset="0.98" stop-color="#00A2D7"/>
            <stop offset="1" stop-color="#009ED4"/>
            </linearGradient>
            <linearGradient id="paint2_linear_13_137" x1="29.2201" y1="2.53392" x2="21.448" y2="22.3736" gradientUnits="userSpaceOnUse">
            <stop offset="0.33" stop-color="#06FFFF"/>
            <stop offset="0.54" stop-color="#03EFFF"/>
            <stop offset="0.75" stop-color="#00DBFF"/>
            <stop offset="0.83" stop-color="#00CBF4"/>
            <stop offset="0.98" stop-color="#00A2D7"/>
            <stop offset="1" stop-color="#009ED4"/>
            </linearGradient>
            <clipPath id="clip0_13_137">
            <rect width="120" height="27.0968" fill="white"/>
            </clipPath>
            </defs>
         </svg>
      </div>
      <page-content></page-content>
   </div>
@endsection
