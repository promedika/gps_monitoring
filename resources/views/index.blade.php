@extends('master')
@section('title')
    Home
@endsection
@section('content')
    <div class="row">

<div class="col-xl-6 mb-3">

<div class="card text-white text-opacity-70 h-100 overflow-hidden">

<div class="card-img-overlay d-block d-lg-none bg-blue rounded"></div>


<div class="card-img-overlay d-none d-md-block bg-blue rounded mb-n1 mx-n1" style="background-image: url(assets/img/bg/wave-bg.png); background-position: right bottom; background-repeat: no-repeat; background-size: 100%;"></div>


<div class="card-img-overlay d-none d-md-block bottom-0 top-auto">
<div class="row">
<div class="col-md-8 col-xl-6"></div>
<div class="col-md-4 col-xl-6 mb-n2">
<img src="assets/img/page/dashboard.svg" alt="" class="d-block ms-n3 mb-5" style="max-height: 310px" />
</div>
</div>
</div>


<div class="card-body position-relative">

<div class="row">

<div class="col-md-8">
<div class="d-flex">
<div class="me-auto">
{{-- <h5 class="text-white text-opacity-80 mb-3">Weekly Earning</h5>
<h3 class="text-white mt-n1 mb-1">$2,999.80</h3>
<p class="mb-1 text-white text-opacity-60 text-truncate">
<i class="fa fa-caret-up"></i> <b>32%</b> increase compare to last week
</p> --}}
</div>
</div>

<div class="row">
<div class="col-6 col-lg-5">
<div class="mt-1">
{{-- <i class="fa fa-fw fa-shopping-bag fs-28px text-black text-opacity-50"></i>
</div>
<div class="mt-1">
<div>Store Sales</div>
<div class="fw-600 text-white">$1,629.80</div> --}}
</div>
</div>
<div class="col-6 col-lg-5">
<div class="mt-1">
{{-- <i class="fa fa-fw fa-retweet fs-28px text-black text-opacity-50"></i> --}}
</div>
<div class="mt-1">
{{-- <div>Referral Sales</div>
<div class="fw-600 text-white">$700.00</div> --}}
</div>
</div>
</div>
	{{-- <div class="mt-3 mb-2">
	<a href="#" class="btn btn-yellow btn-rounded btn-sm ps-5 pe-5 pt-2 pb-2 fs-14px fw-600"><i class="fa fa-wallet me-2 ms-n2"></i> Withdraw money</a>
	</div>
	<p class="fs-12px">
	It usually takes 3-5 business days for transferring the earning to your bank account.
	</p> --}}
</div>


<div class="col-md-4 d-none d-md-block" style="min-height: 380px;"></div>

</div>

</div>

</div>

</div>


<div class="col-xl-6">

<div class="row">

<div class="col-sm-6">

<div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-orange" style="min-height: 199px;">
	
<div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
<img src="assets/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 105px" />
</div>


<div class="card-body position-relative">
<h5 class="text-white text-opacity-80 mb-3 fs-16px">New Member</h5>
<h3 class="text-white mt-n1">56</h3>
<div class="progress bg-black bg-opacity-50 mb-2" style="height: 6px">
 <div class="progrss-bar progress-bar-striped bg-white" style="width: 80%"></div>
</div>
<div class="text-white text-opacity-80 mb-4"><i class="fa fa-caret-up"></i> 16% increase <br />compare to last week</div>
<div><a href="#" class="text-white d-flex align-items-center text-decoration-none">View report <i class="fa fa-chevron-right ms-2 text-white text-opacity-50"></i></a></div>
</div>

</div>


<div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-teal" style="min-height: 199px;">

<div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
<img src="assets/img/icon/visitor.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 105px" />
</div>


<div class="card-body position-relative">
<h5 class="text-white text-opacity-80 mb-3 fs-16px">Male</h5>
<h3 class="text-white mt-n1">60.5k</h3>
<div class="progress bg-black bg-opacity-50 mb-2" style="height: 6px">
<div class="progrss-bar progress-bar-striped bg-white" style="width: 50%"></div>
</div>
<div class="text-white text-opacity-80 mb-4"><i class="fa fa-caret-up"></i> 33% increase <br />compare to last week</div>
<div><a href="#" class="text-white d-flex align-items-center text-decoration-none">View report <i class="fa fa-chevron-right ms-2 text-white text-opacity-50"></i></a></div>
</div>

</div>

</div>


<div class="col-sm-6">

<div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-pink" style="min-height: 199px;">

<div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
<img src="assets/img/icon/email.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 105px" />
</div>


<div class="card-body position-relative">
<h5 class="text-white text-opacity-80 mb-3 fs-16px">Total Member</h5>
<h3 class="text-white mt-n1">30</h3>
<div class="progress bg-black bg-opacity-50 mb-2" style="height: 6px">
<div class="progrss-bar progress-bar-striped bg-white" style="width: 80%"></div>
</div>
<div class="text-white text-opacity-80 mb-4"><i class="fa fa-caret-down"></i> 5% decrease <br />compare to last week</div>
<div><a href="#" class="text-white d-flex align-items-center text-decoration-none">View report <i class="fa fa-chevron-right ms-2 text-white text-opacity-50"></i></a></div>
</div>

</div>


<div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-indigo" style="min-height: 199px;">

<div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
<img src="assets/img/icon/browser.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 105px" />
</div>


<div class="card-body position-relative">
<h5 class="text-white text-opacity-80 mb-3 fs-16px">Female</h5>
<h3 class="text-white mt-n1">320.4k</h3>
<div class="progress bg-black bg-opacity-50 mb-2" style="height: 6px">
<div class="progrss-bar progress-bar-striped bg-white" style="width: 80%"></div>
</div>
<div class="text-white text-opacity-80 mb-4"><i class="fa fa-caret-up"></i> 20% increase <br />compare to last week</div>
<div><a href="#" class="text-white d-flex align-items-center text-decoration-none">View report <i class="fa fa-chevron-right ms-2 text-white text-opacity-50"></i></a></div>
</div>

</div>

</div>

</div>

</div>

</div>

</div>
@endsection