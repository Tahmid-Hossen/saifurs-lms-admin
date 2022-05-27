@extends('backend.layouts.master')

@section('content')
    @include('backend.layouts.flash')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" id="box-title"></h3>
                    <div class="pull-right">
                        <a href="{{route('course.index')}}"
                           class="btn btn-danger hidden-print">
                            <i class="glyphicon glyphicon-hand-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <!-- Custom Tabs -->
                    <div class="row">
                        <div class="col-sm-2">
                            <button class="btn btn-block btn-primary visible-xs-block" type="button"
                                    data-toggle="collapse" data-target="#nav-sidebar" aria-expanded="false"
                                    aria-controls="nav-sidebar">
                                Menu
                            </button>
                            <ul class="nav nav-pills nav-stacked" id="nav-sidebar"
                                aria-expanded="false">
                                <li role="presentation" class="active">
                                    <a href="#course" data-toggle="tab" aria-expanded="true">Course Details</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#syllabus" data-toggle="tab" aria-expanded="false">Syllabus</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#learn" data-toggle="tab" aria-expanded="false">Learn/ Benefits</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#chapter" data-toggle="tab" aria-expanded="false">Chapter/ Modules</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#class" data-toggle="tab" aria-expanded="false">Classes</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#resource" data-toggle="tab" aria-expanded="false">Resources</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#tags" data-toggle="tab" aria-expanded="false">Tag/ Keyword(s)</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#batch" data-toggle="tab" aria-expanded="false">Course Batches</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#question" data-toggle="tab" aria-expanded="false">Questions</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#answer" data-toggle="tab" aria-expanded="false">Answers</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#quiz" data-toggle="tab" aria-expanded="false">Quiz(s)</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#assignment" data-toggle="tab" aria-expanded="false">Assignment(s)</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#" data-toggle="tab" aria-expanded="false">Tab 3</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-10">
                            <div class="tab-content">
                                <div class="tab-pane active" id="course">
                                    <div class="row">
                                        <div class="col-md-8 profile-info">
                                            <h3 class="font-green sbold uppercase"
                                                style="color: rgb(115, 93, 238)">{{$course->course_title}}</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Company:</th>
                                                    <th style="color: #00a65a">{{ strtoupper($course->company->company_name) }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Course Category:</th>
                                                    <th style="color: #76767f">{{ strtoupper($course->courseCategory->course_category_title) }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Course Sub Category:</th>
                                                    <th style="color: #76767f">{{ strtoupper($course->courseSubCategory->course_sub_category_title) }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Course Child Category:</th>
                                                    <th style="color: #76767f">{{ strtoupper($course->courseChildCategory->course_child_category_title) }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Course Slug:</th>
                                                    <th style="color: #76767f">{{ $course->course_slug }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Course Type:</th>
                                                    <th>
                                                        @if($course->course_content_type == \App\Support\Configs\Constants::$course_types[0])
                                                            <p style="font-weight:600; color: rgb(13, 35, 138)">{{ strtoupper($course->course_content_type)}}</p>
                                                        @elseif($course->course_content_type == \App\Support\Configs\Constants::$course_types[1])
                                                            <p style="font-weight:600; color: rgb(9, 148, 71)">{{ strtoupper($course->course_content_type)}}</p>
                                                        @elseif($course->course_content_type == \App\Support\Configs\Constants::$course_types[2])
                                                            <p style="font-weight:600; color: rgb(224, 176, 43)">{{ strtoupper($course->course_content_type)}}</p>
                                                        @else
                                                            <p>N/A</p>
                                                        @endif
                                                    </th>
                                                </tr>
                                                @if($course->course_content_type == \App\Support\Configs\Constants::$course_types[1])
                                                    <tr>
                                                        <th>Regular Price:</th>
                                                        <th>
                                                            @if (isset($course->course_regular_price))
                                                                {{ $course->course_regular_price }}
                                                            @else
                                                                <p>N/A</p>
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Discount Price:</th>
                                                        <th>
                                                            @if (isset($course->course_discount))
                                                                {{ $course->course_discount }}
                                                            @else
                                                                <p>N/A</p>
                                                            @endif
                                                        </th>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <th>Status:</th>
                                                    <th>
                                                        @if($course->course_status == 'ACTIVE')
                                                            <button
                                                                class="btn btn-success btn-sm">{{$course->course_status}}</button>
                                                        @else
                                                            <button
                                                                class="btn btn-danger btn-sm">{{ str_replace("-","",$course->course_status) }}</button>
                                                        @endif
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Featured:</th>
                                                    <th>
                                                        @if($course->course_featured == 'YES')
                                                            <button
                                                                class="btn btn-info btn-sm">{{$course->course_featured}}</button>
                                                        @else
                                                            <button
                                                                class="btn btn-danger btn-sm">{{$course->course_featured}}</button>
                                                        @endif
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Course File:</th>
                                                    <th>
                                                        <a href="{{ $course->course_file }}"
                                                           style=" margin-top: 8px; width:50px; height:auto">Download
                                                            File</a>
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <th>Created By:</th>
                                                    <th>{{ isset($course->createdBy)?$course->createdBy->name:null }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Created Date:</th>
                                                    <th>{{ $course->created_at->format('d M, Y') }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Position:</th>
                                                    <th>
                                                        @if (isset($course->course_position))
                                                            {{ $course->course_position }}
                                                        @else
                                                            <p>N/A</p>
                                                        @endif
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Course Duration (Expire):</th>
                                                    <th>
                                                        @if (isset($course->course_duration_expire) && isset($course->course_duration))
                                                            {{ $course->course_duration_expire." ".$course->course_duration }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Assignment:</th>
                                                    <td>
                                                        @if (isset($course->course_is_assignment) && $course->course_is_assignment == 'YES')
                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                name="course_is_assignment"
                                                                id="course_is_assignment"
                                                                value="YES"
                                                                checked
                                                            >
                                                        @else
                                                            <p class="text-danger">Not Assigned</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Certified:</th>
                                                    <td>
                                                        @if (isset($course->course_is_certified) && $course->course_is_certified == 'YES')
                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                name="course_is_certified"
                                                                id="course_is_certified"
                                                                value="YES"
                                                                checked
                                                            >
                                                        @else
                                                            <p class="text-danger">Not Certified</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Subscribed:</th>
                                                    <td>
                                                        @if (isset($course->course_is_subscribed) && $course->course_is_subscribed == 'YES')
                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                name="course_is_subscribed"
                                                                id="course_is_subscribed"
                                                                value="YES" checked
                                                            >
                                                        @else
                                                            <p class="text-danger">Not Subscribed</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Downloadable:</th>
                                                    <td>
                                                        @if (isset($course->course_is_subscribed) && $course->course_is_subscribed == 'YES')
                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                name="course_is_subscribed"
                                                                id="course_is_subscribed"
                                                                value="YES" checked
                                                            >
                                                        @else
                                                            <p class="text-danger">Not Allowed</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Course Drip Content:</th>
                                                    <th>
                                                        @if($course->course_drip_content == 'Disable')
                                                            <button
                                                                class="btn btn-danger btn-sm">{{$course->course_drip_content}}</button>
                                                        @elseif($course->course_drip_content == 'Enable')
                                                            <button
                                                                class="btn btn-primary btn-sm">{{$course->course_drip_content}}</button>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </th>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-md-6">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Image:</th>
                                                    <th>
                                                        @if (isset($course->course_image))
                                                            <img src="{{ asset($course->course_image) }}"
                                                                 style="width:200px; height:auto"/>
                                                        @else
                                                            <p>N/A</p>
                                                        @endif
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Course Video:</th>
                                                    <th>
                                                        @if (isset($course->course_video))
                                                            <div id="video-player">
                                                                <video width="100%" height="300px" controls>
                                                                    <source src="{{ $course->course_video }}"
                                                                            type="video/mp4">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            </div>
                                                        @else
                                                            <p>N/A</p>
                                                        @endif
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Course URL:</th>
                                                    <th>
                                                        @if (isset($course->course_video_url))
                                                            <a href="{{ $course->course_video_url }}"
                                                               style=" margin-top: 8px; width:50px; height:auto">{{ $course->course_video_url }}</a>
                                                        @else
                                                            <p>N/A</p>
                                                        @endif
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Course Tags:</th>
                                                    <th>
                                                        {!! \CHTML::displayTags($course->tags,'tag_name', true, 'fa fa-tag') !!}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Course Language:</th>
                                                    <th>
                                                        @if($course->course_language == 'EN')
                                                            <p>ENGLISH</p>
                                                        @elseif($course->course_language == 'BA')
                                                            <p>BANGLA</p>
                                                        @else
                                                            <p>N/A</p>
                                                        @endif
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Course Ratings:</th>
                                                    <td>
                                                        @if(isset($course->course_rating))
                                                            <span
                                                                class="label label-warning">{{$course->course_rating}}</span>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Course Comments:</th>
                                                    <td>
                                                        @if(isset($course->course_comment))
                                                            <span
                                                                class="label label-primary">{{$course->course_comment}}</span>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Course Involvement Request:</th>
                                                    <td>
                                                        @if(isset($course->involvement_request))
                                                            <span
                                                                class="label label-success">{{$course->involvement_request}}</span>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Course Requirements: </label>
                                                @if (isset($course->course_requirements))
                                                    <div class="container-fluid"
                                                         style="border: 2px solid #d2d6de; min-height: 200px">
                                                        {!! $course->course_requirements !!}
                                                    </div>
                                                @else
                                                    <p>N/A</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Course Short Description: </label>
                                                @if (isset($course->course_short_description))
                                                    <div class="container-fluid"
                                                         style="border: 2px solid #d2d6de; min-height: 200px">
                                                        {!! $course->course_short_description !!}
                                                    </div>
                                                @else
                                                    <p>N/A</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Description: </label>
                                                @if (isset($course->course_description))
                                                    <div class="container-fluid"
                                                         style="border: 2px solid #d2d6de; min-height: 200px">
                                                        {!! $course->course_description !!}
                                                    </div>
                                                @else
                                                    <p>N/A</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane border-primary" id="syllabus">

                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="learn">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                    when an unknown printer took a galley of type and scrambled it to make a type
                                    specimen
                                    book.
                                    It has survived not only five centuries, but also the leap into electronic
                                    typesetting,
                                    remaining essentially unchanged. It was popularised in the 1960s with the release of
                                    Letraset
                                    sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                                    software
                                    like Aldus PageMaker including versions of Lorem Ipsum.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="chapter">
                                    <b>How to use:</b>

                                    <p>Exactly like the original bootstrap tabs except you should use
                                        the custom wrapper <code>.nav-tabs-custom</code> to achieve this style.</p>
                                    A wonderful serenity has taken possession of my entire soul,
                                    like these sweet mornings of spring which I enjoy with my whole heart.
                                    I am alone, and feel the charm of existence in this spot,
                                    which was created for the bliss of souls like mine. I am so happy,
                                    my dear friend, so absorbed in the exquisite sense of mere tranquil existence,
                                    that I neglect my talents. I should be incapable of drawing a single stroke
                                    at the present moment; and yet I feel that I never was a greater artist than now.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="class">
                                    The European languages are members of the same family. Their separate existence is a
                                    myth.
                                    For science, music, sport, etc, Europe uses the same vocabulary. The languages only
                                    differ
                                    in their grammar, their pronunciation and their most common words. Everyone realizes
                                    why
                                    a
                                    new common language would be desirable: one could refuse to pay expensive
                                    translators.
                                    To
                                    achieve this, it would be necessary to have uniform grammar, pronunciation and more
                                    common
                                    words. If several languages coalesce, the grammar of the resulting language is more
                                    simple
                                    and regular than that of the individual languages.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="resource">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                    when an unknown printer took a galley of type and scrambled it to make a type
                                    specimen
                                    book.
                                    It has survived not only five centuries, but also the leap into electronic
                                    typesetting,
                                    remaining essentially unchanged. It was popularised in the 1960s with the release of
                                    Letraset
                                    sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                                    software
                                    like Aldus PageMaker including versions of Lorem Ipsum.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tags">
                                    <b>How to use:</b>

                                    <p>Exactly like the original bootstrap tabs except you should use
                                        the custom wrapper <code>.nav-tabs-custom</code> to achieve this style.</p>
                                    A wonderful serenity has taken possession of my entire soul,
                                    like these sweet mornings of spring which I enjoy with my whole heart.
                                    I am alone, and feel the charm of existence in this spot,
                                    which was created for the bliss of souls like mine. I am so happy,
                                    my dear friend, so absorbed in the exquisite sense of mere tranquil existence,
                                    that I neglect my talents. I should be incapable of drawing a single stroke
                                    at the present moment; and yet I feel that I never was a greater artist than now.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="batch">
                                    The European languages are members of the same family. Their separate existence is a
                                    myth.
                                    For science, music, sport, etc, Europe uses the same vocabulary. The languages only
                                    differ
                                    in their grammar, their pronunciation and their most common words. Everyone realizes
                                    why
                                    a
                                    new common language would be desirable: one could refuse to pay expensive
                                    translators.
                                    To
                                    achieve this, it would be necessary to have uniform grammar, pronunciation and more
                                    common
                                    words. If several languages coalesce, the grammar of the resulting language is more
                                    simple
                                    and regular than that of the individual languages.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="question">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                    when an unknown printer took a galley of type and scrambled it to make a type
                                    specimen
                                    book.
                                    It has survived not only five centuries, but also the leap into electronic
                                    typesetting,
                                    remaining essentially unchanged. It was popularised in the 1960s with the release of
                                    Letraset
                                    sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                                    software
                                    like Aldus PageMaker including versions of Lorem Ipsum.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="answer">
                                    <b>How to use:</b>

                                    <p>Exactly like the original bootstrap tabs except you should use
                                        the custom wrapper <code>.nav-tabs-custom</code> to achieve this style.</p>
                                    A wonderful serenity has taken possession of my entire soul,
                                    like these sweet mornings of spring which I enjoy with my whole heart.
                                    I am alone, and feel the charm of existence in this spot,
                                    which was created for the bliss of souls like mine. I am so happy,
                                    my dear friend, so absorbed in the exquisite sense of mere tranquil existence,
                                    that I neglect my talents. I should be incapable of drawing a single stroke
                                    at the present moment; and yet I feel that I never was a greater artist than now.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="quiz">
                                    The European languages are members of the same family. Their separate existence is a
                                    myth.
                                    For science, music, sport, etc, Europe uses the same vocabulary. The languages only
                                    differ
                                    in their grammar, their pronunciation and their most common words. Everyone realizes
                                    why
                                    a
                                    new common language would be desirable: one could refuse to pay expensive
                                    translators.
                                    To
                                    achieve this, it would be necessary to have uniform grammar, pronunciation and more
                                    common
                                    words. If several languages coalesce, the grammar of the resulting language is more
                                    simple
                                    and regular than that of the individual languages.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="assignment">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                    when an unknown printer took a galley of type and scrambled it to make a type
                                    specimen
                                    book.
                                    It has survived not only five centuries, but also the leap into electronic
                                    typesetting,
                                    remaining essentially unchanged. It was popularised in the 1960s with the release of
                                    Letraset
                                    sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                                    software
                                    like Aldus PageMaker including versions of Lorem Ipsum.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_1">
                                    <b>How to use:</b>

                                    <p>Exactly like the original bootstrap tabs except you should use
                                        the custom wrapper <code>.nav-tabs-custom</code> to achieve this style.</p>
                                    A wonderful serenity has taken possession of my entire soul,
                                    like these sweet mornings of spring which I enjoy with my whole heart.
                                    I am alone, and feel the charm of existence in this spot,
                                    which was created for the bliss of souls like mine. I am so happy,
                                    my dear friend, so absorbed in the exquisite sense of mere tranquil existence,
                                    that I neglect my talents. I should be incapable of drawing a single stroke
                                    at the present moment; and yet I feel that I never was a greater artist than now.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    The European languages are members of the same family. Their separate existence is a
                                    myth.
                                    For science, music, sport, etc, Europe uses the same vocabulary. The languages only
                                    differ
                                    in their grammar, their pronunciation and their most common words. Everyone realizes
                                    why
                                    a
                                    new common language would be desirable: one could refuse to pay expensive
                                    translators.
                                    To
                                    achieve this, it would be necessary to have uniform grammar, pronunciation and more
                                    common
                                    words. If several languages coalesce, the grammar of the resulting language is more
                                    simple
                                    and regular than that of the individual languages.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_3">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                    when an unknown printer took a galley of type and scrambled it to make a type
                                    specimen
                                    book.
                                    It has survived not only five centuries, but also the leap into electronic
                                    typesetting,
                                    remaining essentially unchanged. It was popularised in the 1960s with the release of
                                    Letraset
                                    sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                                    software
                                    like Aldus PageMaker including versions of Lorem Ipsum.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_1">
                                    <b>How to use:</b>

                                    <p>Exactly like the original bootstrap tabs except you should use
                                        the custom wrapper <code>.nav-tabs-custom</code> to achieve this style.</p>
                                    A wonderful serenity has taken possession of my entire soul,
                                    like these sweet mornings of spring which I enjoy with my whole heart.
                                    I am alone, and feel the charm of existence in this spot,
                                    which was created for the bliss of souls like mine. I am so happy,
                                    my dear friend, so absorbed in the exquisite sense of mere tranquil existence,
                                    that I neglect my talents. I should be incapable of drawing a single stroke
                                    at the present moment; and yet I feel that I never was a greater artist than now.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    The European languages are members of the same family. Their separate existence is a
                                    myth.
                                    For science, music, sport, etc, Europe uses the same vocabulary. The languages only
                                    differ
                                    in their grammar, their pronunciation and their most common words. Everyone realizes
                                    why
                                    a
                                    new common language would be desirable: one could refuse to pay expensive
                                    translators.
                                    To
                                    achieve this, it would be necessary to have uniform grammar, pronunciation and more
                                    common
                                    words. If several languages coalesce, the grammar of the resulting language is more
                                    simple
                                    and regular than that of the individual languages.
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_3">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                    when an unknown printer took a galley of type and scrambled it to make a type
                                    specimen
                                    book.
                                    It has survived not only five centuries, but also the leap into electronic
                                    typesetting,
                                    remaining essentially unchanged. It was popularised in the 1960s with the release of
                                    Letraset
                                    sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                                    software
                                    like Aldus PageMaker including versions of Lorem Ipsum.
                                </div>
                                <!-- /.tab-pane -->

                            </div>
                            <!-- /.tab-content -->
                        </div>
                    </div>
                    <!-- nav-tabs-custom -->
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            resizeNavbar();
            $(window).resize(function () {
                resizeNavbar();
            });

            $("#nav-sidebar li a").click(function () {
                var element =
                console.log("echo from click");
            });

        });
    </script>
@endpush
