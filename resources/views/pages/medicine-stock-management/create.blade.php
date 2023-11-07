{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@include('panels.page-title')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection

{{-- page content --}}
@section('content')
<!-- users edit start -->
<div class="section users-edit">
  <div class="card">
    <div class="card-content">
      <!-- <div class="card-body"> -->
      
      <div class="row">
        <div class="col s12" id="account">
          
          <!-- users edit media object ends -->
          <!-- users edit account form start -->
          @include('panels.flashMessages')
          @if(isset($medicineResult->id))
          <?php //$formUrl = (isset($formUrl) && $formUrl!='') ? $formUrl : 'company-admin-update'; ?>
            <form class="formValidate" action="{{route($formUrl,$medicineResult->id)}}" id="formValidateCompany" method="post">
            {!! method_field('post') !!}
            @else
            <?php //$formUrl = (isset($formUrl) && $formUrl!='') ? $formUrl : 'company-admin-create'; ?>
          <form id="accountForm" action="{{route($formUrl)}}" method="post">
            @endif
            @csrf()
            <div class="row">


                @if(isset($userType) && $userType!=config('custom.superadminrole'))
                  <input type="hidden" name="company" value="{{Helper::loginUserCompanyId()}}"/>
                  @else
                  <div class="col s12 input-field">
                    <select class="error" id="company" name="company_id" data-error=".errorTxt7" required>
                      <option value="">Choose {{__('locale.code')}}</option>
                      @if(isset($companies) && !empty($companies))
                        @foreach ($companies as $company_value)
                          <option value="{{$company_value->id}}">{{$company_value->company_name}} ({{$company_value->company_code}})</option>
                        @endforeach
                      @endif
                    </select>
                    <label for="company">{{__('locale.Care home code')}}</label>
                    <small class="errorTxt7"></small>
                  </div>
                @endif
                  
                <div class="col s12 input-field">
                  <select class="error" id="medicine_result" name="medicine_id" data-error=".errorTxt7" required>
                    <option value="">Choose {{__('locale.code')}}</option>
                    @if(isset($medicine_result) && !empty($medicine_result))
                      @foreach ($medicine_result as $medicine_value)
                        <option value="{{$medicine_value->id}}">{{$medicine_value->medicine_name}}</option>
                      @endforeach
                    @endif
                  </select>
                  <label for="company">{{__('locale.medicine_name')}}</label>
                  <small class="errorTxt7"></small>
                </div>
            
           
            
                
                <div class="input-field col m6 s12">
                  <label for="name">{{__('locale.quantity')}}</label>
                  <input id="name" class="validate" name="quantity" min="0" type="number" data-error=".errorTxt1" value="{{(isset($medicineResult->quantity)) ? $medicineResult->quantity : old('quantity')}}">
                  <small class="errorTxt1"></small>
                </div>

                <div class="input-field col m12 s12">
                  <input placeholder="{{__('locale.date')}}" id="date-time" type="text" name="dates" class="datepicker date" value="{{(isset($response->date)) ? \Carbon\Carbon::parse($response->date)->format(config('app.date_format')) : old('date')}}" data-error=".errorTxt3" required>
                  <small class="errorTxt3"></small>
                  <label for="date-time">{{__('locale.date')}}*</label>
                </div>

                <div class="col s12 input-field">
                  <select class="error" id="" name="purchase_issue_type" data-error=".errorTxt7" required>
                    <option value="">Choose {{__('locale.issue')}}</option>
                    @if(isset($purchase_issue) && !empty($purchase_issue))
                      @foreach ($purchase_issue as $purchase_value)
                        <option value="{{$purchase_value}}">{{$purchase_value}}</option>
                      @endforeach
                    @endif
                  </select>
                  <label for="company">{{__('locale.purchase_issue')}}</label>
                  <small class="errorTxt7"></small>
                </div>
                
                
                <div class="input-field col s12">
                  <button class="btn waves-effect waves-light right submit" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                  </button>
                </div>
              </div>
          </form>
          <!-- users edit account form ends -->
        </div>
      </div>
      <!-- </div> -->
    </div>
  </div>
</div>
<!-- users edit ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
<script src="{{asset('js/scripts/page-users.js')}}"></script>
<script src="{{asset('js/scripts/form-validation.js')}}"></script>
<script>
  window.onload=function(){
     var company_val = "{{(isset($medicineResult->company) && $medicineResult->company!='NULL') ? $medicineResult->company : old('company')}}";
    console.log(company_val);
    $('#company').val(company_val);
    $('#company').formSelect();
    
  }
    $(document).ready(function () {
      

        $('#company').on('change', function () {
            var idCountry = this.value;
           // alert(idCountry)
            console.log(idCountry);
            $("#medicine_result").html('');
            $.ajax({
                url: "{{route($getmedicine_ajax)}}",
                type: "POST",
                data: {
                    id: idCountry,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                console.log('idCountry', result);

                    $('#medicine_result').html('<option value="">Select Company</option>');
                    $.each(result.medicine, function (key, value) {
                        $("#medicine_result").append('<option value="' + value
                            .id + '">' + value.medicine_name + '</option>');
                    });
                    $('#medicine_result').formSelect();
                    //$('#city').html('<option value="">Select City</option>');
                }
            });
        });
 
    });
</script>
@endsection