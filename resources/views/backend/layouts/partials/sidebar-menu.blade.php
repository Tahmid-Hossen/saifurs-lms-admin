<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    <li class="@if (Route::is('dashboard')) active @endif "
    >
        <a href=" {!! url('/') !!}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    @hasanyrole('Super Admin|Admin|Management|Member')
    @if(auth()->user()->can('categories.index') || auth()->user()->can('books.index') ||
        auth()->user()->can('book-rating-comments.index') || auth()->user()->can('ebooks.index')
    )
        <li class="treeview @if (
    Route::is('categories.*') || Route::is('books.*') || Route::is('book-rating-comments.*') || Route::is('ebooks.*')
    ) menu-open @endif ">
            <a href="#">
                <i class="fa fa-bookmark"></i> <span>Book Manage</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu"
                @if (
                Route::is('categories.*') || Route::is('books.*') || Route::is('book-rating-comments.*') || Route::is('ebooks.*')
                )
                style="display:block;"
                @endif
                >
                @if(auth()->user()->can('books.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('books.*')) class="active" @endif >
                        <a href="{{route('books.index')}}"><i class="fa fa-book"></i> Book</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('books.stockhistory'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('books.*')) class="active" @endif >
                        <a href="{{route('books.stockhistory')}}"><i class="fa fa-book"></i> Stock Transaction history</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('book-rating-comments.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('book-rating-comments.*')) class="active" @endif >
                        <a href="{{route('book-rating-comments.index')}}"><i class="fa fa-book"></i> Book Feedback</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('categories.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('categories.*')) class="active" @endif >
                        <a href="{{route('categories.index')}}"><i class="fa fa-list-alt"></i> Book Category</a>
                    </li>
                    @endhasanyrole
                @endif

                {{--                @if(auth()->user()->can('ebooks.index'))
                                    @hasanyrole('Super Admin|Admin|Management')
                                    <li @if (Route::is('ebooks.*')) class="active" @endif >
                                        <a href="{{route('ebooks.index')}}"><i class="fa fa-address-book"></i> Ebook</a>
                                    </li>
                                    @endhasanyrole
                                @endif--}}

                @if(auth()->user()->can('keywords.index'))
                    {{--
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('keywords.*')) class="active" @endif >
                        <a href="{{route('keywords.index')}}"><i class="fa fa-tags"></i> Keywords</a>
                    </li>
                    @endhasanyrole
                    --}}
                @endif
            </ul>
        </li>
        @endhasanyrole
    @endif

    @if(auth()->user()->can('course.index') || auth()->user()->can('course-classes.index') || auth()->user()->can('course-learns.index') ||
        auth()->user()->can('course-chapters.index') || auth()->user()->can('course-assignments.index') || auth()->user()->can('course-batches.index') ||
        auth()->user()->can('course-ratings.index') || auth()->user()->can('enrollments.index') || auth()->user()->can('announcements.index'))
        @hasanyrole('Super Admin|Admin|Management|Member|Instructor')
        <li class="treeview
            @if (
            Route::is('course.*') || Route::is('course-classes.*') ||  Route::is('course-learns.*') ||
            Route::is('course-chapters.*') || Route::is('questions.*') || Route::is('answers.*') ||
            Route::is('course-assignments.*') || Route::is('course-batches.*')|| Route::is('course-ratings.*') ||
            Route::is('enrollments.*') || Route::is('announcements.*') || Route::is('quizzes.*') ||
            Route::is('course-categories.*') || Route::is('course-sub-categories.*') || Route::is('course-child-categories.*')
            ) menu-open @endif
            ">
            <a href="#">
                <i class="fa fa-tasks"></i> <span>Course Manage</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu"
                @if (
                Route::is('course.*') || Route::is('course-classes.*') || Route::is('course-learns.*') ||
                Route::is('course-syllabuses.*') || Route::is('course-chapters.*') || Route::is('course-assignments.*') || Route::is('course-batches.*') ||
                Route::is('course-ratings.*') || Route::is('enrollments.*') || Route::is('announcements.*') || Route::is('course-categories.*') ||
                Route::is('course-sub-categories.*') || Route::is('course-child-categories.*'))
                style="display:block;"
                @endif
            >
                @if(auth()->user()->can('course-categories.index') || auth()->user()->can('course-sub-categories.index') || auth()->user()->can('course-child-categories.index'))
                    @hasanyrole('Super Admin|Admin|Management|Member|Instructor')
                    <li class="treeview @if (Route::is('course-categories.*') || Route::is('course-sub-categories.*')|| Route::is('course-child-categories.*')) menu-open @endif ">
                        <a href="#">
                            <i class="fa fa-list-ol"></i> <span>Category Manage</span>
                            <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu"
                            @if (
                            Route::is('course-categories.*') || Route::is('course-sub-categories.*')|| Route::is('course-child-categories.*')
                            )
                            style="display:block;"
                            @endif
                        >
                            @if(auth()->user()->can('course-categories.index'))
                                @hasanyrole('Super Admin|Admin|Management|Instructor')
                                <li @if (Route::is('course-categories.*')) class="active" @endif >
                                    <a href="{{route('course-categories.index')}}"><i class="fa fa-file-text"></i>
                                        Category</a>
                                </li>
                                @endhasanyrole
                            @endif

                            @if(auth()->user()->can('course-sub-categories.index'))
                                @hasanyrole('Super Admin|Admin|Management|Instructor')
                                <li @if (Route::is('course-sub-categories.*')) class="active" @endif >
                                    <a href="{{route('course-sub-categories.index')}}"><i class="fa fa-clone"></i> Sub
                                        Category</a>
                                </li>
                                @endhasanyrole
                            @endif

                            @if(auth()->user()->can('course-child-categories.index'))
                                @hasanyrole('Super Admin|Admin|Management|Instructor')
                                <li @if (Route::is('course-child-categories.*')) class="active" @endif >
                                    <a href="{{route('course-child-categories.index')}}"><i class="fa fa-list-alt"></i>
                                        Child Category</a>
                                </li>
                                @endhasanyrole
                            @endif
                        </ul>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('course.index'))
                    @hasanyrole('Super Admin|Admin|Management|Instructor')
                    <li @if (Route::is('course.*')) class="active" @endif >
                        <a href="{{route('course.index')}}"><i class="fa fa-paragraph" aria-hidden="true"></i>
                            Course</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('course-chapters.index'))
                    @hasanyrole('Super Admin|Admin|Management|Instructor')
                    <li @if (Route::is('course-chapters.*')) class="active" @endif >
                        <a href="{{route('course-chapters.index')}}"><i class="fa fa-columns"></i> Class</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('course-classes.index'))
                    @hasanyrole('Super Admin|Admin|Management|Instructor')
                    <li @if (Route::is('course-classes.*')) class="active" @endif >
                        <a href="{{route('course-classes.index')}}"><i class="fa fa-eercast"></i> Lesson</a>
                    </li>
                    @endhasanyrole
                @endif


                @if(auth()->user()->can('course-batches.index'))
                    @hasanyrole('Super Admin|Admin|Management|Instructor')
                    <li @if (Route::is('course-batches.*')) class="active" @endif >
                        <a href="{{route('course-batches.index')}}"><i class="fa fa-laptop"></i> Batch</a>
                    </li>
                    @endhasanyrole
                @endif
                @if(auth()->user()->can('course-learns.index'))
                    @hasanyrole('Super Admin|Admin|Management|Instructor')
                    <li @if (Route::is('course-learns.*')) class="active" @endif >
                        <a href="{{route('course-learns.index')}}"><i class="fa fa-leanpub"></i> Learn</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('course-syllabuses.index'))
                    @hasanyrole('Super Admin|Admin|Management|Instructor')
                    <li @if (Route::is('course-syllabuses.*')) class="active" @endif >
                        <a href="{{route('course-syllabuses.index')}}"><i class="fa fa-th-list"></i> Syllabus</a>
                    </li>
                    @endhasanyrole
                @endif

				{{-- @if(auth()->user()->can('enrollments.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('enrollments.*')) class="active" @endif >
                        <a href="{{route('enrollments.index')}}"><i class="fa fa-first-order" aria-hidden="true"></i>
                            Enrollment</a>
                    </li>
                    @endhasanyrole
                @endif--}}

                @if(auth()->user()->can('course-ratings.index'))
                    @hasanyrole('Super Admin|Admin|Management|Instructor')
                    <li @if (Route::is('course-ratings.*')) class="active" @endif >
                        <a href="{{route('course-ratings.index')}}"><i class="fa fa-star-half-o"></i> Review-Ratings</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('announcements.index'))
                    @hasanyrole('Super Admin|Admin|Management|Instructor')
                    <li @if (Route::is('announcements.*')) class="active" @endif>
                        <a href="{{ route('announcements.index') }}"><i class="fa fa-check-circle"></i> Announcement
                            List</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('course-assignments.index'))
                    @hasanyrole('Super Admin|Admin|Management|Instructor')
                    <li @if (Route::is('course-assignments.*')) class="active" @endif >
                        <a href="{{route('course-assignments.index')}}"><i class="fa fa-laptop"></i> Submitted
                            Assignment</a>
                    </li>
                    @endhasanyrole
                @endif
            </ul>
        </li>
        @endhasanyrole
    @endif




    @if(auth()->user()->can('quizzes.index') || auth()->user()->can('questions.index'))
        @hasanyrole('Super Admin|Admin|Management|Member|Instructor')
        <li class="treeview
            @if (Route::is('questions.*') || Route::is('quizzes.*')) menu-open @endif
            ">
            <a href="#">
                <i class="fa fa-tasks"></i> <span>Quiz Manage</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu"
                @if (Route::is('questions.*') || Route::is('quizzes.*'))
                style="display:block;"
                @endif>

					@if(auth()->user()->can('quizzes.index'))
                        @hasanyrole('Super Admin|Admin|Management|Instructor')
                        <li @if (Route::is('quizzes.*')) class="active" @endif>
                            <a href="{{ route('quizzes.index') }}"><i class="fa fa-check-circle"></i> Quiz</a>
                        </li>
                        @endhasanyrole
                    @endif

                    @if(auth()->user()->can('questions.index'))
                        @hasanyrole('Super Admin|Admin|Management|Instructor')
                            <li @if (Route::is('questions.*')) class="active" @endif >
                                <a href="{{route('questions.index')}}"><i class="fa fa-question-circle"></i> Question & Answer</a>
                            </li>
                        @endhasanyrole
                    @endif
            </ul>
        </li>
        @endhasanyrole
    @endif




    @hasanyrole('Super Admin|Admin|Management|Member')
    @if(auth()->user()->can('categories.index') || auth()->user()->can('books.index') ||
        auth()->user()->can('book-rating-comments.index') || auth()->user()->can('ebooks.index'))
        <li class="treeview @if (Route::is('events.*') || Route::is('events-registration.*')) menu-open @endif ">
            <a href="#">
                <i class="fa fa-graduation-cap"></i> <span>Event Manage</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu"
                @if (Route::is('events.*') || Route::is('events-registration.*'))
                style="display:block;"
                @endif
            >
                @if(auth()->user()->can('events.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('events.index')) class="active" @endif >

                        <a href="{{route('events.index')}}"><i class="fa fa-graduation-cap"></i> Events</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('events-registration.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('events-registration.*')) class="active" @endif >
                        <a href="{{route('events-registration.index')}}"><i class="fa fa-user-circle"></i> Event

                            Registration</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('events.archive'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('events.archive')) class="active" @endif >
                        <a href="{{route('events.archive')}}"><i class="fa fa-list-alt"></i> Event Archive</a>
                    </li>
                    @endhasanyrole
                @endif
            </ul>
        </li>
        @endhasanyrole
    @endif
<!-- Sales -->
    @if(auth()->user()->can('sales.index') || auth()->user()->can('transactions.index'))
        @hasanyrole('Super Admin|Admin|Management|Member')
        <li class="treeview @if (Route::is('sales.*') || Route::is('transactions*')) menu-open @endif ">
            <a href="#">
                <i class="fa fa-money"></i> <span>Manage Sales</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu"
                @if (Route::is('sales.*') || Route::is('transactions.*'))
                style="display:block;"
                @endif
            >
                @if(auth()->user()->can('sales.index'))
                    @hasanyrole('Super Admin|Admin')
                    <li @if (Route::is('sales.*')) class="active" @endif>
                        <a href="{{ route('sales.index') }}?sort=id&direction=desc"><i class="fa fa-dollar"></i>
                            Sales</a>
                    </li>
                    @endhasanyrole
                @endif
                {{--                @if(auth()->user()->can('transactions.index'))
                                    <li @if (Route::is('transactions.*')) class="active" @endif >
                                        <a href="{{route('transactions.index')}}"><i class="fa fa-hand-grab-o"></i> Payments</a>
                                    </li>
                                @endif--}}
            </ul>
        </li>
        @endhasanyrole
    @endif

    @if(auth()->user()->can('users.index') || auth()->user()->can('permissions.index') || auth()->user()->can('roles.index') ||
        auth()->user()->can('user-details.index') || auth()->user()->can('companies.index') || auth()->user()->can('branches.index') ||
        auth()->user()->can('teachers.index') || auth()->user()->can('students.index'))
        @hasanyrole('Super Admin|Admin|Management|Member')
        <li class="treeview @if (
    Route::is('users.*') || Route::is('permissions.*')|| Route::is('roles.*')|| Route::is('user-details.*')||
    Route::is('companies.*') || Route::is('branches.*') || Route::is('teachers.*') || Route::is('students.*')
    ) menu-open @endif ">
            <a href="#">
                <i class="fa fa-user"></i> <span>User Manage</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu"
                @if (
                Route::is('users.*') || Route::is('permissions.*') || Route::is('roles.*') || Route::is('user-details.*') ||
                Route::is('companies.*') || Route::is('branches.*') || Route::is('teachers.*') || Route::is('students.*')
                )
                style="display:block;"
                @endif
            >
                {{--                @if(auth()->user()->can('companies.index'))
                                    @hasanyrole('Super Admin|Admin')
                                    <li @if (Route::is('companies.*')) class="active" @endif>
                                        <a href="{{ route('companies.index') }}"><i class="fa fa-building"></i> Company</a>
                                    </li>
                                    @endhasanyrole
                                @endif--}}

               {{-- @if(auth()->user()->can('branches.index'))
                    @hasanyrole('Super Admin|Admin')
                    <li @if (Route::is('branches.*')) class="active" @endif >
                        <a href="{{route('branches.index')}}"><i class="fa fa-building-o"></i> Branch</a>
                    </li>
                    @endhasanyrole
                @endif--}}

                @if(auth()->user()->can('users.index'))
                    {{--@hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('users.*')) class="active" @endif>
                        <a href="{{ route('users.index') }}"><i class="fa fa-user-plus"></i> Users</a>
                    </li>
                    @endhasanyrole--}}
                @endif

                @if(auth()->user()->can('user-details.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('user-details.*')) class="active" @endif>
                        <a href="{{ route('user-details.index') }}"><i class="fa fa-user-secret"></i> User Detail</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('teachers.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('teachers.*')) class="active" @endif>
                        <a href="{{ route('teachers.index') }}"><i class="fa fa-user-secret"></i> Teacher</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('students.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('students.*')) class="active" @endif>
                        <a href="{{ route('students.index') }}"><i class="fa fa-user-secret"></i> Student</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('roles.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('roles.*')) class="active" @endif>
                        <a href="{{ route('roles.index') }}"><i class="fa fa-expeditedssl"></i> Role</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('permissions.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('permissions.*')) class="active" @endif>
                        <a href="{{ route('permissions.index') }}"><i class="fa fa-key"></i> Permission</a>
                    </li>
                    @endhasanyrole
                @endif
            </ul>
        </li>
        @endhasanyrole
    @endif

    @if(auth()->user()->can('countries.index') || auth()->user()->can('cities.index') || auth()->user()->can('vendors.index') ||
        auth()->user()->can('vendor-meetings.index') || auth()->user()->can('coupons.index') || auth()->user()->can('banners.index') ||
        auth()->user()->can('events.index') || auth()->user()->can('events-registration.index')
    )
        @hasanyrole('Super Admin|Admin|Management|Member')
        <li class="treeview @if (
            Route::is('countries.*') || Route::is('states.*') || Route::is('cities.*') || Route::is('vendors.*') ||
            Route::is('vendor-meetings.*') || Route::is('coupons.*') || Route::is('banners.*')) menu-open @endif
            ">
            <a href=" #">
                <i class="fa fa-cogs"></i> <span>Settings</span>
                <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
            </a>
            <ul class="treeview-menu" @if (
                Route::is('countries.*') || Route::is('states.*') || Route::is('cities.*') || Route::is('vendors.*') ||
                Route::is('vendor-meetings.*') || Route::is('coupons.*') || Route::is('banners.*')) style="display:block;" @endif
            >
                @if(auth()->user()->can('countries.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    {{--<li @if (Route::is('countries.*')) class="active" @endif>
                        <a href="{{ route('countries.index') }}"><i class="fa fa-flag"></i> Country</a>
                    </li>--}}
                    @endhasanyrole
                @endif

                    @if(auth()->user()->can('branches.index'))
                        @hasanyrole('Super Admin|Admin')
                        <li @if (Route::is('branches.*')) class="active" @endif >
                            <a href="{{route('branches.index')}}"><i class="fa fa-building-o"></i> Branch</a>
                        </li>
                        @endhasanyrole
                    @endif

                @if(auth()->user()->can('states.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('states.*')) class="active" @endif>
                        <a href="{{ route('states.index') }}"><i class="fa fa-map-marker"></i> State</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('cities.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('cities.*')) class="active" @endif>
                        <a href="{{ route('cities.index') }}"><i class="fa fa-map-pin"></i> City</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('vendors.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('vendors.*')) class="active" @endif>
                        <a href="{{ route('vendors.index') }}"><i class="fa fa-user-o"></i> Vendor</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('vendor-meetings.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('vendor-meetings.*')) class="active" @endif>
                        <a href="{{ route('vendor-meetings.index') }}"><i class="fa fa-user-o"></i> Meeting</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('coupons.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('coupons.*')) class="active" @endif >
                        <a href="{{route('coupons.index')}}"><i class="fa fa-check-circle"></i>Coupon</a>
                    </li>
                    @endhasanyrole
                @endif

                @if(auth()->user()->can('banners.index'))
                    @hasanyrole('Super Admin|Admin|Management')
                    <li @if (Route::is('banners.*')) class="active" @endif>
                        <a href="{{ route('banners.index') }}"><i class="fa fa-check-circle"></i> Banner</a>
                    </li>
                    @endhasanyrole
                @endif
                    @if(auth()->user()->can('googleApiKey.index'))
                        @hasanyrole('Super Admin|Admin')
                        <li @if (Route::is('googleApiKey.*')) class="active" @endif >
                            <a href="{{route('googleApiKey.index')}}"><i class="fa fa-building-o"></i> Google Api Key</a>
                        </li>
                        @endhasanyrole
                    @endif
            </ul>
        </li>
        @endhasanyrole
    @endif


    @if(auth()->user()->can('results.index'))

        @hasanyrole('Super Admin|Admin|Management|Member')
        <li class="treeview @if (
            Route::is('results.*')
            ) menu-open @endif ">
            <a href="#">
                <i class="fa fa-certificate" aria-hidden="true"></i> <span>Result Manage</span>
                <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
            </a>
            <ul class="treeview-menu"
                @if (
                Route::is('results.*')
                )
                style="display:block;"
                @endif
            >
                @hasanyrole('Super Admin|Admin|Management')
                <li @if (Route::is('results.*')) class="active" @endif >
                    <a href="{{route('results.index')}}"><i class="fa fa-star" aria-hidden="true"></i> Quiz Result</a>
                </li>
                @endhasanyrole
            </ul>
        </li>
        @endhasanyrole

    @endif

    @if(auth()->user()->can('blogs.index'))

        @hasanyrole('Super Admin|Admin|Management|Member')
        <li class="treeview @if (
            Route::is('blogs.*')
            ) menu-open @endif ">
            <a href="#">
                <i class="fa fa-wordpress" aria-hidden="true"></i> <span>Blogs Manage</span>
                <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
            </a>
            <ul class="treeview-menu"
                @if (
                Route::is('blogs.*')
                )
                style="display:block;"
                @endif
            >
                @hasanyrole('Super Admin|Admin|Management')
                <li @if (Route::is('blogs.*')) class="active" @endif >
                    <a href="{{route('blogs.index')}}"><i class="fa fa-list" aria-hidden="true"></i> Blog Posts</a>
                </li>
                @endhasanyrole
            </ul>
        </li>
        @endhasanyrole

    @endif

     @if(auth()->user()->can('faq.index'))
        @hasanyrole('Super Admin|Admin|Management|Member')
        <li class="@if (Route::is('faq.*')) active @endif ">
            <a href="{{route('faq.index')}}">
                <i class="fa fa-question-circle" aria-hidden="true"></i> <span>FAQ</span>
            </a>
        </li>
        @endhasanyrole
    @endif
    @if(auth()->user()->can('bookpricelist.index'))
        @hasanyrole('Super Admin|Admin|Management|Member')
        <li class="@if (Route::is('bookpricelist.*')) active @endif ">
            <a href="{{route('bookpricelist.index')}}">
                <i class="fa fa-book" aria-hidden="true"></i> <span>Book Price List</span>
            </a>
        </li>
        @endhasanyrole
    @endif
    
    @if(auth()->user()->can('user-details.index'))
        @hasanyrole('Super Admin|Admin|Management|Member')
        <li class="treeview @if (
                Route::is('user-details.*') || Route::is('changePasswordGet')
                ) menu-open @endif ">
            <a href="#">
                <i class="fa fa-user-circle-o" aria-hidden="true"></i> <span>Profile Settings</span>
                <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
            </a>
            <ul class="treeview-menu"
                @if (
                Route::is('user-details.*') || Route::is('changePasswordGet')
                )
                style="display:block;"
                @endif
            >
                @hasanyrole('Super Admin|Admin|Management')
                <li @if (Route::is('user-details.*')) class="active" @endif >
                    <a href="{{ url('/backend/user-details/' . auth()->user()->id) }}"><i class="fa fa-list" aria-hidden="true"></i> View Profile</a>
                </li>

                <li @if (Route::is('changePasswordGet')) class="active" @endif>
                    <a href="{{ route('changePasswordGet') }}"><i class="fa fa-key"></i> Change Password</a>
                </li>
                @endhasanyrole
            </ul>
        </li>
        @endhasanyrole
    @endif

    <!--@if(auth()->user()->can('branchlocation.index'))
        @hasanyrole('Super Admin|Admin|Management|Member')
        <li class="@if (Route::is('branchlocation.*')) active @endif ">
            <a href="{{route('branchlocation.index')}}">
                <i class="fa fa-building-o" aria-hidden="true"></i> <span>Branch Location</span>
            </a>
        </li>
        @endhasanyrole
    @endif-->

</ul>
