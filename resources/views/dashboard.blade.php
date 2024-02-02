@extends('master.master')

@section('content')
    <section class="nftmax-adashboard nftmax-show">


        <div class="nftmax-adashboard-left ">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="total-earnings">
                                <div class="total-earnings-main">
                                    <div class="sub-earnings">
                                        <div class="icon">
                                            <img src="{{ asset('/assets/images/icon/total.png') }}" alt="icon">
                                        </div>
                                        <div class="text">
                                            <h6>Total earnings</h6>
                                        </div>
                                    </div>

                                    <div class="sub-earnings-user">
                                        <img src="{{ asset('/assets/images/icon/user.png') }}" alt="img">
                                    </div>
                                </div>

                                <div class="total-earnings-inner">
                                    <div class="total-earnings-price">
                                        <h2>$72.4K</h2>

                                        <div class="total-earnings-price-btm">
                                            <span>
                                                <svg width="16" height="14" viewBox="0 0 16 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg') }}">
                                                    <path
                                                        d="M13.4318 0.52295L12.4446 0.52295L8.55575 0.522949L7.56859 0.522949C6.28227 0.522949 5.48082 1.9183 6.12896 3.0294L9.06056 8.05501C9.7037 9.15752 11.2967 9.15752 11.9398 8.05501L14.8714 3.0294C15.5196 1.91831 14.7181 0.52295 13.4318 0.52295Z"
                                                        fill="#22C55E" />
                                                    <path opacity="0.4"
                                                        d="M2.16878 13.0486L3.15594 13.0486L7.04483 13.0486L8.03199 13.0486C9.31831 13.0486 10.1198 11.6532 9.47163 10.5421L6.54002 5.51652C5.89689 4.41402 4.30389 4.41401 3.66076 5.51652L0.729153 10.5421C0.0810147 11.6532 0.882466 13.0486 2.16878 13.0486Z"
                                                        fill="#22C55E" />
                                                </svg>
                                            </span>

                                            <span class="span-color"> + 3.5% </span>
                                        </div>
                                    </div>
                                    <div class="total-earnings-price-btm-cgart">
                                        <canvas id="totalEarnBar"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 responsive-pt-25px ">
                            <div class="total-earnings">
                                <div class="total-earnings-main">
                                    <div class="sub-earnings">
                                        <div class="icon">
                                            <img src="{{ asset('/assets/images/icon/total.png') }}" alt="icon">
                                        </div>
                                        <div class="text">
                                            <h6>Total Spending</h6>
                                        </div>
                                    </div>

                                    <div class="sub-earnings-user">
                                        <img src="{{ asset('/assets/images/icon/user.png') }}" alt="img">
                                    </div>
                                </div>

                                <div class="total-earnings-inner">
                                    <div class="total-earnings-price">
                                        <h2>$91.3K</h2>

                                        <div class="total-earnings-price-btm">
                                            <span>
                                                <svg width="16" height="14" viewBox="0 0 16 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg') }}">
                                                    <path
                                                        d="M13.4318 0.52295L12.4446 0.52295L8.55575 0.522949L7.56859 0.522949C6.28227 0.522949 5.48082 1.9183 6.12896 3.0294L9.06056 8.05501C9.7037 9.15752 11.2967 9.15752 11.9398 8.05501L14.8714 3.0294C15.5196 1.91831 14.7181 0.52295 13.4318 0.52295Z"
                                                        fill="#22C55E" />
                                                    <path opacity="0.4"
                                                        d="M2.16878 13.0486L3.15594 13.0486L7.04483 13.0486L8.03199 13.0486C9.31831 13.0486 10.1198 11.6532 9.47163 10.5421L6.54002 5.51652C5.89689 4.41402 4.30389 4.41401 3.66076 5.51652L0.729153 10.5421C0.0810147 11.6532 0.882466 13.0486 2.16878 13.0486Z"
                                                        fill="#22C55E" />
                                                </svg>
                                            </span>

                                            <span class="span-color"> + 3.5% </span>
                                        </div>
                                    </div>
                                    <div class="total-earnings-price-btm-cgart">
                                        <canvas id="totalSpendingBar"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-padding-t-25px">
                            <div class="total-earnings">
                                <div class="total-earnings-main">
                                    <div class="sub-earnings">
                                        <div class="icon">
                                            <img src="{{ asset('/assets/images/icon/total.png') }}" alt="icon">
                                        </div>
                                        <div class="text">
                                            <h6>Total Goal</h6>
                                        </div>
                                    </div>

                                    <div class="sub-earnings-user">
                                        <img src="{{ asset('/assets/images/icon/user.png') }}" alt="img">
                                    </div>
                                </div>

                                <div class="total-earnings-inner">
                                    <div class="total-earnings-price">
                                        <h2>$41.1K</h2>

                                        <div class="total-earnings-price-btm">
                                            <span>
                                                <svg width="16" height="14" viewBox="0 0 16 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg') }}">
                                                    <path
                                                        d="M13.4318 0.52295L12.4446 0.52295L8.55575 0.522949L7.56859 0.522949C6.28227 0.522949 5.48082 1.9183 6.12896 3.0294L9.06056 8.05501C9.7037 9.15752 11.2967 9.15752 11.9398 8.05501L14.8714 3.0294C15.5196 1.91831 14.7181 0.52295 13.4318 0.52295Z"
                                                        fill="#22C55E" />
                                                    <path opacity="0.4"
                                                        d="M2.16878 13.0486L3.15594 13.0486L7.04483 13.0486L8.03199 13.0486C9.31831 13.0486 10.1198 11.6532 9.47163 10.5421L6.54002 5.51652C5.89689 4.41402 4.30389 4.41401 3.66076 5.51652L0.729153 10.5421C0.0810147 11.6532 0.882466 13.0486 2.16878 13.0486Z"
                                                        fill="#22C55E" />
                                                </svg>
                                            </span>

                                            <span class="span-color"> + 3.5% </span>
                                        </div>
                                    </div>
                                    <div class="total-earnings-price-btm-cgart">
                                        <canvas id="totalGoalBar"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-padding-t-25px">
                            <div class="total-earnings">
                                <div class="total-earnings-main">
                                    <div class="sub-earnings">
                                        <div class="icon">
                                            <img src="{{ asset('/assets/images/icon/total.png') }}" alt="icon">
                                        </div>
                                        <div class="text">
                                            <h6>Month Spending</h6>
                                        </div>
                                    </div>

                                    <div class="sub-earnings-user">
                                        <img src="{{ asset('/assets/images/icon/user.png') }}" alt="img">
                                    </div>
                                </div>

                                <div class="total-earnings-inner">
                                    <div class="total-earnings-price">
                                        <h2>$12.4K</h2>

                                        <div class="total-earnings-price-btm">
                                            <span>
                                                <svg width="16" height="14" viewBox="0 0 16 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg') }}">
                                                    <path
                                                        d="M13.4318 0.52295L12.4446 0.52295L8.55575 0.522949L7.56859 0.522949C6.28227 0.522949 5.48082 1.9183 6.12896 3.0294L9.06056 8.05501C9.7037 9.15752 11.2967 9.15752 11.9398 8.05501L14.8714 3.0294C15.5196 1.91831 14.7181 0.52295 13.4318 0.52295Z"
                                                        fill="#22C55E" />
                                                    <path opacity="0.4"
                                                        d="M2.16878 13.0486L3.15594 13.0486L7.04483 13.0486L8.03199 13.0486C9.31831 13.0486 10.1198 11.6532 9.47163 10.5421L6.54002 5.51652C5.89689 4.41402 4.30389 4.41401 3.66076 5.51652L0.729153 10.5421C0.0810147 11.6532 0.882466 13.0486 2.16878 13.0486Z"
                                                        fill="#22C55E" />
                                                </svg>
                                            </span>

                                            <span class="span-color"> + 3.5% </span>
                                        </div>
                                    </div>
                                    <div class="total-earnings-price-btm-cgart">
                                        <canvas id="monthSpendingBar" height="68" width="136"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="efficiency-item">

                        <div class="efficiency-item-inner">
                            <div class="efficiency-item-text">
                                <h2>Efficiency</h2>
                            </div>
                            <div class="efficiency-item-btn">
                                <div class="dropdown">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                        Monthly

                                        <span>
                                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                                xmlns="http://www.w3.org/2000/svg') }}">
                                                <path d="M4 6.5L8 10.5L12 6.5" stroke="#1A202C" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </span>
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li><a class="dropdown-item" href="#"> January </a></li>
                                        <li><a class="dropdown-item" href="#"> February </a></li>
                                        <li><a class="dropdown-item" href="#"> March </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="efficiency-item-chart-main">
                            <div class="efficiency-item-chart">
                                <canvas id="pie_chart" height="168" width="180"
                                    style="display: block; box-sizing: border-box; height: 168px; width: 180px;"></canvas>

                            </div>

                            <div class="efficiency-item-chart-main-text">
                                <div class="efficiency-item-chart-text">
                                    <h2> $5,230 <span>
                                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                                xmlns="http://www.w3.org/2000/svg') }}">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M10.7749 0.558058C10.5309 0.313981 10.1351 0.313981 9.89107 0.558058L7.39107 3.05806C7.14699 3.30214 7.14699 3.69786 7.39107 3.94194C7.63514 4.18602 8.03087 4.18602 8.27495 3.94194L9.70801 2.50888V11C9.70801 11.3452 9.98783 11.625 10.333 11.625C10.6782 11.625 10.958 11.3452 10.958 11V2.50888L12.3911 3.94194C12.6351 4.18602 13.0309 4.18602 13.2749 3.94194C13.519 3.69786 13.519 3.30214 13.2749 3.05806L10.7749 0.558058Z"
                                                    fill="#22C55E"></path>
                                                <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.22407 11.4419C3.46815 11.686 3.86388 11.686 4.10796 11.4419L6.60796 8.94194C6.85203 8.69786 6.85203 8.30214 6.60796 8.05806C6.36388 7.81398 5.96815 7.81398 5.72407 8.05806L4.29102 9.49112L4.29102 1C4.29101 0.654823 4.01119 0.375001 3.66602 0.375001C3.32084 0.375001 3.04102 0.654823 3.04102 1L3.04102 9.49112L1.60796 8.05806C1.36388 7.81398 0.968151 7.81398 0.724074 8.05806C0.479996 8.30214 0.479996 8.69786 0.724074 8.94194L3.22407 11.4419Z"
                                                    fill="#22C55E"></path>
                                            </svg>
                                        </span></h2>

                                    <p>Arrival</p>
                                </div>
                                <div class="efficiency-item-chart-text efficiency-item-chart-text-two">
                                    <h2> $5,230 <span>
                                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                                xmlns="http://www.w3.org/2000/svg') }}">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M10.7749 0.558058C10.5309 0.313981 10.1351 0.313981 9.89107 0.558058L7.39107 3.05806C7.14699 3.30214 7.14699 3.69786 7.39107 3.94194C7.63514 4.18602 8.03087 4.18602 8.27495 3.94194L9.70801 2.50888V11C9.70801 11.3452 9.98783 11.625 10.333 11.625C10.6782 11.625 10.958 11.3452 10.958 11V2.50888L12.3911 3.94194C12.6351 4.18602 13.0309 4.18602 13.2749 3.94194C13.519 3.69786 13.519 3.30214 13.2749 3.05806L10.7749 0.558058Z"
                                                    fill="#1A202C"></path>
                                                <path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.22407 11.4419C3.46815 11.686 3.86388 11.686 4.10796 11.4419L6.60796 8.94194C6.85203 8.69786 6.85203 8.30214 6.60796 8.05806C6.36388 7.81398 5.96815 7.81398 5.72407 8.05806L4.29102 9.49112L4.29102 1C4.29101 0.654823 4.01119 0.375001 3.66602 0.375001C3.32084 0.375001 3.04102 0.654823 3.04102 1L3.04102 9.49112L1.60796 8.05806C1.36388 7.81398 0.968151 7.81398 0.724074 8.05806C0.479996 8.30214 0.479996 8.69786 0.724074 8.94194L3.22407 11.4419Z"
                                                    fill="#1A202C"></path>
                                            </svg>
                                        </span></h2>

                                    <p>Spending</p>
                                </div>
                            </div>


                        </div>


                        <div class="efficiency-item-btm">
                            <div class="efficiency-item-btm-text">
                                <div class="text-one">
                                    <div class="goal"></div>

                                    <p>Goal</p>
                                </div>
                                <div class="text">
                                    <p>13%</p>
                                </div>
                            </div>
                            <div class="efficiency-item-btm-text">
                                <div class="text-one">
                                    <div class="goal spending"></div>

                                    <p>Spending</p>
                                </div>
                                <div class="text">
                                    <p>28%</p>
                                </div>
                            </div>
                            <div class="efficiency-item-btm-text">
                                <div class="text-one">
                                    <div class="goal others"></div>

                                    <p>Others</p>
                                </div>
                                <div class="text">
                                    <p>59%</p>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
            <div class="row row-mt-25px">
                <div class="col-lg-8 col-md-7">
                    <div class="revenue-item">
                        <div class="revenue-inner">



                            <div class="revenue-inner-text">
                                <h2>Summary</h2>
                            </div>
                            <div class="revenue-inner-df">
                                <div class="revenue-inner-df-text">
                                    <div class="yellow"></div>
                                    <div class="text">
                                        <h6>Pending </h6>
                                    </div>
                                </div>
                                <div class="revenue-inner-df-text">
                                    <div class="yellow signed "></div>
                                    <div class="text">
                                        <h6>Signed </h6>
                                    </div>
                                </div>
                                <div class="revenue-inner-df-text">
                                    <div class="yellow lost"></div>
                                    <div class="text">
                                        <h6>Lost </h6>
                                    </div>
                                </div>
                            </div>

                            <div class="revenue-item-btn">
                                <div class="dropdown">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                        id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Jan 10 - Jan 16

                                        <span>
                                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                                xmlns="http://www.w3.org/2000/svg') }}">
                                                <path d="M4 6.5L8 10.5L12 6.5" stroke="#1A202C" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </span>
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li><a class="dropdown-item" href="#"> Jan 10 - Jan 16</a></li>
                                        <li><a class="dropdown-item" href="#"> Jan 10 - Jan 16</a></li>
                                        <li><a class="dropdown-item" href="#"> Jan 10 - Jan 16</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <div class="revene-chart">
                            <canvas id="revenueFlowBar" height="255" width="659"></canvas>
                        </div>


                    </div>
                </div>

                <div class="col-lg-4 col-md-5 responsive-pt-25px">
                    <div class="most-location-item">
                        <div class="most-location-inner">
                            <div class="most-location-item-text">
                                <h2>Most Location</h2>
                                <p>Compared to last month</p>
                            </div>
                            <div class="most-location-item-text-right">
                                <h2>76,345</h2>
                                <p><span>
                                        <svg width="10" height="10" viewBox="0 0 10 7" fill="none"
                                            xmlns="http://www.w3.org/2000/svg') }}">
                                            <path d="M0.5 5.89575L3.5 2.89575L5.5 4.89575L9.5 0.895752"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M6 0.895752H9.5V4.39575" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>12,00%</p>
                            </div>
                        </div>


                        <div class="most-location-item-two">
                            <div class="most-location-item-two-img">
                                <span>
                                    <svg width="30" height="23" viewBox="0 0 30 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg') }}">
                                        <mask id="mask0_1557_18389" style="mask-type:luminance"
                                            maskUnits="userSpaceOnUse" x="0" y="0" width="30" height="23">
                                            <rect y="0.957031" width="30" height="22" rx="4"
                                                fill="white" />
                                        </mask>
                                        <g mask="url(#mask0_1557_18389)">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0 0.957031V22.957H30V0.957031H0Z" fill="#009933" />
                                            <mask id="mask1_1557_18389" style="mask-type:luminance"
                                                maskUnits="userSpaceOnUse" x="0" y="0" width="30" height="23">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M0 0.957031V22.957H30V0.957031H0Z" fill="white" />
                                            </mask>
                                            <g mask="url(#mask1_1557_18389)">
                                                <g filter="url(#filter0_d_1557_18389)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M14.9314 4.3524L26.3706 12.1472L14.7758 19.4474L3.57087 11.9961L14.9314 4.3524Z"
                                                        fill="#FFD221" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M14.9314 4.3524L26.3706 12.1472L14.7758 19.4474L3.57087 11.9961L14.9314 4.3524Z"
                                                        fill="url(#paint0_linear_1557_18389)" />
                                                </g>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M15 16.7238C17.5888 16.7238 19.6875 14.6718 19.6875 12.1405C19.6875 9.60916 17.5888 7.55713 15 7.55713C12.4112 7.55713 10.3125 9.60916 10.3125 12.1405C10.3125 14.6718 12.4112 16.7238 15 16.7238Z"
                                                    fill="#2E42A5" />
                                                <mask id="mask2_1557_18389" style="mask-type:luminance"
                                                    maskUnits="userSpaceOnUse" x="10" y="7" width="10"
                                                    height="10">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M15 16.7238C17.5888 16.7238 19.6875 14.6718 19.6875 12.1405C19.6875 9.60916 17.5888 7.55713 15 7.55713C12.4112 7.55713 10.3125 9.60916 10.3125 12.1405C10.3125 14.6718 12.4112 16.7238 15 16.7238Z"
                                                        fill="white" />
                                                </mask>
                                                <g mask="url(#mask2_1557_18389)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M13.4812 14.3128L13.2719 14.4204L13.3118 14.1924L13.1424 14.031L13.3766 13.9977L13.4812 13.7903L13.5859 13.9977L13.8201 14.031L13.6507 14.1924L13.6906 14.4204L13.4812 14.3128Z"
                                                        fill="#F7FCFF" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M15.3562 14.3128L15.1469 14.4204L15.1868 14.1924L15.0174 14.031L15.2516 13.9977L15.3562 13.7903L15.4609 13.9977L15.6951 14.031L15.5257 14.1924L15.5656 14.4204L15.3562 14.3128Z"
                                                        fill="#F7FCFF" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M15.3562 15.4129L15.1469 15.5205L15.1868 15.2925L15.0174 15.1311L15.2516 15.0978L15.3562 14.8904L15.4609 15.0978L15.6951 15.1311L15.5257 15.2925L15.5656 15.5205L15.3562 15.4129Z"
                                                        fill="#F7FCFF" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M14.4187 11.5628L14.2094 11.6704L14.2493 11.4424L14.0799 11.281L14.3141 11.2477L14.4187 11.0403L14.5234 11.2477L14.7576 11.281L14.5882 11.4424L14.6281 11.6704L14.4187 11.5628Z"
                                                        fill="#F7FCFF" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M14.4187 13.3963L14.2094 13.5039L14.2493 13.2759L14.0799 13.1145L14.3141 13.0812L14.4187 12.8738L14.5234 13.0812L14.7576 13.1145L14.5882 13.2759L14.6281 13.5039L14.4187 13.3963Z"
                                                        fill="#F7FCFF" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M13.1062 12.4795L12.8969 12.5872L12.9368 12.3592L12.7674 12.1977L13.0016 12.1645L13.1062 11.957L13.2109 12.1645L13.4451 12.1977L13.2757 12.3592L13.3156 12.5872L13.1062 12.4795Z"
                                                        fill="#F7FCFF" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M11.7937 13.2129L11.5844 13.3206L11.6243 13.0926L11.4549 12.9311L11.6891 12.8979L11.7937 12.6904L11.8984 12.8979L12.1326 12.9311L11.9632 13.0926L12.0031 13.3206L11.7937 13.2129Z"
                                                        fill="#F7FCFF" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M16.1062 10.0962L15.8969 10.2039L15.9368 9.97588L15.7674 9.81442L16.0016 9.78116L16.1062 9.57373L16.2109 9.78116L16.4451 9.81442L16.2757 9.97588L16.3156 10.2039L16.1062 10.0962Z"
                                                        fill="#F7FCFF" />
                                                    <path
                                                        d="M9.30469 11.0379L9.44567 9.20972C13.9437 9.54135 17.494 10.9875 20.0516 13.5598L18.7072 14.8378C16.4905 12.6083 13.3712 11.3377 9.30469 11.0379Z"
                                                        fill="#F7FCFF" />
                                                    <path
                                                        d="M11.5215 10.6764L11.5698 10.2205C14.4694 10.5141 16.9565 11.6001 19.0236 13.476L18.7047 13.8119C16.7129 12.0043 14.3209 10.9599 11.5215 10.6764Z"
                                                        fill="#009933" />
                                                </g>
                                            </g>
                                        </g>
                                        <defs>
                                            <filter id="filter0_d_1557_18389" x="3.5708" y="4.35229" width="22.7998"
                                                height="15.095" filterUnits="userSpaceOnUse"
                                                color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                <feColorMatrix in="SourceAlpha" type="matrix"
                                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                    result="hardAlpha" />
                                                <feOffset />
                                                <feColorMatrix type="matrix"
                                                    values="0 0 0 0 0.0313726 0 0 0 0 0.368627 0 0 0 0 0 0 0 0 0.28 0" />
                                                <feBlend mode="normal" in2="BackgroundImageFix"
                                                    result="effect1_dropShadow_1557_18389" />
                                                <feBlend mode="normal" in="SourceGraphic"
                                                    in2="effect1_dropShadow_1557_18389" result="shape" />
                                            </filter>
                                            <linearGradient id="paint0_linear_1557_18389" x1="30" y1="22.957"
                                                x2="30" y2="0.957031" gradientUnits="userSpaceOnUse">

                                                <stop offset="1" stop-color="#FFDE42" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </span>
                            </div>
                            <div class="most-location-item-two-text  ">
                                <div class="text-item">
                                    <h2>Brazil</h2>
                                    <p>65%</p>
                                </div>

                                <div class="text-item-inner">

                                </div>

                            </div>
                        </div>
                        <div class="most-location-item-two most-location-item-two-mt  ">
                            <div class="most-location-item-two-img">
                                <span>
                                    <svg width="30" height="23" viewBox="0 0 30 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg') }}">
                                        <mask id="mask0_1557_18416" style="mask-type:luminance"
                                            maskUnits="userSpaceOnUse" x="0" y="0" width="30" height="23">
                                            <rect y="0.00415039" width="30" height="22" rx="4"
                                                fill="white" />
                                        </mask>
                                        <g mask="url(#mask0_1557_18416)">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M20.625 0.00415039H30V22.0042H20.625V0.00415039Z" fill="#FF8C1A" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0 0.00415039H11.25V22.0042H0V0.00415039Z" fill="#5EAA22" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.375 0.00415039H20.625V22.0042H9.375V0.00415039Z" fill="#F7FCFF" />
                                        </g>
                                    </svg>
                                </span>
                            </div>
                            <div class="most-location-item-two-text">
                                <div class="text-item">
                                    <h2>Ireland</h2>
                                    <p>74%</p>
                                </div>

                                <div class="text-item-inner text-item-inner-two ">

                                </div>

                            </div>
                        </div>
                        <div class="most-location-item-two">
                            <div class="most-location-item-two-img">
                                <span>
                                    <svg width="30" height="23" viewBox="0 0 30 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg') }}">
                                        <mask id="mask0_1557_18430" style="mask-type:luminance"
                                            maskUnits="userSpaceOnUse" x="0" y="0" width="30" height="23">
                                            <rect y="0.0512695" width="30" height="22" rx="4"
                                                fill="white" />
                                        </mask>
                                        <g mask="url(#mask0_1557_18430)">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0 0.0512695H30V22.0513H0V0.0512695Z" fill="#5EAA22" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0 0.0512695L30 22.0513H0V0.0512695Z" fill="#4141DB" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.625 8.30127L4.6875 8.97232L4.8131 7.84294L3.75 7.3846L4.8131 6.92627L4.6875 5.79689L5.625 6.46794L6.5625 5.79689L6.4369 6.92627L7.5 7.3846L6.4369 7.84294L6.5625 8.97232L5.625 8.30127Z"
                                                fill="white" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.75 13.8013L2.8125 14.4723L2.9381 13.3429L1.875 12.8846L2.9381 12.4263L2.8125 11.2969L3.75 11.9679L4.6875 11.2969L4.5619 12.4263L5.625 12.8846L4.5619 13.3429L4.6875 14.4723L3.75 13.8013Z"
                                                fill="white" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.5 19.3013L6.5625 19.9723L6.6881 18.8429L5.625 18.3846L6.6881 17.9263L6.5625 16.7969L7.5 17.4679L8.4375 16.7969L8.3119 17.9263L9.375 18.3846L8.3119 18.8429L8.4375 19.9723L7.5 19.3013Z"
                                                fill="white" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.4375 10.593L7.96875 10.9285L8.03155 10.3639L7.5 10.1347L8.03155 9.90552L7.96875 9.34083L8.4375 9.67635L8.90625 9.34083L8.84345 9.90552L9.375 10.1347L8.84345 10.3639L8.90625 10.9285L8.4375 10.593Z"
                                                fill="white" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M20.2136 11.2565C19.8632 10.899 23.017 10.059 23.3439 8.97596C23.7771 8.033 23.4877 7.26891 21.8507 6.59786C20.2137 5.92682 18.5592 4.62929 20.4616 4.62929C22.3641 4.62929 22.3641 4.89452 22.8752 5.67689C23.3862 6.45927 24.4909 6.62686 24.5143 5.67689C24.5143 4.05824 24.6706 3.84054 23.3342 2.4333C21.9978 1.02607 26.6853 3.0112 26.2978 5.42368C25.9104 7.83615 25.4439 7.0577 25.74 7.46267C26.0361 7.86765 27.8178 6.61053 27.5953 8.28511C26.972 9.2482 25.7358 10.6812 20.2136 11.2565Z"
                                                fill="#FECA00" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15 15.6347C17.5888 15.6347 19.6875 13.5827 19.6875 11.0514C19.6875 8.52005 17.5888 6.46802 15 6.46802C12.4112 6.46802 10.3125 8.52005 10.3125 11.0514C10.3125 13.5827 12.4112 15.6347 15 15.6347Z"
                                                fill="#FECA00" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M12.1434 9.36646C12.6751 9.25055 13.4022 10.6427 14.7144 10.1206C16.0266 9.59841 16.3007 8.60157 16.9242 8.9664C17.5477 9.33124 17.6295 10.2097 17.2142 10.6512C16.7988 11.0927 16.094 11.1971 16.094 11.7551C16.094 12.3132 15.9558 14.3031 15.6864 13.7264C14.8787 13.0856 15.3715 12.065 14.3766 11.7551C13.3817 11.4453 12.7774 11.4557 12.0434 11.5864C11.3095 11.7172 12.5365 11.2273 12.7967 10.7621C13.3266 10.2638 11.9003 9.53219 12.1434 9.36646Z"
                                                fill="#548650" />
                                        </g>
                                    </svg>
                                </span>
                            </div>
                            <div class="most-location-item-two-text">
                                <div class="text-item">
                                    <h2>Christmas Island</h2>
                                    <p>37%</p>
                                </div>

                                <div class="text-item-inner text-item-inner-three ">

                                </div>

                            </div>
                        </div>



                    </div>
                </div>
            </div>

            <div class="row tabel-main-box">
                <div class="col-lg-12 col-padding-0">
                    <div class="tabel-search-box">
                        <div class="tabel-search-box-item">
                            <div class="tabel-search-box-inner">
                                <div class="search-icon">
                                    <img src="{{ asset('/assets/images/icon/search.png') }}" alt="img">
                                </div>
                                <input type="email" class="form-control" id="exampleFormControlInput1-0"
                                    placeholder="Search by name, email, or others...">
                            </div>
                            <div class="tabel-search-box-button">
                                <div class="tabel-search-box-button-img">
                                    <img src="{{ asset('/assets/images/icon/filter.svg') }}" alt="img">
                                </div>
                                <div class="dropdown">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                        id="dropdownMenuLink-2" data-bs-toggle="dropdown" aria-expanded="false">
                                        Filters
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li>
                                            <a class="dropdown-item" href="#"> January</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">February</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"> March</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-padding-0 col-pr-15px margin-top-20px">
                    <div class="list-btn-item">
                        <div class="list-btn-text">
                            <h5>Location</h5>
                        </div>
                        <div class="list-btn">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    State or province

                                    <span class="btn-img">
                                        <img src="{{ asset('assets/images/icon/chevron-down.png') }}" alt="img">
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                                    <li>
                                        <a class="dropdown-item active" href="#">January</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">February</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">March</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-padding-0 col-pr-15px margin-top-20px">
                    <div class="list-btn-item">
                        <div class="list-btn-text">
                            <h5>Amount Spent</h5>
                        </div>
                        <div class="list-btn">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton2-0"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    > $1,000

                                    <span class="btn-img">
                                        <img src="{{ asset('/assets/images/icon/chevron-down.png') }}" alt="img">
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                                    <li>
                                        <a class="dropdown-item active" href="#">January</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">February</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">March</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-padding-0 col-pr-15px margin-top-20px">
                    <div class="list-btn-item">
                        <div class="list-btn-text">
                            <h5>Transaction list Date</h5>
                        </div>
                        <div class="list-btn">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton2-01"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Select date

                                    <span class="btn-img">
                                        <img src="{{ asset('/assets/images/icon/calendar.png') }}" alt="img">
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                                    <li>
                                        <a class="dropdown-item active" href="#">January</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">February</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">March</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-padding-0 margin-top-20px">
                    <div class="list-btn-item">
                        <div class="list-btn-text">
                            <h5>Type of transaction</h5>
                        </div>
                        <div class="list-btn">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton2-0-1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    All transaction

                                    <span class="btn-img">
                                        <img src="{{ asset('/assets/images/icon/chevron-down.png') }}" alt="img">
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                                    <li>
                                        <a class="dropdown-item active" href="#">January</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">February</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">March</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="tabel-main">
                        <table id="expendable-data-table" class="table display nowrap">
                            <thead>
                                <tr>
                                    <td class="details-control">
                                        <input class="form-check-input" type="checkbox" id="checkboxNoLabel"
                                            value="" aria-label="...">
                                    </td>
                                    <th>
                                        Customer name
                                        <span>
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg') }}">
                                                <path d="M11.332 2.31567V14.3157" stroke="#718096" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M6.66602 12.3157L4.66602 14.3157L2.66602 12.3157" stroke="#718096"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M4.66602 14.3157V2.31567" stroke="#718096" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M13.332 4.31567L11.332 2.31567L9.33203 4.31567" stroke="#718096"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </th>
                                    <th>
                                        Email
                                        <span>
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg') }}">
                                                <path d="M11.332 2.31567V14.3157" stroke="#718096" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M6.66602 12.3157L4.66602 14.3157L2.66602 12.3157" stroke="#718096"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M4.66602 14.3157V2.31567" stroke="#718096" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M13.332 4.31567L11.332 2.31567L9.33203 4.31567" stroke="#718096"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </th>
                                    <th>
                                        Location
                                        <span>
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg') }}">
                                                <path d="M11.332 2.31567V14.3157" stroke="#718096" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M6.66602 12.3157L4.66602 14.3157L2.66602 12.3157" stroke="#718096"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M4.66602 14.3157V2.31567" stroke="#718096" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M13.332 4.31567L11.332 2.31567L9.33203 4.31567" stroke="#718096"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </th>
                                    <th>
                                        Spent
                                        <span>
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg') }}">
                                                <path d="M11.332 2.31567V14.3157" stroke="#718096" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M6.66602 12.3157L4.66602 14.3157L2.66602 12.3157" stroke="#718096"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M4.66602 14.3157V2.31567" stroke="#718096" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M13.332 4.31567L11.332 2.31567L9.33203 4.31567" stroke="#718096"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="details-control">
                                        <input class="form-check-input" type="checkbox" id="checkboxNoLabel-0"
                                            value="" aria-label="...">
                                    </td>
                                    <td>
                                        <div class="tabel-item">
                                            <div class="tabel-img">
                                                <img src="{{ asset('/assets/images/tabel-1.png') }}" alt="img">
                                            </div>
                                            <div class="tabel-text">
                                                <p>Devon Lane</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>devon@mail.com</td>
                                    <td>System Architect</td>
                                    <td>Edinburgh</td>
                                    <td>
                                        <button class="btn btn-primary" type="submit">
                                            <span>
                                                <svg width="18" height="4" viewBox="0 0 18 4" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg') }}">
                                                    <path
                                                        d="M8 2.00024C8 2.55253 8.44772 3.00024 9 3.00024C9.55228 3.00024 10 2.55253 10 2.00024C10 1.44796 9.55228 1.00024 9 1.00024C8.44772 1.00024 8 1.44796 8 2.00024Z"
                                                        stroke="#A0AEC0" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M1 2.00024C1 2.55253 1.44772 3.00024 2 3.00024C2.55228 3.00024 3 2.55253 3 2.00024C3 1.44796 2.55228 1.00024 2 1.00024C1.44772 1.00024 1 1.44796 1 2.00024Z"
                                                        stroke="#A0AEC0" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M15 2.00024C15 2.55253 15.4477 3.00024 16 3.00024C16.5523 3.00024 17 2.55253 17 2.00024C17 1.44796 16.5523 1.00024 16 1.00024C15.4477 1.00024 15 1.44796 15 2.00024Z"
                                                        stroke="#A0AEC0" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="details-control">
                                        <input class="form-check-input" type="checkbox" id="checkboxNoLabel-001"
                                            value="" aria-label="...">
                                    </td>
                                    <td>
                                        <div class="tabel-item">
                                            <div class="tabel-img">
                                                <img src="{{ asset('/assets/images/tabel-2.png') }}" alt="img">
                                            </div>
                                            <div class="tabel-text">
                                                <p>Bessie Cooper</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Winters</td>
                                    <td>Accountant</td>
                                    <td>Tokyo</td>
                                    <td>
                                        <button class="btn btn-primary" type="submit">
                                            <span>
                                                <svg width="18" height="4" viewBox="0 0 18 4" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg') }}">
                                                    <path
                                                        d="M8 2.00024C8 2.55253 8.44772 3.00024 9 3.00024C9.55228 3.00024 10 2.55253 10 2.00024C10 1.44796 9.55228 1.00024 9 1.00024C8.44772 1.00024 8 1.44796 8 2.00024Z"
                                                        stroke="#A0AEC0" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M1 2.00024C1 2.55253 1.44772 3.00024 2 3.00024C2.55228 3.00024 3 2.55253 3 2.00024C3 1.44796 2.55228 1.00024 2 1.00024C1.44772 1.00024 1 1.44796 1 2.00024Z"
                                                        stroke="#A0AEC0" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M15 2.00024C15 2.55253 15.4477 3.00024 16 3.00024C16.5523 3.00024 17 2.55253 17 2.00024C17 1.44796 16.5523 1.00024 16 1.00024C15.4477 1.00024 15 1.44796 15 2.00024Z"
                                                        stroke="#A0AEC0" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="details-control">
                                        <input class="form-check-input" type="checkbox" id="checkboxNoLabel-11"
                                            value="" aria-label="...">
                                    </td>
                                    <td>
                                        <div class="tabel-item">
                                            <div class="tabel-img">
                                                <img src="{{ asset('/assets/images/tabel-3.png') }}" alt="img">
                                            </div>
                                            <div class="tabel-text">
                                                <p>Dianne Russell</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Cox</td>
                                    <td>Junior Technical Author</td>
                                    <td>San Francisco</td>
                                    <td>
                                        <button class="btn btn-primary" type="submit">
                                            <span>
                                                <svg width="18" height="4" viewBox="0 0 18 4" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg') }}">
                                                    <path
                                                        d="M8 2.00024C8 2.55253 8.44772 3.00024 9 3.00024C9.55228 3.00024 10 2.55253 10 2.00024C10 1.44796 9.55228 1.00024 9 1.00024C8.44772 1.00024 8 1.44796 8 2.00024Z"
                                                        stroke="#A0AEC0" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M1 2.00024C1 2.55253 1.44772 3.00024 2 3.00024C2.55228 3.00024 3 2.55253 3 2.00024C3 1.44796 2.55228 1.00024 2 1.00024C1.44772 1.00024 1 1.44796 1 2.00024Z"
                                                        stroke="#A0AEC0" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M15 2.00024C15 2.55253 15.4477 3.00024 16 3.00024C16.5523 3.00024 17 2.55253 17 2.00024C17 1.44796 16.5523 1.00024 16 1.00024C15.4477 1.00024 15 1.44796 15 2.00024Z"
                                                        stroke="#A0AEC0" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="show-result-main">
                            <div class="show-result-main-item">
                                <div class="show-result-main-inner-one">
                                    <div class="show-result-main-inner-text">
                                        <p>Show result</p>
                                    </div>
                                    <div class="show-result-main-inner-btn">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                                3

                                                <span class="btn-img">
                                                    <img src="{{ asset('/assets/images/icon/chevron-down.png') }}"
                                                        alt="">
                                                </span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                <li>
                                                    <button class="dropdown-item" type="button">
                                                        1
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item" type="button">
                                                        2
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item" type="button">
                                                        3
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="show-result-main-inner">
                                    <nav aria-label="...">
                                        <ul class="pagination">
                                            <li class="page-item">
                                                <a class="page-link" href="#">Previous</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">1</a>
                                            </li>
                                            <li class="page-item active" aria-current="page">
                                                <a class="page-link" href="#">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">...</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">20</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="nftmax-adashboard-right">
            <div class="nftmax-adashboard-right-res-df">
                <div class="my-walet-main-box ">
                    <div class="my-walet-item-box">
                        <div class="my-walet-item-box-inner">
                            <div class="my-walet-item-box-text">
                                <h4>My Wallet</h4>
                            </div>
                            <div class="my-walet-item-box-btn">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton1-05" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg width="18" height="4" viewBox="0 0 18 4" fill="none"
                                            xmlns="http://www.w3.org/2000/svg') }}">
                                            <path
                                                d="M8 2C8 2.55228 8.44772 3 9 3C9.55228 3 10 2.55228 10 2C10 1.44772 9.55228 1 9 1C8.44772 1 8 1.44772 8 2Z"
                                                stroke="#CBD5E0" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                            <path
                                                d="M1 2C1 2.55228 1.44772 3 2 3C2.55228 3 3 2.55228 3 2C3 1.44772 2.55228 1 2 1C1.44772 1 1 1.44772 1 2Z"
                                                stroke="#CBD5E0" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                            <path
                                                d="M15 2C15 2.55228 15.4477 3 16 3C16.5523 3 17 2.55228 17 2C17 1.44772 16.5523 1 16 1C15.4477 1 15 1.44772 15 2Z"
                                                stroke="#CBD5E0" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1-02">
                                        <li>
                                            <a class="dropdown-item" href="#"> Master Card</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">Master Card</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#"> Others</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="my-walet-item-box-img-slick">
                            <div class="my-walet-item-box-img">
                                <img src="{{ asset('/assets/images/card-1.svg') }}" class="w-100" alt="img">
                            </div>
                            <div class="my-walet-item-box-img">
                                <img src="{{ asset('/assets/images/card-2.svg') }}" class="w-100" alt="img">
                            </div>
                            <div class="my-walet-item-box-img">
                                <img src="{{ asset('/assets/images/card-3.svg') }}" class="w-100" alt="img">
                            </div>
                        </div>

                        <div class="quick-transfr">
                            <div class="quick-transfr-head">
                                <h4>Quick Transfer</h4>
                            </div>

                            <div class="quick-trandfr-btn">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton1-02" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="one">
                                            <span>
                                                <svg width="26" height="16" viewBox="0 0 26 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg') }}">
                                                    <g clip-path="url(#clip0_1557_18621)">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M9.3877 14.2687H16.3464V1.70776H9.3877V14.2687Z"
                                                            fill="#FF5F00" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M9.82945 7.98847C9.82945 5.44015 11.0173 3.17054 12.867 1.70798C11.5141 0.63819 9.80736 0 7.95215 0C3.56021 0 0 3.57662 0 7.98847C0 12.4003 3.56021 15.9769 7.95215 15.9769C9.80736 15.9769 11.5141 15.3388 12.867 14.269C11.0173 12.8062 9.82945 10.5368 9.82945 7.98847Z"
                                                            fill="#EB001B" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M25.4859 12.9384V12.6284H25.4052L25.3127 12.8417L25.2199 12.6284H25.1393V12.9384H25.196V12.7045L25.2831 12.9062H25.3421L25.4291 12.7041V12.9384H25.4859ZM24.9753 12.9384V12.6812H25.0787V12.6289H24.8158V12.6812H24.919V12.9384H24.9753ZM25.7342 7.98823C25.7342 12.4001 22.1737 15.9767 17.782 15.9767C15.9268 15.9767 14.2198 15.3385 12.8672 14.2687C14.7169 12.8062 15.9047 10.5366 15.9047 7.98823C15.9047 5.44013 14.7169 3.17051 12.8672 1.70774C14.2198 0.637946 15.9268 -0.000244141 17.782 -0.000244141C22.1737 -0.000244141 25.7342 3.57637 25.7342 7.98823Z"
                                                            fill="#F79E1B" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1557_18621">
                                                            <rect width="26" height="16" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </span>

                                            <span class="btn-text">Debit</span>
                                        </span>

                                        <span class="two">
                                            <span class="btn-text-two"> $10,431 </span>
                                            <span class="btn-text-svg') }}"><svg width="16" height="16"
                                                    viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg') }}">
                                                    <path d="M4 6L8 10L12 6" stroke="#A0AEC0" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="#">Jan 10 - Jan 16</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">Jan 10 - Jan 16</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">Jan 10 - Jan 16</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="btn-two">
                                <p>Enter amount</p>

                                <div class="btn-main">
                                    <div class="btn-text">
                                        <h2>$</h2>
                                    </div>
                                    <div class="btn-input">
                                        <input type="email" class="form-control" id="exampleFormControlInput2">
                                    </div>
                                    <div class="btn-img">
                                        <img src="{{ asset('/assets/images/recipient.png') }}" alt="img">
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="calender">
                    <div class="calender-head">
                        <h2>Select Date</h2>
                    </div>

                    <div class="calender-item">
                        <div class="calender-item-btn">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    June 2022
                                    <span class="btn-img">
                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg') }}">
                                            <path
                                                d="M13.1906 15.1084L18.6836 9.60565C18.7747 9.51527 18.8471 9.40774 18.8964 9.28927C18.9458 9.1708 18.9712 9.04372 18.9712 8.91538C18.9712 8.78703 18.9458 8.65996 18.8964 8.54148C18.8471 8.42301 18.7747 8.31548 18.6836 8.2251C18.5015 8.04402 18.255 7.94238 17.9982 7.94238C17.7413 7.94238 17.4949 8.04402 17.3128 8.2251L12.4517 13.0376L7.63917 8.2251C7.45701 8.04402 7.2106 7.94238 6.95375 7.94238C6.6969 7.94238 6.45049 8.04402 6.26833 8.2251C6.17647 8.31514 6.10339 8.42252 6.05332 8.54101C6.00325 8.6595 5.9772 8.78674 5.97667 8.91538C5.9772 9.04401 6.00325 9.17125 6.05332 9.28974C6.10339 9.40823 6.17647 9.51561 6.26833 9.60565L11.7614 15.1084C11.8524 15.2071 11.9629 15.2859 12.0859 15.3397C12.2089 15.3936 12.3417 15.4214 12.476 15.4214C12.6102 15.4214 12.743 15.3936 12.866 15.3397C12.989 15.2859 13.0995 15.2071 13.1906 15.1084Z" />
                                        </svg>
                                    </span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">January </a></li>
                                    <li>
                                        <a class="dropdown-item" href="#">February </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">March </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="calender-item-main">
                            <div class="flatpickr-innerContainer">
                                <div class="flatpickr-rContainer">
                                    <div class="flatpickr-weekdays">
                                        <div class="flatpickr-weekdaycontainer">
                                            <span class="flatpickr-weekday">
                                                Sun</span><span class="flatpickr-weekday">Mon</span><span
                                                class="flatpickr-weekday">Tue</span><span
                                                class="flatpickr-weekday">Wed</span><span
                                                class="flatpickr-weekday">Thu</span><span
                                                class="flatpickr-weekday">Fri</span><span class="flatpickr-weekday">Sat
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flatpickr-days" tabindex="-1">
                                        <div class="dayContainer"><span class="flatpickr-day prevMonthDay"
                                                aria-label="August 27, 2023" tabindex="-1">27</span><span
                                                class="flatpickr-day prevMonthDay" aria-label="August 28, 2023"
                                                tabindex="-1">28</span><span class="flatpickr-day prevMonthDay"
                                                aria-label="August 29, 2023" tabindex="-1">29</span><span
                                                class="flatpickr-day prevMonthDay" aria-label="August 30, 2023"
                                                tabindex="-1">30</span><span class="flatpickr-day prevMonthDay"
                                                aria-label="August 31, 2023" tabindex="-1">31</span><span
                                                class="flatpickr-day" aria-label="September 1, 2023"
                                                tabindex="-1">1</span><span class="flatpickr-day"
                                                aria-label="September 2, 2023" tabindex="-1">2</span><span
                                                class="flatpickr-day" aria-label="September 3, 2023"
                                                tabindex="-1">3</span><span class="flatpickr-day"
                                                aria-label="September 4, 2023" tabindex="-1">4</span><span
                                                class="flatpickr-day today" aria-label="September 5, 2023"
                                                aria-current="date" tabindex="-1">5</span><span class="flatpickr-day"
                                                aria-label="September 6, 2023" tabindex="-1">6</span><span
                                                class="flatpickr-day" aria-label="September 7, 2023"
                                                tabindex="-1">7</span><span class="flatpickr-day"
                                                aria-label="September 8, 2023" tabindex="-1">8</span><span
                                                class="flatpickr-day" aria-label="September 9, 2023"
                                                tabindex="-1">9</span><span class="flatpickr-day"
                                                aria-label="September 10, 2023" tabindex="-1">10</span><span
                                                class="flatpickr-day" aria-label="September 11, 2023"
                                                tabindex="-1">11</span><span class="flatpickr-day"
                                                aria-label="September 12, 2023" tabindex="-1">12</span><span
                                                class="flatpickr-day" aria-label="September 13, 2023"
                                                tabindex="-1">13</span><span class="flatpickr-day"
                                                aria-label="September 14, 2023" tabindex="-1">14</span><span
                                                class="flatpickr-day" aria-label="September 15, 2023"
                                                tabindex="-1">15</span><span class="flatpickr-day"
                                                aria-label="September 16, 2023" tabindex="-1">16</span><span
                                                class="flatpickr-day" aria-label="September 17, 2023"
                                                tabindex="-1">17</span><span class="flatpickr-day"
                                                aria-label="September 18, 2023" tabindex="-1">18</span><span
                                                class="flatpickr-day" aria-label="September 19, 2023"
                                                tabindex="-1">19</span><span class="flatpickr-day"
                                                aria-label="September 20, 2023" tabindex="-1">20</span><span
                                                class="flatpickr-day" aria-label="September 21, 2023"
                                                tabindex="-1">21</span><span class="flatpickr-day"
                                                aria-label="September 22, 2023" tabindex="-1">22</span><span
                                                class="flatpickr-day" aria-label="September 23, 2023"
                                                tabindex="-1">23</span><span class="flatpickr-day"
                                                aria-label="September 24, 2023" tabindex="-1">24</span><span
                                                class="flatpickr-day" aria-label="September 25, 2023"
                                                tabindex="-1">25</span><span class="flatpickr-day"
                                                aria-label="September 26, 2023" tabindex="-1">26</span><span
                                                class="flatpickr-day" aria-label="September 27, 2023"
                                                tabindex="-1">27</span><span class="flatpickr-day"
                                                aria-label="September 28, 2023" tabindex="-1">28</span><span
                                                class="flatpickr-day" aria-label="September 29, 2023"
                                                tabindex="-1">29</span><span class="flatpickr-day"
                                                aria-label="September 30, 2023" tabindex="-1">30</span><span
                                                class="flatpickr-day nextMonthDay" aria-label="October 1, 2023"
                                                tabindex="-1">1</span><span class="flatpickr-day nextMonthDay"
                                                aria-label="October 2, 2023" tabindex="-1">2</span><span
                                                class="flatpickr-day nextMonthDay" aria-label="October 3, 2023"
                                                tabindex="-1">3</span><span class="flatpickr-day nextMonthDay"
                                                aria-label="October 4, 2023" tabindex="-1">4</span><span
                                                class="flatpickr-day nextMonthDay" aria-label="October 5, 2023"
                                                tabindex="-1">5</span><span class="flatpickr-day nextMonthDay"
                                                aria-label="October 6, 2023" tabindex="-1">6</span><span
                                                class="flatpickr-day nextMonthDay" aria-label="October 7, 2023"
                                                tabindex="-1">7</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </section>
@endsection


