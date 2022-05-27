@include('backend.layouts.partials.errors')
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! \Form::nLabel('event_id', 'Event') !!}
                <select name="event_id" id="event_id" class="form-control">
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}"
                                @if(isset($eventDetail->id) && $event->id == $eventDetail->id) selected @endif
                        >{{ $event->event_title }}</option>
                    @endforeach
                </select>
                <span id="event_id-error" class="help-block d-block text-danger">
                            {{ $errors->first('event_id') }}
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive mt-4">
                <table class="table table-stripped table-center table-hover" id="invitation-table">
                    <thead>
                    <tr>
                        <th>User/Guest <span class="text-danger text-bold">*</span></th>
                        <th>Invitation</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $count = 0; @endphp
                    @if(!empty($eventDetail->getEnrolledUsersList))
                        @foreach($eventDetail->getEnrolledUsersList as $si =>$invitation)
                            @php $count = $si; @endphp
                            <tr>
                                <td width="40%">
                                    {!! \Form::select('invitation[' .$count.'][user_id]', $users, $invitation->id, ['class' => 'form-control select2', 'placeholder' => 'Select a User']) !!}
                                </td>
                                <td>
                                    {!! \Form::select('invitation[' .$count.'][event_user_status]',
                                    ['confirmed' =>'Confirmed', 'pending' => 'Pending'], $invitation->pivot->event_user_status,
                                     ['class'=> 'form-control']) !!}
                                </td>
                                <td>
                                    {!! \Form::text('invitation[' .$count.'][remarks]', $invitation->pivot->remarks, ['class'=> 'form-control']) !!}
                                </td>
                                <td class="text-right" width="80">
                                    <button type="button"
                                            class="btn btn-sm btn-danger btn-block text-bold"
                                            onclick="removeRow(this);">Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td width="40%">
                                {!! \Form::select('invitation[0][user_id]', $users ?? [], null, ['class' => 'form-control select2', 'placeholder' => 'Select a User']) !!}
                            </td>
                            <td>
                                {!! \Form::select('invitation[0][event_user_status]',
                                ['confirmed' =>'Confirmed', 'pending' => 'Pending'], 'confirmed',
                                 ['class'=> 'form-control']) !!}
                            </td>
                            <td>
                                {!! \Form::text('invitation[0][remarks]', null, ['class'=> 'form-control']) !!}
                            </td>
                            <td class="text-right" width="80">
                                <button type="button"
                                        class="btn btn-sm btn-danger btn-block text-bold"
                                        onclick="removeRow(this);">Remove
                                </button>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="5">
                            <button type="button" class="btn btn-primary btn-block text-bold"
                                    data-current-index="{{ $count+1 ?? 0 }}" onclick="addRow(this);"><i
                                    class="fa fa-plus"></i> Add More Guest
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="box-footer">
    {!!
    \CHTML::actionButton(
        $reportTitle='..',
        $routeLink='enrollments',
        isset($enrollment) ? $enrollment->id : null,
        $selectButton=['cancelButton','storeButton'],
        $class = ' btn-icon btn-circle ',
        $onlyIcon='yes',
        $othersPram=array()
    )
!!}
</div>
@push('scripts')
    <script>
        function getRowTemplate(index) {
            return "{!! html_entity_decode(addslashes("<tr> <td width='40%'> " .
                                (\Form::select('invitation[" + index + "][user_id]', $users, null, ['class' => 'form-control select2', 'placeholder' => 'Select a User']) ) .
                                "</td> <td> " .
                                (\Form::select('invitation[" + index + "][event_user_status]', ['confirmed' =>'Confirmed', 'pending' => 'Pending'], 'confirmed', ['class'=> 'form-control'])) .
                                "</td><td> " .
                                (\Form::text('invitation[" + index + "][remarks]', null, ['class'=> 'form-control']) ) .
                                "</td><td class='text-right' width='96'> " .
                                "<button type='button' class='btn btn-sm btn-danger btn-block text-bold' onclick='removeRow(this);'>Remove</button> ".
                                "</td></tr>")) !!}";
        }

        function addRow(element) {
            var jqelement = $(element);
            var index = parseInt(jqelement.data('current-index'));
            $(getRowTemplate(index)).insertBefore(jqelement.parent().parent());
            jqelement.data('current-index', index + 1);

            $('.select2').each(function () {
                $(this).select2({width: "100%", placeholder: "Select a User"});
            })
        }

        function removeRow(element) {
            var r = $(element).parent().parent().remove();
        }

        $(document).ready(function () {
            formObject = $("form#event_register_form");
            formValidator = formObject.validate({
                rules: {
                    event_id: {
                        required: true
                    }
                }
            });

            $(".add-button").click(function () {
                var table = $("#invitation-table tbody");
                table.append(getRowTemplate(1))

            });
        });
    </script>
@endpush

