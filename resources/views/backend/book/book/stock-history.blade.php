@extends('backend.layouts.master')

@section('title')
    Book
@endsection

@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-book"></i>
        Book
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <div class="row">
        @include('backend.layouts.flash')
        <div class="col-xs-12">
            <!-- Find Option -->
            <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Find Book</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route('book.pdf', request()->query()) !!}">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route( 'book.excel',request()->query()) !!}">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('books.stockhistory') }}">
                        <input type="hidden" name="is_ebook" value="NO">
                        <div class="row">
                            <div class="col-md-6">
                                {!! \Form::nText('search_text', 'Search: ',($inputs['search_text'] ?? null), false, ['placeholder' => 'Search name, Id , etc...']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! \Form::nText('author', 'Author, Contributor',($inputs['author'] ?? null), false, ['placeholder' => 'Author, Contributor']) !!}
                            </div>
                        </div>
                        
                        <div class="box-footer">
                            <div class="form-group">
                                <button type="reset" class="btn btn-danger text-bold" style="margin-right: 1rem"><i
                                        class="fa fa-eraser"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary text-bold"><i
                                        class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.box -->
            <div class="box with-border">

                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th> @sortablelink('book_name', 'Name(Edition)')</th>
                                <th> Authors</th>
                                <th> Stock Action</th>
                                <th> Quantity</th>
                                <th> Seller/Buyer Name</th>
                                <th> Contact</th>
                                <th> Address</th>
                                <th> Remark</th>
                                <th> Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($books as $index => $book)
                                <tr >
                                    <td>{{ $books->firstItem() + $loop->index }}</td>
                                    <td>
                                        <a href="{{ route('books.show',$book->book_id) }}">
                                            {!! $book->book_name !!}
                                            @if(!empty($book->edition))
                                                ({{ $book->edition }})
                                            @endif
                                        </a>
                                    </td>
                                    <td>
                                        <strong>{{ $book->author}}</strong>
                                        @if(!empty($book->contributor))
                                            <br>
                                            ({{ $book->contributor }})
                                        @endif
                                    </td>
                                    <td> {{ $book->qty }}</td>
                                    <td> {{ $book->stock_action }}</td>
                                    <td> {{ $book->vendor_name }}</td>
                                    <td> {{ $book->vendor_contact }}</td>
                                    <td> {{ $book->vendor_address }}</td>
                                    <td> {{ $book->remark }}</td>
                                    <td> {{ human_date($book->date) }}</td>
                                    <td class="tbl-action">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
                {!! \CHTML::customPaginate($books,'') !!}
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection



<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLongTitle">Stock Update ( <span id="quantity" style="font-size:16px"></span> )</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('books.stockupdate') }}" method="post" enctype="application/x-www-form-urlencoded">
        @csrf
          <div class="modal-body">
            
             <input type="hidden" name="bookid" id="bookid" />
             <div class="form-group">
                <div class="row">
                    <div class="col-sm-4"><label for="stockaction"><span>Action</span></label></div>
                    <div class="col-sm-8">
                        <select name="stockaction" id="stockaction" class="form-control" onchange="stockAction(this.value)">
                            <option value="">Select Option</option>
                            <option value="in">Stock In</option>
                            <option value="out">Stock Out</option>
                        </select>
                    </div>
                </div>
             </div>
             <div  id="vendorinfo">
                 <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4"><label for="stockaction"><span>Quantity (+/-)</span></label></div>
                        <div class="col-sm-8">
                           <input type="number" class="form-control" name="quantity" />
                        </div>
                    </div>
                 </div>
                 <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4"><label for="stockaction"><span id="vendor_name"></span></label></div>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" name="vendor_name" />
                        </div>
                    </div>
                 </div>
                 <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4"><label for="stockaction"><span id="vendor_contact"></span></label></div>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" name="vendor_contact" />
                        </div>
                    </div>
                 </div>
                 <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4"><label for="stockaction"><span id="vendor_address"></span></label></div>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" name="vendor_address" />
                        </div>
                    </div>
                 </div>
                 <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4"><label for="remark"><span>Remark</span></label></div>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" name="remark" />
                        </div>
                    </div>
                 </div>
                 <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4"><label for="stockaction"><span id="inoutdate"></span></label></div>
                        <div class="col-sm-8">
                           <input type="date" class="form-control" name="inoutdate" />
                        </div>
                    </div>
                 </div>
             </div>
             
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Stock Update</button>
          </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
function modalFunc(id,qty){
	$("#exampleModalCenter").modal('show');
	$("#bookid").val(id);
	$("#quantity").html("Available quantity "+qty +" pcs");
}

var vendorinfo = $("#vendorinfo");
vendorinfo.hide();
var stockAction = function(thisval){
	var name = $("#vendor_name");
	var contact = $("#vendor_contact");
	var address = $("#vendor_address");
	var inoutdate = $("#inoutdate");
	
	
	if(thisval=='in'){
		vendorinfo.show();
		name.html("Purchase/Collect From");
		contact.html("Seller Contact");
		address.html("Seller Address");
		inoutdate.html("Stock in date");
	}
	else if(thisval=='out'){
		vendorinfo.show();
		name.html("Buyer/Receiver Name");
		contact.html("Buyer/Receiver Contact");
		address.html("Buyer/Receiver Address");
		inoutdate.html("Stock out date");
	}
	else{
		vendorinfo.hide();
	}
}
</script>
@endpush


