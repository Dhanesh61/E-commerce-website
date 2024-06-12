@extends('layouts.admin-leyout')

@section('content')
<style>
    .web-bg{
        background-color:chartreuse; 
    }
    .pro-icon{
        margin-left: 250px;
        font-size: 80px;
        margin-block-start: -100px;
    }
    .mobile-bg{
        background-color:mediumvioletred; 
    }
    .ele-bg{
        background-color:darkkhaki;
    }
    .men-bg{
        background-color:rosybrown;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-4 col-6" onclick="window.location.href = '{{ route('product.index') }}';" style="cursor: pointer;">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $productCount }}</h3>
                        <p>Products</p>
                        <div class="pro-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6" onclick="window.location.href = '{{ route('purchase') }}';" style="cursor: pointer;">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $purchaseCount }}</h3>
                        <p>Orders</p>
                        <div class="pro-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6" onclick="window.location.href = '{{ route('adminexcel') }}';" style="cursor: pointer;">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $excelCount }}</h3>
                        <p>Excel Data</p>
                        <div class="pro-icon">
                            <i class="fas fa-file-excel"></i>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6" onclick="window.location.href = '{{ route('adminroom') }}';" style="cursor: pointer;">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $roomCount }}</h3>
                        <p>Room Booking</p>
                        <div class="pro-icon">
                            <i class="fas fa-door-open"></i>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6" onclick="window.location.href = '{{ route('website') }}';" style="cursor: pointer;">
                <div class="small-box web-bg">
                    <div class="inner">
                        <h3>{{ $websiteCount }}</h3>
                        <p>Website</p>
                        <div class="pro-icon">
                            <i class="fas fa-globe"></i> 
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6" onclick="window.location.href = '{{ route('adminmobile') }}';" style="cursor: pointer;">
                <div class="small-box mobile-bg">
                    <div class="inner">
                        <h3>{{ $mobileCount }}</h3>
                        <p>Mobile</p>
                        <div class="pro-icon">
                            <i class="fas fa-mobile-alt"></i> 
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6" onclick="window.location.href = '{{ route('adminElectronics') }}';" style="cursor: pointer;">
                <div class="small-box ele-bg">
                    <div class="inner">
                        <h3>{{ $electronicsCount }}</h3>
                        <p>Electronics</p>
                        <div class="pro-icon">
                            <i class="fas fa-plug"></i> 
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6" onclick="window.location.href = '{{ route('adminmens') }}';" style="cursor: pointer;">
                <div class="small-box men-bg">
                    <div class="inner">
                        <h3>{{ $menCount }}</h3>
                        <p>Men's Ware</p>
                        <div class="pro-icon">
                            <i class="fas fa-male"></i>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
