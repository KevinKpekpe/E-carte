        <div class="left-side-menu">

            <div class="h-100" data-simplebar>

                <div id="sidebar-menu">

                    <ul id="side-menu">

                        <li class="menu-title">Navigation</li>

                        <li>
                            @if (auth()->user()->userType->name === "premium")
                                <a href="{{route('premium.index')}}">
                                <i class="mdi mdi-view-dashboard-outline"></i>
                                <span class="badge bg-success rounded-pill float-end">9+</span>
                                <span> Dashboard </span>
                            </a>
                            @endif
                            @if (auth()->user()->userType->name === "classique")
                                <a href="{{route('classique.index')}}">
                                <i class="mdi mdi-view-dashboard-outline"></i>
                                <span class="badge bg-success rounded-pill float-end">9+</span>
                                <span> Dashboard </span>
                            </a>
                            @endif
                        </li>

                        <li class="menu-title mt-2">Apps</li>

                        <li>
                            <a href="#contacts" data-bs-toggle="collapse">
                                <i class="mdi mdi-book-open-page-variant-outline"></i>
                                <span> Users </span>
                                <span class="menu-arrow"></span>
                            </a>
                            @if (auth()->user()->userType->name === "premium")
                                <div class="collapse" id="contacts">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{route('premium.index')}}">Home</a>
                                    </li>
                                    <li>
                                        <a href="{{route('premium.edit')}}">Profile</a>
                                    </li>
                                </ul>
                            </div>
                            @endif
                        </li>

                    </ul>

                </div>

                <div class="clearfix"></div>

            </div>


        </div>
