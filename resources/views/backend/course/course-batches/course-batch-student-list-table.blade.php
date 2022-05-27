
                    <table class="table table-bordered">
                        <tr>
                            <th>Picture</th>
                            <th>Student Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th class="tbl-date"> Created At</th>
                        </tr>

                        @forelse($students as $student)
                            <tr>
                                <td>
                                    <img class="img-responsive img-thumbnail"
                                         id="company_logo_show"
                                         src="{{isset($student->userDetails)?URL::to($student->userDetails->user_detail_photo):config('app.default_image')}}"
                                         width="{{Utility::$companyLogoSize['width']/2}}"
                                    >
                                </td>
                                <td>{{isset($student->userDetails)?$student->userDetails->student_id:null}}</td>
                                <td>
                                    {{isset($student->userDetails)?$student->userDetails->first_name:null}}&nbsp;
                                    {{isset($student->userDetails)?$student->userDetails->last_name:null}}
                                </td>
                                <td>{{isset($student)?$student->email:null}}</td>
                                <td class="text-left">{{isset($student)?$student->mobile_number:null}}</td>
                                <td> {{isset($student->userDetails->created_at)?$student->userDetails->created_at->format('d M, Y'):null}}</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    There is no Student.
                                </td>
                            </tr>
                        @endforelse
                    </table>