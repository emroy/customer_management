@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Customer List</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container">
                        
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Postcode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                        <button onclick="newCustomer()" class="btn btn-success"> New Customer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- NEW CUSTOMER MODAL -->
<div id="newCustomerModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Customer</h5>
        <button type="button" class="btn close" data-dismiss="#newCustomerModal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="newCustomerForm">
            <div class="form-group">
                <label for="exampleFormControlInput1">Email address</label>
                <input type="email" name="email" data-check="true" class="form-control" id="emailaddr" placeholder="name@example.com" maxlength="40">
            </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">First Name</label>
                <input type="text" name="firstname" data-check="true" class="form-control" id="firstname" placeholder="John" maxlength="15">
            </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Last Name</label>
                <input type="text" name="lastname" data-check="true" class="form-control" id="lastname" placeholder="Doe" maxlength="15">
            </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Postcode</label>
                <input type="text" name="postcode" data-check="true" class="form-control" id="postcode" placeholder="XX XXX" maxlength="10">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="saveCustomer()" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="#newCustomerModal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT CUSTOMER MODAL -->
<div id="editCustomerModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Customer</h5>
        <button type="button" class="btn close" data-dismiss="#editCustomerModal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editCustomerForm">
        <input type="hidden" name="id">
            <div class="form-group">
                <label for="exampleFormControlInput1">Email address</label>
                <input type="email" name="email" data-check="true" class="form-control" id="emailaddr" placeholder="name@example.com" maxlength="40">
            </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">First Name</label>
                <input type="text" name="first_name" data-check="true" class="form-control" id="firstname" placeholder="John" maxlength="15">
            </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Last Name</label>
                <input type="text" name="last_name" data-check="true" class="form-control" id="lastname" placeholder="Doe" maxlength="15">
            </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Postcode</label>
                <input type="text" name="postcode" data-check="true" class="form-control" id="postcode" placeholder="XX XXX" maxlength="10">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="saveEdit()" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="#editCustomerModal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
