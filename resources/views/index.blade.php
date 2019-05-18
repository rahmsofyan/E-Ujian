@extends('layouts.main')

@section('title')
    Attendance Web Service
@endsection

@section('contents')

<div class="row">
<div class="col bg-image my-20" style="background-image: url('assets/img/photos/informatika.png');">
    <div class="bg-black-op-75">
        <div class="content content-top content-full text-center">
            <div class="py-20">
                <h1 class="h2 font-w700 text-white mb-10">Attendance Web Service</h1>
                <h2 class="h4 font-w400 text-white-op mb-0">Online Web Based Attendance Management</h2>
            </div>
        </div>
    </div>
</div>
</div>

<div class="row gutters-tiny">
    <!-- Row #6 -->
    @if(\Auth::check())
    @if (is_null(\Auth::user()->getPIC())==false && \Auth::user()->getPIC()->exists())
    <div class="col-md-6 col-xl-4">
            <a class="block block-transparent" style="text-decoration: none;"  href="{{url('/myagenda')}}">
                <div class="block-content block-content-full bg-success text-center">
                    <div class="item item-2x item-circle bg-black-op-10 mx-auto mb-20">
                        <i class="fa fa-user text-corporate-lighter"></i>
                    </div>
                    <div class="font-size-h3 font-w600 text-white">MyAgenda</div>
                </div>
            </a>
        </div>
    @endif
    @endif
    <div class="col-md-6 col-xl-4">
        <a class="block block-transparent" style="text-decoration: none;"  href="{{url('/download')}}">
            <div class="block-content block-content-full bg-corporate text-center">
                <div class="item item-2x item-circle bg-black-op-10 mx-auto mb-20">
                    <i class="fa fa-user text-corporate-lighter"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white">DownLoad APK</div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-4">
        <a class="block block-transparent" style="text-decoration: none;" href="{{route('pic')}}">
            <div class="block-content block-content-full bg-danger text-center">
                <div class="item item-2x item-circle bg-black-op-10 mx-auto mb-20">
                    <i class="fa fa-users text-danger-light"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white">PIC</div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-4">
        <a class="block block-transparent" style="text-decoration: none;" href="{{route('ruang')}}">
            <div class="block-content block-content-full bg-elegance text-center">
                <div class="item item-2x item-circle bg-black-op-10 mx-auto mb-20">
                    <i class="fa fa-book text-elegance-lighter"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white">Ruang</div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-4">
        <a class="block block-transparent" style="text-decoration: none;" href="{{route('agenda')}}">
            <div class="block-content block-content-full bg-elegance text-center">
                <div class="item item-2x item-circle bg-black-op-10 mx-auto mb-20">
                    <i class="fa fa-calendar text-elegance-lighter"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white">Agenda</div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-4">
        <a class="block block-transparent" style="text-decoration: none;" href="{{route('log')}}">
            <div class="block-content block-content-full bg-corporate text-center">
                <div class="item item-2x item-circle bg-black-op-10 mx-auto mb-20">
                    <i class="fa fa-list text-corporate-lighter"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white">Log Attendance</div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-4">
        <a class="block block-transparent" style="text-decoration: none;" href="{{route('absenKuliah')}}">
            <div class="block-content block-content-full bg-danger text-center">
                <div class="item item-2x item-circle bg-black-op-10 mx-auto mb-20">
                    <i class="fa fa-check text-danger-light"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white">Absen Kehadiran</div>
            </div>
        </a>
    </div>
    
@endsection

