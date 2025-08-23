@extends('vendor.installer.layouts.master')

@section('template_title')
    Install Signal
@endsection

@section('title')
Install Signal
@endsection

@section('container')
    <p class="text-center">
    Easy Installation and Setup Wizard.
    </p>
    <p class="text-center">
      <a href="{{ route('LaravelInstaller::requirements') }}" class="button">
      Check Requirements
        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
      </a>
    </p>
@endsection
