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
          @if(isset($user_result->id))
          <?php //$formUrl = (isset($formUrl) && $formUrl!='') ? $formUrl : 'company-admin-update'; ?>
            <form class="formValidate" action="{{route($formUrl,$user_result->id)}}" id="formValidateCompany" method="post">
            {!! method_field('post') !!}
            @else
            <?php //$formUrl = (isset($formUrl) && $formUrl!='') ? $formUrl : 'company-admin-create'; ?>
          <form id="accountForm" action="{{route($formUrl)}}" method="post">
            @endif
            @csrf()
            <div class="row">

            <div class="col m6 s12">
                  <label for="name">{{__('locale.code')}}</label>
                  <input id="name" class="" name="code" type="text" maxlength="8" oninput="this.value=this.value.replace(/[^0-9.,]/g,'');" data-error=".errorTxt1" value="{{(isset($user_result->code)) ? $user_result->code : $companyCode}}" 
                  >
                  <small class="errorTxt1"></small>
            </div>
            <div class="col m6 s12">
                  <label for="type">{{__('locale.select type')}}*</label>
                  <div class="input-field" style="margin-top:0px;">
                  <select name="typeselect" id="myselect">
                      <?php 
                      foreach ($roles as $role) {
                        $isSelected = (isset($user_result->typeselect) && $user_result->typeselect == $role['name']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $role['name'];?>"<?php echo $isSelected; ?>><?php echo $role['name']; ?>
                        </option>
                        <?php 
                      }
                      ?>
                    </select>
                    <small class="errorTxt6"></small>
                  </div>
                </div>

            @if(isset($userType) && $userType!=config('custom.superadminrole'))
                  <input type="hidden" name="company" value="{{Helper::loginUserCompanyId()}}"/>
                  @else
                  <div class="col s12 input-field">
                    <select class="error" id="company" name="company" data-error=".errorTxt7" required>
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
           
                <div class="input-field col m12 s12">
                  <label for="name">{{__('locale.name')}}*</label>
                  <input id="name" class="validate" name="name" type="text" data-error=".errorTxt1" value="{{(isset($user_result->name)) ? $user_result->name : old('name')}}">
                  <small class="errorTxt1"></small>
                </div>
                <div class="input-field col m4 s12">
                  <label for="address1">{{__('locale.address1')}}</label>
                  <input id="address1" type="text" name="address1" data-error=".errorTxt3" value="{{(isset($user_result->address1)) ? $user_result->address1 : old('address1')}}">
                  <small class="errorTxt3"></small>
                </div>
                <div class="input-field col m4 s12">
                  <label for="address2">{{__('locale.address2')}}</label>
                  <input id="address2" type="text" name="address2" data-error=".errorTxt4" value="{{(isset($user_result->address2) && $user_result->address2!='NULL') ? $user_result->address2 : old('address2')}}">
                  <small class="errorTxt4"></small>
                </div>
                <div class="input-field col m4 s12">
                  <label for="address2">{{__('locale.address3')}}</label>
                  <input id="address2" type="text" name="address3" data-error=".errorTxt4" value="{{(isset($user_result->address3) && $user_result->address3!='NULL') ? $user_result->address3 : old('address3')}}">
                  <small class="errorTxt4"></small>
                </div>
                <div class="col m12 s12">
                  <label for="country">{{__('locale.country')}} *</label>
                  <div class="input-field">
                    <select class="error" id="country" name="country" data-error=".errorTxt6">
                      <option value="">Choose {{__('locale.country')}}</option>
                      @if(isset($countries) && !empty($countries))
                        @foreach ($countries as $country_value)
                          <option value="{{$country_value->id}}">{{$country_value->name}}</option>
                        @endforeach
                      @endif
                    </select>
                    <small class="errorTxt6"></small>
                  </div>
                </div>
                <div class="input-field col m6 s12">
                  <label for="state">{{__('locale.state')}}</label>
                  <input id="" type="text" name="state" data-error=".errorTxt4" value="{{(isset($user_result->state) && $user_result->state!='NULL') ? $user_result->state : old('state')}}">
                  <small class="errorTxt4"></small>
                </div>
                <div class="input-field col m6 s12">
                  
                  <label for="city">{{__('locale.city')}}</label>
                  <input id="" type="text" name="city" data-error=".errorTxt4" value="{{(isset($user_result->city) && $user_result->city!='NULL') ? $user_result->city : old('city')}}">
                  <small class="errorTxt4"></small>
                </div>
                <!-- <div class="col m6 s12">
                  <label for="state">{{__('locale.state')}} *</label>
                  <div class="input-field">
                    <select class="error" id="state" name="state" data-error=".errorTxt7">
                      <option value="">Choose {{__('locale.state')}}</option>
                      @if(isset($user_result->state) && isset($states) && !empty($states))
                        @foreach ($states as $state_value)
                          <option value="{{$state_value->id}}">{{$state_value->name}}</option>
                        @endforeach
                      @endif
                    </select>
                    <small class="errorTxt7"></small>
                  </div>
                </div>
                <div class="col m6 s12">
                  <label for="city">{{__('locale.city')}} *</label>
                  <div class="input-field">
                    <select class="error" id="city" name="city" data-error=".errorTxt8">
                      <option value="">Choose {{__('locale.city')}}</option>
                      @if(isset($user_result->city) && isset($cities) && !empty($cities))
                        @foreach ($cities as $city_value)
                          <option value="{{$city_value->id}}">{{$city_value->name}}</option>
                        @endforeach
                      @endif
                    </select>
                    <small class="errorTxt8"></small>
                  </div>
                </div> -->
                
                <div class="input-field col m6 s12">
                  <label for="Zip Code">{{__('locale.ZipCode')}}</label>
                  <input id="zipcode" type="text" name="zipcode" class="zip-valid" minlength="0" maxlength="6" data-error=".errorTxt2" value="{{(isset($user_result->zipcode)) ? $user_result->zipcode : old('company_code')}}">
                  <small class="errorTxt2"></small>
                </div>
                <div class="input-field col m6 s12">
                  <label for="phone">{{__('locale.phone')}}*</label>
                  <input id="phone" type="text" class="mobile-valid" minlength="0" maxlength="13" name="phone" data-error=".errorTxt3" value="{{(isset($user_result->phone)) ? $user_result->phone : old('phone')}}">
                  <small class="errorTxt3"></small>
                </div>
                

                <div class="input-field col m6 s12">
                  <label for="email">{{__('locale.email')}}*</label>
                  <input id="email" type="email" name="email" data-error=".errorTxt3" value="{{(isset($user_result->email)) ? $user_result->email : old('email')}}">
                  <small class="errorTxt3"></small>
                </div>
                <div class="input-field col m6 s12">
                  <label for="password">{{__('locale.password')}}*</label>
                  <input id="" type="password" name="password2" data-error=".errorTxt3" value="{{(isset($user_result->password2)) ? $user_result->password2 : old('password2')}}">
                  <small class="errorTxt3"></small>
                </div>
                <div class="input-field col m6 s12">
                  <label for="Zip Code">{{__('locale.Father/Husband name')}}</label>
                  <input id="zipcode" type="text" name="father_husband_name" data-error=".errorTxt2" value="{{(isset($usermeta[0]->father_husband_name)) ? $usermeta[0]->father_husband_name : old('father_husband_name')}}">
                  <small class="errorTxt2"></small>
                </div>
                <div class="input-field col m6 s12">
                  <input id="datepicker" class="validate datepicker" name="dob" type="text"  data-error=".errorTxt1" value="{{(isset($usermeta[0]->dob)) ? $usermeta[0]->dob : old('dob')}}">
                  <label for="name">{{__('locale.dob')}}</label>
                  <small class="errorTxt1"></small>
                </div>
                <div class="input-field col m6 s12">
                    <select name="marital_status" id="marital_status">
                    <option value="">Choose {{__('locale.marital_status')}}</option>
                    <option value="married">{{__('locale.married')}}</option>
                    <option value="unmarried">{{__('locale.unmarried')}}</option>
                    </select>
                    <label>{{__('locale.marital_status')}}</label>
                </div>
                <div class="input-field col m6 s12">
                  <label for="Zip Code">{{__('locale.anniversary')}}</label>
                  <input id="" type="text" name="anniversary"  id="datepicker" class="validate datepicker" data-error=".errorTxt2" value="{{(isset($usermeta[0]->anniversary)) ? $usermeta[0]->anniversary : old('anniversary')}}">
                  <small class="errorTxt2"></small>
                </div>
                <div class="input-field col m6 s12">
                  <label for="Zip Code">{{__('locale.special_instructions')}}</label>
                  <input id="" type="text" name="special_instructions"  data-error=".errorTxt2" value="{{(isset($usermeta[0]->special_instructions)) ? $usermeta[0]->special_instructions : old('special_instructions')}}">
                  <small class="errorTxt2"></small>
                </div>
                


                

                <!-- <div class="input-field col m6 s12">
                  <label for="userLicense">{{__('locale.userLicense')}}*</label>
                  <input id="userLicense" type="text" name="address1" data-error=".errorTxt3" value="{{(isset($company_result->userLicense)) ? $company_result->userLicense : old('userLicense')}}">
                  <small class="errorTxt3"></small>
                </div>
                
                <div class="input-field col m6 s12">
                  <label for="licensefrom">{{__('locale.licensefrom')}}*</label>
                  <input id="licensefrom" type="text" name="address1" data-error=".errorTxt3" value="{{(isset($company_result->userLicense)) ? $company_result->userLicense : old('userLicense')}}">
                  <small class="errorTxt3"></small>
                </div>

                <div class="input-field col m6 s12">
                  <label for="licenseto">{{__('locale.licenseto')}}*</label>
                  <input id="licenseto" type="text" name="address1" data-error=".errorTxt3" value="{{(isset($company_result->userLicense)) ? $company_result->userLicense : old('userLicense')}}">
                  <small class="errorTxt3"></small>
                </div> -->




                <div class="input-field col m6 s12">
                    <select name="option_for_block" id="option_for_block">
                    <option value="">Choose {{__('locale.option')}}</option>
                    <option value="1">{{__('locale.yes')}}</option>
                    <option value="0">{{__('locale.no')}}</option>
                    </select>
                    <label>{{__('locale.block')}}</label>
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
    var country_value = "{{(isset($user_result->country) && $user_result->country!='NULL') ? $user_result->country : old('country')}}";
    var country_value_edit = "{{(isset($user_result->country) && $user_result->country!='NULL') ? $user_result->country : ''}}";
    var state_value = "{{(isset($user_result->state) && $user_result->state!='NULL') ? $user_result->state : old('state')}}";
    var city_value = "{{(isset($user_result->city) && $user_result->city!='NULL') ? $user_result->city : old('state')}}";
    var company_value = "{{(isset($user_result->company[0]->id) && $user_result->company[0]->id!='NULL') ? $user_result->company[0]->id : old('company')}}";
    var option_for_block = "{{(isset($user_result->option_for_block) && $user_result->option_for_block!='NULL') ? $user_result->option_for_block : old('option_for_block')}}";
    console.log(state_value);
    $('#country').val(country_value);
    $('#country').formSelect();
    $('#state').val(state_value);
    $('#state').formSelect();
    $('#city').val(city_value);
    $('#city').formSelect();
    $('#option_for_block').val(option_for_block);
    $('#option_for_block').formSelect();
    $('#company').val(company_value);
    if(country_value_edit && country_value_edit!=''){
      $('#company').attr('disabled',true);
    }
    $('#company').formSelect();
  }
    $(document).ready(function () {
      

        $('#country').on('change', function () {
            var idCountry = this.value;
            console.log(idCountry);
            $("#state").html('');
            $.ajax({
                url: "{{url('api/fetch-states')}}",
                type: "POST",
                data: {
                    country_id: idCountry,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#state').html('<option value="">Select State</option>');
                    $.each(result.states, function (key, value) {
                        $("#state").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                    $('#state').formSelect();
                    $('#city').html('<option value="">Select City</option>');
                }
            });
        });
        $('#state').on('change', function () {
            var idState = this.value;
            $("#city").html('');
            $.ajax({
                url: "{{url('api/fetch-cities')}}",
                type: "POST",
                data: {
                    state_id: idState,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#city').html('<option value="">Select City</option>');
                    $.each(res.cities, function (key, value) {
                        $("#city").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                    $('#city').formSelect();
                }
            });
        });



$('.mobile-valid').on('keypress', function(e) {

var $this = $(this);
var regex = new RegExp("^[0-9\b]+$");
var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
// for 10 digit number only
if ($this.val().length > 13) {
    e.preventDefault();
    return false;
}
if (e.charCode < 54 && e.charCode > 47) {
    if ($this.val().length == 0) {
        e.preventDefault();
        return false;
    } else {
        return true;
    }

}
if (regex.test(str)) {
    return true;
}
e.preventDefault();
return false;
});

$('.zip-valid').on('keypress', function(e) {

var $this = $(this);
var regex = new RegExp("^[0-9\b]+$");
var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
// for 10 digit number only
if ($this.val().length > 9) {
    e.preventDefault();
    return false;
}
if (e.charCode < 52 && e.charCode > 47) {
    if ($this.val().length == 0) {
        e.preventDefault();
        return false;
    } else {
        return true;
    }

}
if (regex.test(str)) {
    return true;
}
e.preventDefault();
return false;
});

});
</script>
@endsection